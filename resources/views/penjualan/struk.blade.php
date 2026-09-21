@extends('layouts.app')

@section('title', 'Cetak Nota - Toko Perintis')

@push('styles')
<style>
    /* ============== TAMPILAN LAYAR (SEBELUM DICETAK) ============== */
    .struk-page-wrapper {
        display: flex;
        justify-content: center;
    }

    .struk-paper {
        width: 100%;
        max-width: 380px;
        background: #ffffff;
        color: #111111;
        border-radius: 10px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        padding: 22px 20px;
        font-family: 'Courier New', Courier, monospace;
    }

    .struk-center {
        text-align: center;
    }

    .struk-toko-nama {
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .struk-toko-info {
        font-size: 0.72rem;
        color: #333;
        line-height: 1.4;
    }

    .struk-divider {
        border-top: 1px dashed #888;
        margin: 12px 0;
    }

    .struk-meta {
        font-size: 0.78rem;
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }

    .struk-status-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 2px 10px;
        border-radius: 999px;
        background: #16a34a;
        color: #fff;
        margin-top: 4px;
    }

    .struk-items table {
        width: 100%;
        font-size: 0.78rem;
        border-collapse: collapse;
    }

    .struk-items td {
        padding: 3px 0;
        vertical-align: top;
    }

    .struk-item-name {
        font-weight: 700;
    }

    .struk-item-sub {
        color: #444;
        font-size: 0.72rem;
    }

    .struk-text-end {
        text-align: right;
        white-space: nowrap;
    }

    .struk-total-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        margin-bottom: 3px;
    }

    .struk-total-row.grand {
        font-size: 1.05rem;
        font-weight: 800;
        border-top: 1px dashed #888;
        margin-top: 6px;
        padding-top: 8px;
    }

    .struk-footer {
        font-size: 0.75rem;
        margin-top: 14px;
    }

    .struk-actions {
        max-width: 380px;
        margin: 16px auto 0 auto;
    }

    /* ============== TAMPILAN SAAT DICETAK ============== */
    @media print {
        nav.custom-navbar,
        .container.pt-3,
        .struk-actions,
        .no-print {
            display: none !important;
        }

        body {
            background: #ffffff !important;
        }

        .struk-page-wrapper {
            display: block !important;
        }

        .struk-paper {
            box-shadow: none !important;
            border-radius: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            color: #000 !important;
        }

        @page {
            size: 80mm auto;
            margin: 4mm;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 py-4">

    <div class="struk-page-wrapper">
        <div class="struk-paper" id="struk-paper">

            {{-- Header Toko --}}
            <div class="struk-center">
                <div class="struk-toko-nama">TOKO PERINTIS</div>
                <div class="struk-toko-info">
                    Jl. Raya Toko No. 123, Tasikmalaya<br>
                    WA: +62 812-3456-7890
                </div>
                <span class="struk-status-badge">TRANSAKSI SELESAI</span>
            </div>

            <div class="struk-divider"></div>

            {{-- Meta Transaksi --}}
            <div class="struk-meta">
                <span>No. Transaksi</span>
                <span>#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="struk-meta">
                <span>Tanggal</span>
                <span>{{ \Carbon\Carbon::parse($sale->updated_at)->translatedFormat('d M Y, H:i') }}</span>
            </div>
            <div class="struk-meta">
                <span>Kasir</span>
                <span>{{ $sale->user->name ?? '-' }}</span>
            </div>

            <div class="struk-divider"></div>

            {{-- Daftar Item --}}
            <div class="struk-items">
                <table>
                    @forelse($sale->itemPenjualan as $item)
                    <tr>
                        <td colspan="2">
                            <div class="struk-item-name">{{ $item->produk->nama ?? 'Produk Dihapus' }}</div>
                            <div class="struk-item-sub">
                                {{ $item->kuantitas }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="struk-text-end">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="struk-center">Tidak ada item.</td>
                    </tr>
                    @endforelse
                </table>
            </div>

            <div class="struk-divider"></div>

            {{-- Ringkasan Pembayaran --}}
            <div class="struk-total-row grand">
                <span>TOTAL</span>
                <span>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</span>
            </div>

            <div class="struk-total-row">
                <span>Metode Bayar</span>
                <span>{{ strtoupper($sale->metode_pembayaran) }}</span>
            </div>

            @if(strtoupper($sale->metode_pembayaran) === 'CASH' && !is_null($sale->cash_given))
            <div class="struk-total-row">
                <span>Tunai Diterima</span>
                <span>Rp {{ number_format($sale->cash_given, 0, ',', '.') }}</span>
            </div>
            <div class="struk-total-row">
                <span>Kembalian</span>
                <span>Rp {{ number_format($sale->kembalian, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="struk-divider"></div>

            <div class="struk-center struk-footer">
                Terima kasih telah berbelanja di Toko Perintis.<br>
                Barang yang sudah dibeli tidak dapat dikembalikan.
            </div>
        </div>
    </div>

    {{-- Aksi (tidak ikut tercetak) --}}
    <div class="struk-actions no-print d-flex flex-column flex-sm-row gap-2">
        <button type="button" id="btn-print-struk" class="btn btn-primary flex-fill py-2 fw-bold d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-printer-fill"></i> Cetak Nota
        </button>
        <a href="{{ route('penjualan.create') }}" class="btn btn-success flex-fill py-2 fw-bold d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Transaksi Baru
        </a>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary flex-fill py-2 fw-bold d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-list-ul"></i> Daftar Penjualan
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnPrint = document.getElementById('btn-print-struk');
        if (btnPrint) {
            btnPrint.addEventListener('click', function () {
                const metodePembayaran = "{{ strtoupper($sale->metode_pembayaran) }}";

                // Jika Anda ingin SEMUA jenis pembayaran dikonfirmasi dulu sebelum cetak:
                if (typeof Swal !== 'undefined') {
                    let titleText = 'Cetak Nota Transaksi?';
                    let descText = 'Pastikan data pesanan dan pembayaran sudah sesuai sebelum mencetak.';

                    // Kustom teks khusus jika QRIS
                    if (metodePembayaran === 'QRIS') {
                        titleText = 'Konfirmasi Pembayaran QRIS';
                        descText = 'Pastikan dana dari pembayaran QRIS sudah masuk/terkonfirmasi sebelum mencetak struk.';
                    }

                    Swal.fire({
                        title: titleText,
                        text: descText,
                        icon: 'question',
                        iconColor: '#38bdf8',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Lanjutkan Cetak',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'dark-theme-popup',
                            confirmButton: 'swal2-confirm-btn',
                            cancelButton: 'swal2-cancel-btn'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.print();
                        }
                    });
                } else {
                    // Fallback jika SweetAlert tidak ter-load
                    if (confirm('Lanjutkan mencetak struk transaksi ini?')) {
                        window.print();
                    }
                }
            });
        }
    });
</script>
@endpush