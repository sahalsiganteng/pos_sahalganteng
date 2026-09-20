<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()
            ->with('user')
            // Filter berdasarkan role
            ->when($user->role && strtolower($user->role->name) === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // Search nama user
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SearchRequest $request)
    {
        // "Transaksi Baru" SELALU membuat keranjang baru yang kosong (tidak pernah
        // melanjutkan transaksi OPEN lama), lalu langsung redirect ke halaman edit
        // transaksi tsb. Dengan begitu ID transaksi tertanam di URL address bar
        // (bukan cuma di hidden input), sehingga aksi tambah/kurang/hapus produk
        // dan pencarian selanjutnya selalu kembali ke transaksi yang benar --
        // tidak lagi bergantung pada header Referer yang gampang meleset.
        $sale = Penjualan::create([
            'user_id'           => Auth::id(),
            'total_pembayaran'  => 0,
            'metode_pembayaran' => 'CASH',
            'status'            => 'OPEN',
        ]);

        return redirect()->route('penjualan.edit', $sale->id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        $sale = $penjualan;

        // Load relasi user dan itemPenjualan beserta produknya
        $penjualan->load(['user', 'itemPenjualan.produk']);
        
        $produk = Produk::orderBy('nama')->get();
        $mode = 'view';

        return view('penjualan.detail', compact('penjualan', 'sale', 'produk', 'mode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SearchRequest $request, Penjualan $penjualan)
    {
        $sale = $penjualan;

        // MENGATASI ERROR 403: Redirect ramah jika status transaksi sudah COMPLETED
        if ($sale->status === 'COMPLETED') {
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah selesai tidak dapat diubah.');
        }

        $sale->load(['user', 'itemPenjualan.produk']);

        $keyword = $request->input('search');

        if ($keyword) {
            $produk = Produk::where('nama', 'like', '%' . $keyword . '%')
                ->orderBy('nama')
                ->get();
        } else {
            $produk = Produk::orderBy('nama')->get();
        }

        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'penjualan', 'produk', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS,TRANSFER',
            'cash_given'      => 'nullable|required_if:payment_method,CASH|integer|min:0',
        ], [
            'payment_method.required' => 'Silahkan pilih metode pembayaran terlebih dahulu.',
            'payment_method.in'       => 'Pilihan metode pembayaran tidak valid.',
            'cash_given.required_if'  => 'Silahkan masukkan jumlah uang tunai yang diterima.',
            'cash_given.integer'      => 'Jumlah uang tunai tidak valid.',
            'cash_given.min'          => 'Jumlah uang tunai tidak valid.',
        ]);

        if ($penjualan->status !== 'OPEN') {
            return back()->with('error', 'Transaksi sudah diproses.');
        }

        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        // Hitung ulang total di server (jangan percaya nilai dari client)
        $total = $penjualan->itemPenjualan()->sum('subtotal');

        $cashGiven = null;
        $kembalian = null;

        if ($request->payment_method === 'CASH') {
            $cashGiven = (int) $request->cash_given;

            if ($cashGiven < $total) {
                return back()
                    ->withInput()
                    ->with('error', 'Uang tunai yang diterima kurang dari total tagihan.');
            }

            $kembalian = $cashGiven - $total;
        }

        DB::transaction(function () use ($penjualan, $request, $total, $cashGiven, $kembalian) {
            $penjualan->update([
                'metode_pembayaran' => $request->payment_method,
                'total_pembayaran'  => $total,
                'cash_given'        => $cashGiven,
                'kembalian'         => $kembalian,
                'status'            => 'COMPLETED'
            ]);
        });

        // Arahkan langsung ke halaman cetak nota agar kasir bisa langsung print
        return redirect()
            ->route('penjualan.struk', $penjualan->id)
            ->with('success', 'Transaksi berhasil diselesaikan.');
    }

    /**
     * Tampilkan nota / struk transaksi untuk dicetak.
     */
    public function struk(Penjualan $penjualan)
    {
        if ($penjualan->status !== 'COMPLETED') {
            return redirect()
                ->route('penjualan.edit', $penjualan->id)
                ->with('error', 'Transaksi belum diselesaikan, silahkan checkout terlebih dahulu sebelum mencetak nota.');
        }

        $penjualan->load(['user', 'itemPenjualan.produk']);

        return view('penjualan.struk', [
            'sale' => $penjualan,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        if ($penjualan->status !== 'OPEN') {
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Transaksi sudah selesai tidak bisa dibatalkan.');
        }

        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->itemPenjualan as $item) {
                if ($item->produk) {
                    $item->produk->increment('stok', $item->kuantitas ?? $item->jumlah ?? 0);
                }
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}