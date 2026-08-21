@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="container">
        
        <!-- Header Judul Halaman -->
        <div class="mb-4">
            <h3 class="fw-bold text-white d-flex align-items-center gap-2">
                <i class="bi bi-person-badge text-primary"></i> Tentang Saya & Aplikasi
            </h3>
            <p class="text-muted small">Informasi pengembang dan detail teknis sistem POS.</p>
        </div>

        <!-- Card Utama -->
        <div class="card border-0 shadow-lg rounded-4 text-white p-4 p-md-5" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08) !important;">
            
            <div class="row align-items-center g-4">
                <!-- Bagian Foto Profil -->
                <div class="col-lg-3 text-center">
                    <div class="position-relative d-inline-block">
                        <div class="rounded-circle overflow-hidden border border-3 border-primary shadow" style="width: 150px; height: 150px; background: rgba(99, 102, 241, 0.1);">
                            <!-- Ganti path foto sesuai dengan lokasi gambar Anda di folder public -->
                            <img src="{{ asset('storage/images/foto bg halll.jpeg') }}" alt="Foto Profil sahal" class="w-100 h-100 object-fit-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/150/1e293b/6366f1?text=Bunga';">
                        </div>
                    </div>
                </div>

                <!-- Bagian Informasi Pembuat -->
                <div class="col-lg-9 text-center text-lg-start">
                    <h2 class="fw-bold text-white mb-1">Sahal Ikhan Sanuri</h2>
                    <p class="text-primary fw-medium mb-3">Full Stack Developer & Maintainer</p>
                    
                    <div class="p-3 rounded-3" style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.05);">
                        <p class="text-white small mb-0">
                            "Membangun dan mengembangkan sistem Point of Sales (POS) yang efisien, handal, serta memiliki antarmuka yang modern untuk mendukung operasional bisnis secara optimal."
                        </p>
                    </div>
                </div>
            </div>

            <hr class="border-secondary opacity-25 my-4">

            <!-- Detail Penjelasan Aplikasi & Teknologi -->
            <div class="row g-4">
                
                <!-- Penjelasan Aplikasi -->
                <div class="col-md-6">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.06);">
                        <h5 class="fw-semibold text-white mb-3 d-flex align-items-center gap-2">
                            <span class="p-2 rounded-2" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">🚀</span> 
                            Tentang Aplikasi POS
                        </h5>
                        <p class="text-white small lh-base mb-0">
                            Aplikasi Point of Sales (POS) ini dirancang untuk memudahkan pengelolaan transaksi penjualan harian, 
                            pemantauan stok barang secara real-time, serta pencatatan data produk dan pengguna dengan antarmuka 
                            yang modern, responsif, dan mudah digunakan (User Friendly).
                        </p>
                    </div>
                </div>

                <!-- Spesifikasi Teknologi / Framework -->
                <div class="col-md-6">
                    <div class="p-4 rounded-4 h-100" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.06);">
                        <h5 class="fw-semibold text-white mb-3 d-flex align-items-center gap-2">
                            <span class="p-2 rounded-2" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">⚙️</span> 
                            Stack Teknologi & Bahasa
                        </h5>
                        <ul class="list-unstyled small text-muted mb-0 space-y-2">
                            <li class="mb-2 d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2">
                                <span class="text-light">Bahasa Pemrograman:</span>
                                <strong class="text-primary">PHP & JavaScript</strong>
                            </li>
                            <li class="mb-2 d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2">
                                <span class="text-light">Framework Backend:</span>
                                <strong class="text-primary">Laravel (Blade Engine)</strong>
                            </li>
                            <li class="mb-2 d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2">
                                <span class="text-light">Frontend Style:</span>
                                <strong class="text-primary">Bootstrap 5 & Custom CSS</strong>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-light">Database:</span>
                                <strong class="text-primary">MySQL / MariaDB</strong>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Tombol Navigasi Kembali -->
            <div class="mt-4 text-end">
            </div>

        </div>
    </div>
</div>
@endsection