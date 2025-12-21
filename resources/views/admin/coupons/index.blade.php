@extends('admin.layouts.app')

@section('page-title', 'Kupon Kodları')
@section('page-subtitle', 'İndirim kuponlarını yönetin')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px;">
        <!-- Coupons List -->
        <div class="admin-card">
            <div class="card-header">
                <h3 class="card-title">Kupon Listesi</h3>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kupon Kodu</th>
                        <th>İndirim</th>
                        <th>Min. Sipariş</th>
                        <th>Son Kullanma</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>
                                <code
                                    style="background: var(--admin-bg); padding: 8px 12px; border-radius: 8px; font-weight: 700; font-size: 1rem;">
                                        {{ $coupon->discount_code }}
                                    </code>
                            </td>
                            <td>
                                @if($coupon->discount_percent > 0)
                                    <span
                                        style="color: var(--admin-success); font-weight: 700;">%{{ $coupon->discount_percent }}</span>
                                @else
                                    <span
                                        style="color: var(--admin-success); font-weight: 700;">{{ number_format($coupon->discount_amount, 2) }}
                                        ₺</span>
                                @endif
                            </td>
                            <td>{{ $coupon->min_order > 0 ? number_format($coupon->min_order, 2) . ' ₺' : '-' }}</td>
                            <td>
                                @if($coupon->expires_at)
                                    <span
                                        style="color: {{ $coupon->expires_at->isPast() ? 'var(--admin-danger)' : 'var(--admin-text-light)' }};">
                                        {{ $coupon->expires_at->format('d.m.Y') }}
                                    </span>
                                @else
                                    <span style="color: var(--admin-text-light);">Süresiz</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->status && (!$coupon->expires_at || !$coupon->expires_at->isPast()))
                                    <span class="status-badge status-completed">Aktif</span>
                                @else
                                    <span class="status-badge status-cancelled">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <button class="btn btn-secondary btn-sm" onclick="editCoupon({{ json_encode($coupon) }})">
                                        <i class="las la-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                        onsubmit="return confirm('Bu kuponu silmek istediğinize emin misiniz?')">
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
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                                <i class="las la-ticket-alt" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                                Henüz kupon kodu yok
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Coupon Form -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;" id="formTitle">Yeni Kupon</h3>

            <form id="couponForm" action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label class="form-label">Kupon Kodu *</label>
                    <input type="text" name="discount_code" id="discountCode" class="form-input" placeholder="YILSONU20"
                        style="text-transform: uppercase;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label class="form-label">Yüzde İndirim (%)</label>
                        <input type="number" name="discount_percent" id="discountPercent" class="form-input" min="0"
                            max="100" placeholder="20">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sabit İndirim (₺)</label>
                        <input type="number" name="discount_amount" id="discountAmount" class="form-input" min="0"
                            step="0.01" placeholder="50.00">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Minimum Sipariş Tutarı (₺)</label>
                    <input type="number" name="min_order" id="minOrder" class="form-input" min="0" step="0.01"
                        placeholder="100.00">
                </div>

                <div class="form-group">
                    <label class="form-label">Son Kullanma Tarihi</label>
                    <input type="datetime-local" name="expires_at" id="expiresAt" class="form-input">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="status" id="status" value="1" checked
                            style="width: 20px; height: 20px;">
                        <span>Aktif</span>
                    </label>
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
            function editCoupon(coupon) {
                document.getElementById('formTitle').textContent = 'Kuponu Düzenle';
                document.getElementById('discountCode').value = coupon.discount_code;
                document.getElementById('discountPercent').value = coupon.discount_percent || '';
                document.getElementById('discountAmount').value = coupon.discount_amount || '';
                document.getElementById('minOrder').value = coupon.min_order || '';
                document.getElementById('expiresAt').value = coupon.expires_at ? coupon.expires_at.slice(0, 16) : '';
                document.getElementById('status').checked = coupon.status;
                document.getElementById('couponForm').action = '/admin/coupons/' + coupon.id;
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('cancelBtn').style.display = 'block';
            }

            function resetForm() {
                document.getElementById('formTitle').textContent = 'Yeni Kupon';
                document.getElementById('couponForm').reset();
                document.getElementById('couponForm').action = '{{ route("admin.coupons.store") }}';
                document.getElementById('formMethod').value = 'POST';
                document.getElementById('cancelBtn').style.display = 'none';
                document.getElementById('status').checked = true;
            }
        </script>
    @endpush
@endsection