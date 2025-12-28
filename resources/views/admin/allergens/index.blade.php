@extends('admin.layouts.app')

@section('page-title', 'Alerjenler')
@section('page-subtitle', 'Ürün alerjenlerini ve ikonlarını yönetin')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px;">
        <!-- Allergens List -->
        <div class="admin-card">
            <div class="card-header">
                <h3 class="card-title">Alerjen Listesi</h3>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Alerjen Adı</th>
                        <th>İkon</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allergens as $allergen)
                        <tr>
                            <td>
                                <strong>{{ $allergen->name }}</strong>
                            </td>
                            <td>
                                @if($allergen->icon)
                                    <i class="{{ $allergen->icon }}" style="font-size: 1.5rem; color: var(--admin-primary);"></i>
                                    <span style="font-size: 0.8rem; color: #888; margin-left:10px">{{ $allergen->icon }}</span>
                                @else
                                    <span style="color: var(--admin-text-light);">-</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button class="btn btn-secondary btn-sm"
                                        onclick="editAllergen({{ $allergen->id }}, '{{ $allergen->name }}', '{{ $allergen->icon }}')">
                                        <i class="las la-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.allergens.destroy', $allergen) }}" method="POST"
                                        onsubmit="return confirm('Bu alerjeni silmek istediğinize emin misiniz?')">
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
                            <td colspan="3" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                                <i class="las la-exclamation-triangle"
                                    style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                                Henüz alerjen tanımlanmamış
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Allergen Form -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;" id="formTitle">Yeni Alerjen</h3>

            <form id="allergenForm" action="{{ route('admin.allergens.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label class="form-label">Alerjen Adı *</label>
                    <input type="text" name="name" id="allergenName" class="form-input" required placeholder="Örn: Gluten">
                </div>

                <div class="form-group">
                    <label class="form-label">İkon (Line Awesome)</label>
                    <input type="text" name="icon" id="allergenIcon" class="form-input" placeholder="las la-wheat">
                    <p style="font-size: 0.85rem; color: var(--admin-text-light); margin-top: 5px;">
                        Kullanılabilir ikonlar: <br>
                        Gluten: `las la-wheat`<br>
                        Süt: `las la-cheese`<br>
                        Fındık: `las la-seedling`<br>
                        Yumurta: `las la-egg`
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
            function editAllergen(id, name, icon) {
                document.getElementById('formTitle').textContent = 'Alerjen Düzenle';
                document.getElementById('allergenName').value = name;
                document.getElementById('allergenIcon').value = icon || '';
                document.getElementById('allergenForm').action = '/admin/allergens/' + id;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('cancelBtn').style.display = 'block';
            }

            function resetForm() {
                document.getElementById('formTitle').textContent = 'Yeni Alerjen';
                document.getElementById('allergenName').value = '';
                document.getElementById('allergenIcon').value = '';
                document.getElementById('allergenForm').action = '{{ route("admin.allergens.store") }}';
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('cancelBtn').style.display = 'none';
            }
        </script>
    @endpush
@endsection