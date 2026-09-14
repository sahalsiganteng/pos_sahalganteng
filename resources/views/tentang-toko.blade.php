@extends('layouts.app')

@section('title', 'Tentang Toko - Toko ')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white border-0 shadow-lg p-4 rounded-4" style="background: rgba(30, 41, 59, 0.85) !important; border: 1px solid rgba(255, 255, 255, 0.08) !important;">
                <div class="card-body text-center py-4">
                    
                    <div class="d-inline-flex align-items-center justify-content-center mb-3">
                        <div class="brand-icon me-2" style="width: 48px; height: 48px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-shop text-primary fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold mb-2">Toko <span class="text-primary-gradient">Perintis</span></h2>
                    <p class="text-muted mb-4">Solusi Kasir Digital Modern & Terpercaya</p>

                    <hr class="border-secondary opacity-25 my-4">

                    <div class="row text-start g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Alamat</small>
                                <span class="fw-semibold">Jl. Raya Toko No. 123, Tasikmalaya</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-whatsapp text-success me-1"></i> Kontak / WhatsApp</small>
                                <span class="fw-semibold">+62 812-3456-7890</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-envelope-fill text-warning me-1"></i> Email Resmi</small>
                                <span class="fw-semibold">info@aplikasipos.com</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-clock-fill text-info me-1"></i> Jam Operasional</small>
                                <span class="fw-semibold">Senin - Sabtu (08.00 - 21.00)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-3 text-start" style="background: rgba(15, 23, 42, 0.3); border: 1px solid rgba(99, 102, 241, 0.2);">
    <small class="text-primary fw-bold d-block mb-1"><i class="bi bi-info-circle me-1"></i> Deskripsi Toko</small>
    <p class="text-white small mb-0">
        Toko Perintis adalah pusat penyediaan kebutuhan ritel dan barang harian berkualitas yang berkomitmen memberikan pelayanan terbaik bagi pelanggan, khususnya di wilayah Tasikmalaya dan sekitarnya.

Berdiri sebagai usaha modern, Toko Perintis tidak hanya berfokus pada kelengkapan produk, tetapi juga mengutamakan efisiensi dan kenyamanan berbelanja. Dengan dukungan sistem aplikasi Point of Sales (POS) berbasis digital yang terintegrasi, kami memastikan setiap proses transaksi penjualan, pengecekan harga, hingga manajemen stok barang berjalan secara cepat, transparan, dan akurat secara real-time.
    </p>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection