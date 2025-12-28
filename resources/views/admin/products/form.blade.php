@extends('admin.layouts.app')

@section('page-title', isset($product) ? 'Ürün Düzenle' : 'Yeni Ürün')
@section('page-subtitle', isset($product) ? $product->product_name : 'Yeni ürün ekle')

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="form-group">
            <label class="form-label">Ürün Adı *</label>
            <input type="text" name="product_name" class="form-input" 
                   value="{{ old('product_name', $product->product_name ?? '') }}" required>
            @error('product_name')
                <p style="color: var(--admin-danger); font-size: 0.85rem; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Açıklama</label>
            <textarea name="product_description" class="form-input" rows="3">{{ old('product_description', $product->product_description ?? '') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label class="form-label">Fiyat (₺) *</label>
                <input type="number" name="product_price" class="form-input" step="0.01" min="0"
                       value="{{ old('product_price', $product->product_price ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Stok *</label>
                <input type="number" name="stock" class="form-input" min="0"
                       value="{{ old('stock', $product->stock ?? 0) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Kategori *</label>
            <select name="category_id" class="form-input" required>
                <option value="">Seçin...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Görsel URL *</label>
            <input type="url" name="product_image" class="form-input" 
                   value="{{ old('product_image', $product->product_image ?? '') }}" 
                   placeholder="https://example.com/image.jpg" required>
            @if(isset($product) && $product->product_image)
                <img src="{{ $product->product_image }}" alt="Preview" 
                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; margin-top: 10px;">
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Alerjenler</label>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; background: #f8f9fa; padding: 15px; border-radius: 10px;">
                @foreach($allergens as $allergen)
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                        <input type="checkbox" name="allergens[]" value="{{ $allergen->id }}"
                               {{ (isset($product) && $product->allergens->contains($allergen->id)) ? 'checked' : '' }}>
                        <i class="{{ $allergen->icon }}" style="color: var(--admin-primary);"></i>
                        {{ $allergen->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="status" value="1" 
                       {{ old('status', $product->status ?? true) ? 'checked' : '' }}
                       style="width: 20px; height: 20px;">
                <span>Ürün Aktif</span>
            </label>
        </div>

        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="las la-save"></i>
                {{ isset($product) ? 'Güncelle' : 'Kaydet' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="las la-arrow-left"></i> Geri
            </a>
        </div>
    </form>
</div>
@endsection
