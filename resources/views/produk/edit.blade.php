@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            
            <!-- Header Page -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square text-warning"></i> Edit Produk
                    </h2>
                    <p class="text-secondary mb-0">
                        Perbarui informasi produk <strong class="text-white">{{ $produk->nama }}</strong>.
                    </p>
                </div>
                
            </div>

            <!-- Form Card -->
            <div class="card glass-card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('produk.update', $produk) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $produk->nama) }}" 
                                   placeholder="Contoh: Kopi Susu Gula Aren" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Beli -->
                        <div class="mb-3">
                            <label for="purchase_price" class="form-label">Harga Beli (Rp)</label>
                            <input type="number" 
                                   class="form-control @error('purchase_price') is-invalid @enderror" 
                                   id="purchase_price" 
                                   name="purchase_price" 
                                   value="{{ old('purchase_price', $produk->harga_beli) }}" 
                                   placeholder="Contoh: 10000" 
                                   min="0" 
                                   required>
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Jual -->
                        <div class="mb-3">
                            <label for="selling_price" class="form-label">Harga Jual (Rp)</label>
                            <input type="number" 
                                   class="form-control @error('selling_price') is-invalid @enderror" 
                                   id="selling_price" 
                                   name="selling_price" 
                                   value="{{ old('selling_price', $produk->harga_jual) }}" 
                                   placeholder="Contoh: 15000" 
                                   min="0" 
                                   required>
                            @error('selling_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok Produk</label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $produk->stok) }}" 
                                   placeholder="Contoh: 50" 
                                   min="0" 
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Produk -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Produk (Opsional)</label>
                            <input type="file" 
                                   class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" 
                                   name="foto"
                                   accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($produk->foto)
                                <div class="mt-2">
                                    <small class="text-secondary d-block mb-1">Foto Saat Ini:</small>
                                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="Preview" class="rounded-3" style="max-height: 100px; object-fit: cover;">
                                </div>
                            @endif
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary border-opacity-25">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary text-secondary border-secondary px-4 py-2 rounded-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-neon-warning px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Custom Dark Styling -->
<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .btn-neon-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: #fff;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        transition: all 0.2s ease;
    }
    .btn-neon-warning:hover {
        opacity: 0.9;
        color: #fff;
        transform: translateY(-1px);
    }

    .form-control, .form-select {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #f8fafc !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f59e0b !important;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.3) !important;
    }
    .form-label {
        color: #cbd5e1 !important;
        font-weight: 500;
    }

    .form-control::placeholder {
        color: #64748b !important;
        opacity: 1;
    }
    
    .form-control[type="file"]::file-selector-button {
        background-color: #1e293b;
        color: #cbd5e1;
        border: 0;
        border-right: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.375rem 0.75rem;
        margin-right: 0.75rem;
        transition: background-color 0.2s ease;
    }
    .form-control[type="file"]::file-selector-button:hover {
        background-color: #334155;
        color: #fff;
    }
</style>

@endsection