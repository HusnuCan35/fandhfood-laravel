@extends('admin.layouts.app')

@section('page-title', 'Kampanyalar')
@section('page-subtitle', 'İndirim kampanyalarını ve flaş satışları yönetin')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 450px; gap: 20px;">
        <!-- Campaigns List -->
        <div class="admin-card">
            <div class="card-header">
                <h3 class="card-title">Kampanya Listesi</h3>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kampanya</th>
                        <th>İndirim</th>
                        <th>Tarih Aralığı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $campaign->name }}</strong>
                                    @if($campaign->is_flash)
                                        <span
                                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 3px 8px; border-radius: 10px; font-size: 0.7rem; margin-left: 8px;">
                                            <i class="las la-bolt"></i> FLASH
                                        </span>
                                    @endif
                                    @if($campaign->description)
                                        <p style="font-size: 0.85rem; color: var(--admin-text-light); margin-top: 4px;">
                                            {{ Str::limit($campaign->description, 50) }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--admin-success); font-weight: 700; font-size: 1.1rem;">
                                    %{{ $campaign->discount_percent }}
                                </span>
                            </td>
                            <td style="font-size: 0.9rem;">
                                {{ $campaign->starts_at->format('d.m.Y H:i') }}<br>
                                <span style="color: var(--admin-text-light);">→
                                    {{ $campaign->ends_at->format('d.m.Y H:i') }}</span>
                            </td>
                            <td>
                                @if($campaign->isActive())
                                    <span class="status-badge status-completed">
                                        <i class="las la-fire"></i> Aktif
                                    </span>
                                @elseif($campaign->starts_at->isFuture())
                                    <span class="status-badge status-preparing">
                                        <i class="las la-clock"></i> Yaklaşan
                                    </span>
                                @else
                                    <span class="status-badge status-cancelled">
                                        <i class="las la-times"></i> Sona Erdi
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button class="btn btn-secondary btn-sm"
                                        onclick="editCampaign({{ json_encode($campaign) }})">
                                        <i class="las la-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST"
                                        onsubmit="return confirm('Bu kampanyayı silmek istediğinize emin misiniz?')">
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
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                                <i class="las la-percentage" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                                Henüz kampanya yok
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Campaign Form -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;" id="formTitle">Yeni Kampanya</h3>

            <!-- Info Box -->
            <div
                style="background: linear-gradient(135deg, #dbeafe 0%, #ede9fe 100%); padding: 15px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #3b82f6;">
                <p style="font-size: 0.9rem; color: #1e40af; margin: 0;">
                    <i class="las la-info-circle"></i>
                    <strong>Kampanya nasıl çalışır?</strong><br>
                    • Ürün veya kategori seçerek o ürünlere indirim uygulayın<br>
                    • Her ikisini de boş bırakırsanız TÜM ürünlere uygulanır<br>
                    • Anasayfada indirimli ürünler etiketli görünür
                </p>
            </div>

            <form id="campaignForm" action="{{ route('admin.campaigns.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label class="form-label">Kampanya Adı *</label>
                    <input type="text" name="name" id="campName" class="form-input"
                        placeholder="Örn: Çorba Festivali, Yeni Yıl İndirimi" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Açıklama</label>
                    <textarea name="description" id="campDesc" class="form-input" rows="2"
                        placeholder="Kampanya hakkında kısa bilgi (anasayfada görünmez)"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">İndirim Yüzdesi (%) *</label>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="range" id="campPercentSlider" min="5" max="70" value="20" style="flex: 1;"
                            oninput="document.getElementById('campPercent').value = this.value; updatePreview();">
                        <input type="number" name="discount_percent" id="campPercent" class="form-input" min="1" max="100"
                            value="20" style="width: 80px; text-align: center;" required
                            oninput="document.getElementById('campPercentSlider').value = this.value; updatePreview();">
                        <span style="font-weight: 700; font-size: 1.2rem;">%</span>
                    </div>
                    <!-- Preview -->
                    <div
                        style="margin-top: 10px; padding: 10px; background: var(--admin-bg); border-radius: 8px; display: flex; gap: 15px; align-items: center;">
                        <span style="color: var(--admin-text-light); font-size: 0.9rem;">Örnek:</span>
                        <span style="text-decoration: line-through; color: var(--admin-text-light);">100 ₺</span>
                        <span style="font-weight: 700; color: #10b981;" id="previewPrice">80 ₺</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label class="form-label"><i class="las la-calendar"></i> Başlangıç *</label>
                        <input type="datetime-local" name="starts_at" id="campStart" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><i class="las la-calendar-check"></i> Bitiş *</label>
                        <input type="datetime-local" name="ends_at" id="campEnd" class="form-input" required>
                    </div>
                </div>

                <!-- Target Selection -->
                <div style="background: var(--admin-bg); padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                    <p style="font-weight: 600; margin-bottom: 15px;"><i class="las la-bullseye"></i> Kampanya Hedefi</p>

                    <div class="form-group">
                        <label class="form-label">Belirli Ürünler <span
                                style="color: var(--admin-text-light);">(Opsiyonel)</span></label>
                        <select name="product_ids[]" id="campProducts" class="form-input" multiple style="height: 100px;">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.8rem; color: var(--admin-text-light); margin-top: 5px;">
                            <i class="las la-lightbulb"></i> Ctrl+Click ile birden fazla ürün seçin
                        </p>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Veya Kategori Seçin <span
                                style="color: var(--admin-text-light);">(Opsiyonel)</span></label>
                        <select name="category_ids[]" id="campCategories" class="form-input" multiple style="height: 80px;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" style="display: flex; gap: 20px;">
                    <label
                        style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px 15px; background: var(--admin-bg); border-radius: 10px;">
                        <input type="checkbox" name="is_flash" id="campFlash" value="1" style="width: 20px; height: 20px;">
                        <span><i class="las la-bolt" style="color: #ef4444;"></i> Flash Satış</span>
                    </label>
                    <label
                        style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px 15px; background: var(--admin-bg); border-radius: 10px;">
                        <input type="checkbox" name="status" id="campStatus" value="1" checked
                            style="width: 20px; height: 20px;">
                        <span><i class="las la-check-circle" style="color: #10b981;"></i> Aktif</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="las la-save"></i> Kampanya Oluştur
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
            function updatePreview() {
                const percent = parseInt(document.getElementById('campPercent').value) || 0;
                const discounted = 100 - percent;
                document.getElementById('previewPrice').textContent = discounted + ' ₺';
            }
            updatePreview();
            function editCampaign(campaign) {
                document.getElementById('formTitle').textContent = 'Kampanyayı Düzenle';
                document.getElementById('campName').value = campaign.name;
                document.getElementById('campDesc').value = campaign.description || '';
                document.getElementById('campPercent').value = campaign.discount_percent;
                document.getElementById('campStart').value = campaign.starts_at ? campaign.starts_at.slice(0, 16) : '';
                document.getElementById('campEnd').value = campaign.ends_at ? campaign.ends_at.slice(0, 16) : '';
                document.getElementById('campFlash').checked = campaign.is_flash;
                document.getElementById('campStatus').checked = campaign.status;

                // Set selected products
                const prodSelect = document.getElementById('campProducts');
                Array.from(prodSelect.options).forEach(opt => {
                    opt.selected = campaign.product_ids && campaign.product_ids.includes(parseInt(opt.value));
                });

                // Set selected categories
                const catSelect = document.getElementById('campCategories');
                Array.from(catSelect.options).forEach(opt => {
                    opt.selected = campaign.category_ids && campaign.category_ids.includes(parseInt(opt.value));
                });

                document.getElementById('campaignForm').action = '/admin/campaigns/' + campaign.id;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('cancelBtn').style.display = 'block';
            }

            function resetForm() {
                document.getElementById('formTitle').textContent = 'Yeni Kampanya';
                document.getElementById('campaignForm').reset();
                document.getElementById('campaignForm').action = '{{ route("admin.campaigns.store") }}';
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('cancelBtn').style.display = 'none';
                document.getElementById('campStatus').checked = true;
            }
        </script>
    @endpush
@endsection