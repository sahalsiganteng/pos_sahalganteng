@extends('layouts.app')

@section('title', 'POS - Kasir Modern')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css">

<style>
    /* Reset & Card Wrapper Utama (Dark Glassmorphism) */
    .pos-wrapper {
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: #f8fafc;
    }

    /* Header POS Banner */
    .pos-header-banner {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Card Box Katalog Produk & Keranjang */
    .section-card {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
    }

    /* Item Produk List */
    .product-box {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        padding: 10px 14px;
        transition: all 0.2s ease-in-out;
    }

    .product-box:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
        transform: translateY(-2px);
        background: rgba(30, 41, 59, 0.8);
    }

    /* Table Styling Dark */
    .table-cart {
        background: transparent;
        color: #e2e8f0;
    }

    .table-cart thead th {
        background-color: rgba(15, 23, 42, 0.8);
        color: #94a3b8;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        border-bottom: 2px solid rgba(255, 255, 255, 0.08);
    }

    .table-cart td {
        border-color: rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
    }

    /* Total Box Display */
    .total-box {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
    }

    /* Input & Select Custom Dark */
    .form-control-custom {
        background-color: rgba(15, 23, 42, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        border-radius: 8px;
    }

    .form-control-custom:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
        background-color: rgba(15, 23, 42, 0.95) !important;
    }

    .form-control-custom option {
        background-color: #0f172a;
        color: #f8fafc;
    }

    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.5);
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 4px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    /* Custom Style SweetAlert Dark Glass */
    .swal2-popup {
        background: rgba(15, 23, 42, 0.95) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 16px !important;
        color: #f8fafc !important;
    }

    .swal2-title {
        color: #f8fafc !important;
    }

    .swal2-html-container {
        color: #94a3b8 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="pos-wrapper p-4"> 

        {{-- Header Banner --}}
        <div class="pos-header-banner p-3 p-md-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-shop text-primary"></i> Point of Sale (POS)
                </h3>
                <span class="text-slate-400 fs-7">Kelola dan proses transaksi penjualan secara cepat & presisi</span>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="badge bg-dark text-light border border-secondary px-3 py-2 font-monospace fs-7">
                    ID TR: #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}
                </span>
                <span class="badge {{ $sale->status === 'COMPLETED' ? 'bg-success text-white' : 'bg-warning text-dark' }} px-3 py-2 font-monospace fs-7 fw-bold">
                    {{ strtoupper($sale->status) }}
                </span>
            </div>
        </div>

        <div class="row g-4">

            {{-- ====================== SEKSI KATALOG PRODUK ============================ --}}
            <div class="col-lg-6">
                <div class="section-card p-3 h-100 d-flex flex-column">

                    {{-- Pencarian --}}
                    <div class="mb-3">
                        <form id="search-form" method="GET" action="{{ route('penjualan.create') }}">
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-end-0 border-secondary text-secondary">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text"
                                    id="search-input"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control form-control-custom border-start-0 ps-0"
                                    placeholder="Cari nama produk..."
                                    autocomplete="off">
                            </div>
                        </form>
                    </div>

                    {{-- List Produk --}}
                    <div class="custom-scroll pe-1 flex-grow-1" style="max-height: 60vh; overflow-y: auto;">
                        <div class="d-flex flex-column gap-2">
                            @forelse($produk as $product)
                            <div class="product-box">
                                <form method="POST" action="{{ route('itempenjualan.store') }}" class="row g-2 align-items-center m-0 form-add-product">
                                    @csrf
                                    <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    {{-- Info Produk --}}
                                    <div class="col-5 col-sm-5 d-flex align-items-center gap-3">
                                        <img src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://via.placeholder.com/45' }}"
                                            alt="{{ $product->nama }}"
                                            class="rounded-circle border border-secondary"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                        <div class="overflow-hidden">
                                            <div class="fw-bold text-white text-truncate">{{ $product->nama }}</div>
                                            <span class="fw-bold text-primary fs-7 d-block">
                                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                            </span>
                                            <span class="text-secondary fs-8">Stok: {{ $product->stok }}</span>
                                        </div>
                                    </div>

                                    {{-- Qty Input dengan Batasan Max Stok --}}
                                    <div class="col-4 col-sm-4">
                                        <input type="number"
                                            name="quantity"
                                            value="1"
                                            min="1"
                                            max="{{ $product->stok }}"
                                            class="form-control form-control-custom text-center fw-bold input-qty-limit"
                                            data-max-stok="{{ $product->stok }}"
                                            {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="col-3 col-sm-3">
                                        <button type="submit" 
                                            class="btn {{ $product->stok <= 0 ? 'btn-secondary' : 'btn-primary' }} w-100 fw-bold rounded-2 btn-submit-add" 
                                            {{ ($sale->status === 'COMPLETED' || $product->stok <= 0) ? 'disabled' : '' }}>
                                            <i class="bi bi-plus-lg me-1"></i> <span class="btn-text">{{ $product->stok <= 0 ? 'Habis' : 'Tambah' }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @empty
                            <div class="text-center py-5 text-secondary">
                                <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>
                                Produk tidak ditemukan
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================ SEKSI KERANJANG =========================== --}}
            <div class="col-lg-6">
                <div class="section-card p-3 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-cart3 text-primary"></i> Keranjang Belanja
                            </h5>
                            <span class="badge bg-primary bg-opacity-20 text-primary border border-primary border-opacity-30 rounded-pill px-3">
                                {{ count($sale->itemPenjualan) }} Item
                            </span>
                        </div>

                        {{-- Tabel Keranjang --}}
                        <div class="table-responsive rounded-3 border border-secondary custom-scroll mb-3" style="max-height: 38vh; overflow-y: auto;">
                            <table class="table table-cart align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Produk</th>
                                        <th style="width: 25%;">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                        <th class="text-center" style="width: 12%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sale->itemPenjualan as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold text-white">{{ $item->produk->nama }}</div>
                                            <small class="text-secondary">
                                                Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }} (Stok: {{ $item->produk->stok }})
                                            </small>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                                @csrf 
                                                @method('PUT')
                                                <input type="number"
                                                    name="quantity"
                                                    value="{{ $item->kuantitas }}"
                                                    min="1"
                                                    max="{{ $item->produk->stok }}"
                                                    class="form-control form-control-sm form-control-custom text-center fw-bold input-qty-limit"
                                                    data-max-stok="{{ $item->produk->stok }}"
                                                    onchange="this.form.submit()"
                                                    {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                                            </form>
                                        </td>
                                        <td class="text-end font-monospace fw-bold text-white">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @can('delete', $item)
                                            <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="form-delete-item">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm border-0 btn-delete-item"
                                                    title="Hapus Item"
                                                    {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-secondary">
                                            <i class="bi bi-cart-x fs-1 d-block mb-2 text-secondary"></i>
                                            Keranjang belanja masih kosong
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Section Pembayaran --}}
                    <div class="pt-2">
                        {{-- Ringkasan Total --}}
                        <div class="total-box p-3 mb-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-uppercase fs-7 text-white-50">Total Bayar</span>
                            <span class="fs-2 font-monospace fw-bold">
                                Rp {{ number_format($sale->itemPenjualan->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Form Checkout --}}
                        <form id="checkout-form"
                            method="POST"
                            action="{{ route('penjualan.update', $sale->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <select name="payment_method" class="form-select form-control-custom fw-semibold @error('payment_method') is-invalid @enderror" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="CASH" {{ $sale->payment_method === 'CASH' ? 'selected' : '' }}>CASH (TUNAI)</option>
                                    <option value="QRIS" {{ $sale->payment_method === 'QRIS' ? 'selected' : '' }}>QRIS / NON-TUNAI</option>
                                </select>
                                
                                @error('payment_method')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary w-100 py-2 fw-bold text-uppercase mb-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-arrow-left-circle-fill"></i> Batal / Kembali ke Daftar
                            </a>

                            @if($sale->status !== 'COMPLETED')
                            <button type="button"
                                id="btn-checkout"
                                class="btn btn-success w-100 py-2 fw-bold text-uppercase mb-2 shadow-sm">
                                <i class="bi bi-check-circle-fill me-1"></i> Selesaikan Transaksi (Checkout)
                            </button>
                            @else
                            <button type="button" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase mb-2 shadow-sm" disabled>
                                <i class="bi bi-check-circle-fill me-1"></i> Transaksi Selesai
                            </button>
                            @endif
                        </form>

                        {{-- Hapus / Void Transaksi --}}
                        @can('delete', $sale)
                        @if($sale->status !== 'COMPLETED')
                        <form id="cancel-form"
                            action="{{ route('penjualan.destroy', $sale->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                id="btn-cancel"
                                class="btn btn-danger w-100 py-2 text-uppercase fw-semibold">
                                <i class="bi bi-trash me-1"></i> Hapus Transaksi Ini
                            </button>
                        </form>
                        @endif
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Elemen Data Flash untuk JS --}}
<div id="flash-data" 
    data-success="{{ session('success') }}" 
    data-error="{{ session('error') }}"
    data-errors='@json($errors->any() ? $errors->all() : [])'>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnCheckout = document.getElementById('btn-checkout');
        const btnCancel = document.getElementById('btn-cancel');

        // Flash Data Handling
        const flashData = document.getElementById('flash-data').dataset;
        const successMsg = flashData.success;
        const errorMsg = flashData.error;

        let errorList = [];
        try {
            errorList = JSON.parse(flashData.errors || '[]');
        } catch (e) {
            errorList = [];
        }

        if (successMsg) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMsg,
                timer: 3000,
                showConfirmButton: false
            });
        }

        if (errorMsg) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorMsg
            });
        }

        if (errorList.length > 0) {
            let errorHtml = '<ul class="text-start mb-0">';
            errorList.forEach(err => {
                errorHtml += `<li>${err}</li>`;
            });
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Periksa Inputan Anda!',
                html: errorHtml
            });
        }

        // Validasi Live Input Kuantitas agar Tidak Melebihi Stok
        const qtyInputs = document.querySelectorAll('.input-qty-limit');
        qtyInputs.forEach(input => {
            input.addEventListener('input', function() {
                const maxStok = parseInt(this.dataset.maxStok) || 0;
                let val = parseInt(this.value);

                if (val > maxStok) {
                    this.value = maxStok; // Batasi kembali ke maksimal stok
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: `Stok maksimal hanya tersisa ${maxStok}!`,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else if (val < 1 || isNaN(val)) {
                    // Biarkan kosong dulu saat diketik atau minimal 1
                }
            });
        });

        // Search Input Debounce
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');
        let searchTimeout;

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchForm.submit();
                }, 500);
            });
            
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.focus();
            searchInput.value = val;
        }

        // Proteksi Anti-Spam Tombol Tambah Produk
        const addProductForms = document.querySelectorAll('.form-add-product');
        addProductForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.btn-submit-add');
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return;
                }
                submitBtn.disabled = true;
                const btnTextSpan = submitBtn.querySelector('.btn-text');
                if(btnTextSpan) {
                    btnTextSpan.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...';
                }
            });
        });

        // Konfirmasi Checkout
        if (btnCheckout) {
            btnCheckout.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Selesaikan Transaksi?',
                    text: "Pastikan metode pembayaran dan nominal transaksi sudah sesuai.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="bi bi-check-lg"></i> Ya, Checkout!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('checkout-form').submit();
                    }
                });
            });
        }

        // Konfirmasi Hapus Transaksi
        if (btnCancel) {
            btnCancel.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Transaksi?',
                    text: "Transaksi ini akan dihapus secara permanen beserta seluruh isi keranjang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('cancel-form').submit();
                    }
                });
            });
        }

        // Konfirmasi Hapus Item Individu
        const deleteItemBtns = document.querySelectorAll('.btn-delete-item');
        deleteItemBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.form-delete-item');
                Swal.fire({
                    title: 'Hapus Item?',
                    text: "Item ini akan dihapus dari keranjang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush