@extends('admin.layouts.app')

@section('page-title', 'Ürünler')
@section('page-subtitle', 'Tüm ürünleri yönetin')

@section('content')
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Ürün Listesi ({{ $products->total() }})</h3>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="las la-plus"></i> Yeni Ürün
            </a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Görsel</th>
                    <th>Ürün Adı</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}"
                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                        </td>
                        <td>
                            <strong>{{ $product->product_name }}</strong>
                            <p style="font-size: 0.85rem; color: var(--admin-text-light); margin-top: 4px;">
                                {{ Str::limit($product->product_description, 50) }}
                            </p>
                        </td>
                        <td>
                            <span
                                style="background: var(--admin-bg); padding: 6px 12px; border-radius: 20px; font-size: 0.85rem;">
                                {{ $product->category->category_name ?? '-' }}
                            </span>
                        </td>
                        <td><strong>{{ number_format($product->product_price, 2) }} ₺</strong></td>
                        <td>
                            @if($product->stock > 10)
                                <span style="color: var(--admin-success);">{{ $product->stock }}</span>
                            @elseif($product->stock > 0)
                                <span style="color: var(--admin-warning);">{{ $product->stock }}</span>
                            @else
                                <span style="color: var(--admin-danger);">Tükendi</span>
                            @endif
                        </td>
                        <td>
                            @if($product->status)
                                <span class="status-badge status-completed">Aktif</span>
                            @else
                                <span class="status-badge status-cancelled">Pasif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">
                                    <i class="las la-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="las la-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                            <i class="las la-utensils" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                            Henüz ürün yok
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($products->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection