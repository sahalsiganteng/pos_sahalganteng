@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white m-0">Detail Penjualan</h2>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-light rounded-3 px-3">
            &larr; Kembali
        </a>
    </div>

    <div class="card bg-dark text-white border-secondary shadow-lg rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row gy-3">
                <div class="col-md-3">
                    <div class="text-white-50 small mb-1">Kasir</div>
                    <div class="fw-bold fs-5 text-capitalize">{{ $sale->user->name ?? '-' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-white-50 small mb-1">Tanggal Transaksi</div>
                    <div class="fw-semibold fs-6">
                        {{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y H:i:s') }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-white-50 small mb-1">Metode Pembayaran</div>
                    <div class="fw-bold fs-6 text-info">
                        {{ $sale->metode_pembayaran ?? 'CASH' }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-white-50 small mb-1">Total Pembayaran</div>
                    <div class="fw-bold fs-4 text-success">
                        Rp {{ number_format($sale->total_pembayaran ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white border-secondary shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-secondary bg-opacity-10 border-bottom border-secondary p-3">
            <h5 class="m-0 fw-bold">Daftar Barang Dibeli</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-secondary text-uppercase small">
                    <tr>
                        <th scope="col" class="text-center py-3" style="width: 60px;">No</th>
                        <th scope="col" class="py-3" style="width: 100px;">Foto</th>
                        <th scope="col" class="py-3">Nama Produk</th>
                        <th scope="col" class="text-center py-3">Jumlah</th>
                        <th scope="col" class="text-end py-3 pe-4">Harga Satuan</th>
                        <th scope="col" class="text-end py-3 pe-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sale->itempenjualan as $index => $item)
                    <tr>
                        <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <div class="bg-secondary bg-opacity-20 rounded p-1 text-center" style="width: 60px; height: 60px;">
                                @if(isset($item->produk->foto))
                                    <img src="{{ asset('storage/' . $item->produk->foto) }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 100%; object-fit: contain;" 
                                         alt="{{ $item->produk->nama }}">
                                @else
                                    <span class="text-white-50 small">No Pic</span>
                                @endif
                            </div>
                        </td>
                        <td class="fw-bold text-capitalize fs-6">
                            {{ $item->produk->nama ?? 'Produk Dihapus' }}
                        </td>
                        <td class="text-center fw-semibold">
                            <span class="badge bg-info text-dark px-2 py-1">{{ $item->kuantitas ?? 1 }}</span>
                        </td>
                        <td class="text-end fw-semibold pe-4">
                            Rp {{ number_format($item->harga_satuan ?? ($item->subtotal / ($item->kuantitas ?? 1)), 0, ',', '.') }}
                        </td>
                        <td class="text-end fw-bold pe-4 text-success">
                            Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-white-50">
                            Tidak ada barang dalam transaksi ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection