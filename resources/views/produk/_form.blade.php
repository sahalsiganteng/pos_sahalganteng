@csrf

<!-- Tampilkan Foto Saat Ini (Jika Mode Edit & Ada Foto) -->
@if (!empty($produk->foto))
    <div class="mb-3">
        <label class="form-label text-secondary small">Foto Saat Ini</label><br>
        <img src="{{ asset('storage/' . $produk->foto) }}"
             width="150"
             alt="{{ $produk->nama ?? 'Foto Produk' }}"
             class="img-thumbnail rounded-3"
             style="background: #0f172a; border-color: rgba(255, 255, 255, 0.15);">
    </div>
@endif

<!-- Upload Foto Baru & Real-time Preview -->
<div class="row mb-3">
    <div class="col-md-6 mb-2 mb-md-0">
        <label class="form-label">Upload Gambar Produk</label>
        <input type="file"
               name="foto"
               onchange="previewImage(this)"
               accept="image/*"
               class="form-control @error('foto') is-invalid @enderror">
        <small class="text-secondary d-block mt-1">Format: JPG, JPEG, PNG (Maks 2MB)</small>
        @error('foto')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Preview Foto Baru</label><br>
        <img id="preview" class="img-thumbnail rounded-3" style="display:none; max-height: 120px; background: #0f172a; border-color: rgba(255, 255, 255, 0.15);" width="150">
    </div>
</div>

<!-- Nama Produk -->
<div class="mb-3">
    <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
    <input type="text" 
           id="name"
           name="name"
           placeholder="Contoh: Kopi Susu Gula Aren, Laptop Asus, dll."
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $produk->nama ?? '') }}"
           required>
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="row">
    <!-- Harga Beli -->
    <div class="col-md-6 mb-3">
        <label for="purchase_price" class="form-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
        <input type="number" 
               id="purchase_price"
               name="purchase_price"
               placeholder="Contoh: 15000"
               min="0"
               class="form-control @error('purchase_price') is-invalid @enderror"
               value="{{ old('purchase_price', $produk->harga_beli ?? '') }}"
               required>
        @error('purchase_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Harga Jual -->
    <div class="col-md-6 mb-3">
        <label for="selling_price" class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
        <input type="number" 
               id="selling_price"
               name="selling_price"
               placeholder="Contoh: 20000"
               min="0"
               class="form-control @error('selling_price') is-invalid @enderror"
               value="{{ old('selling_price', $produk->harga_jual ?? '') }}"
               required>
        @error('selling_price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<!-- Stok -->
<div class="mb-3">
    <label for="stock" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
    <input type="number" 
           id="stock"
           name="stock"
           placeholder="Masukkan jumlah stok (misal: 50)"
           min="0"
           class="form-control @error('stock') is-invalid @enderror"
           value="{{ old('stock', $produk->stok ?? '') }}"
           required>
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
</script>