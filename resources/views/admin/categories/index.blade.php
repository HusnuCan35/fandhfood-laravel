@extends('admin.layouts.app')

@section('page-title', 'Kategoriler')
@section('page-subtitle', 'Ürün kategorilerini yönetin')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px;">
        <!-- Categories List -->
        <div class="admin-card">
            <div class="card-header">
                <h3 class="card-title">Kategori Listesi</h3>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kategori Adı</th>
                        <th>İkon</th>
                        <th>Ürün Sayısı</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <strong>{{ $category->category_name }}</strong>
                            </td>
                            <td>
                                @if($category->category_icon)
                                    <i class="{{ $category->category_icon }}"
                                        style="font-size: 1.5rem; color: var(--admin-primary);"></i>
                                @else
                                    <span style="color: var(--admin-text-light);">-</span>
                                @endif
                            </td>
                            <td>
                                <span style="background: var(--admin-bg); padding: 6px 12px; border-radius: 20px;">
                                    {{ $category->products_count }} ürün
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button class="btn btn-secondary btn-sm"
                                        onclick="editCategory({{ $category->id }}, '{{ $category->category_name }}', '{{ $category->category_icon }}')">
                                        <i class="las la-edit"></i>
                                    </button>
                                    @if($category->products_count == 0)
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                                <i class="las la-layer-group" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                                Henüz kategori yok
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Category Form -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;" id="formTitle">Yeni Kategori</h3>

            <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label class="form-label">Kategori Adı *</label>
                    <input type="text" name="category_name" id="categoryName" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">İkon (Line Awesome)</label>
                    <input type="text" name="category_icon" id="categoryIcon" class="form-input"
                        placeholder="las la-utensils">
                    <p style="font-size: 0.85rem; color: var(--admin-text-light); margin-top: 5px;">
                        Örnek: las la-pizza-slice, las la-coffee
                    </p>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="las la-save"></i> Kaydet
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()" style="display: none;"
                        id="cancelBtn">
                        İptal
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function editCategory(id, name, icon) {
                document.getElementById('formTitle').textContent = 'Kategori Düzenle';
                document.getElementById('categoryName').value = name;
                document.getElementById('categoryIcon').value = icon || '';
                document.getElementById('categoryForm').action = '/admin/categories/' + id;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('cancelBtn').style.display = 'block';
            }

            function resetForm() {
                document.getElementById('formTitle').textContent = 'Yeni Kategori';
                document.getElementById('categoryName').value = '';
                document.getElementById('categoryIcon').value = '';
                document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('cancelBtn').style.display = 'none';
            }
        </script>
    @endpush
@endsection