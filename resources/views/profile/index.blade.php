@extends('layouts.app')

@section('title', 'Profilim - FandhFood')

@section('content')
<div class="profile-page">
    <div class="container">
        <div class="profile-header">
            <div class="profile-avatar">
                <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="profile-info">
                <h1>{{ auth()->user()->name }}</h1>
                <p>{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="profile-content">
            <div class="row">
                <!-- Profile Info Section -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <i class="las la-user"></i>
                            <h3>Profil Bilgileri</h3>
                        </div>
                        <form id="profileForm" class="profile-form">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Ad Soyad</label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-posta</label>
                                <input type="email" id="email" value="{{ auth()->user()->email }}" disabled>
                                <small class="text-muted">E-posta adresi değiştirilemez</small>
                            </div>
                            <div class="form-group">
                                <label for="phone">Telefon</label>
                                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}" placeholder="5XX XXX XX XX">
                            </div>
                            <div class="form-group">
                                <label for="address">Adres</label>
                                <textarea id="address" name="address" rows="3" placeholder="Teslimat adresiniz...">{{ auth()->user()->address }}</textarea>
                            </div>
                            <button type="submit" class="profile-btn">
                                <i class="las la-save"></i> Bilgileri Kaydet
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <i class="las la-lock"></i>
                            <h3>Şifre Değiştir</h3>
                        </div>
                        <form id="passwordForm" class="profile-form">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">Mevcut Şifre</label>
                                <div class="password-input-wrapper">
                                    <input type="password" id="current_password" name="current_password" required>
                                    <i class="las la-eye toggle-password" onclick="togglePassword('current_password')"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Yeni Şifre</label>
                                <div class="password-input-wrapper">
                                    <input type="password" id="password" name="password" required>
                                    <i class="las la-eye toggle-password" onclick="togglePassword('password')"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Yeni Şifre (Tekrar)</label>
                                <div class="password-input-wrapper">
                                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                                    <i class="las la-eye toggle-password" onclick="togglePassword('password_confirmation')"></i>
                                </div>
                            </div>
                            <button type="submit" class="profile-btn profile-btn-secondary">
                                <i class="las la-key"></i> Şifreyi Değiştir
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Addresses Section -->
            <div class="profile-card" style="margin-bottom: 20px;">
                <div class="profile-card-header" style="justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="las la-map-marker-alt"></i>
                        <h3>Kayıtlı Adreslerim</h3>
                    </div>
                    <button type="button" onclick="openAddressModal()" class="profile-btn" style="padding: 10px 20px; font-size: 0.9rem;">
                        <i class="las la-plus"></i> Yeni Adres
                    </button>
                </div>

                <div id="profileAddressList" style="display: grid; gap: 15px;">
                    @php $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get(); @endphp
                    @forelse($addresses as $addr)
                        <div class="address-card" data-id="{{ $addr->id }}" style="padding: 20px; border: 2px solid {{ $addr->is_default ? 'var(--main-color)' : '#e0e0e0' }}; border-radius: 15px; background: {{ $addr->is_default ? '#fff8f0' : 'white' }}; position: relative;">
                            <div style="display: flex; gap: 15px;">
                                <div style="width: 45px; height: 45px; border-radius: 12px; background: {{ $addr->address_type == 'home' ? '#fef3c7' : ($addr->address_type == 'work' ? '#dbeafe' : '#f3e8ff') }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="las {{ $addr->getTypeIcon() }}" style="font-size: 1.5rem; color: {{ $addr->address_type == 'home' ? '#b45309' : ($addr->address_type == 'work' ? '#1d4ed8' : '#7c3aed') }};"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                        <strong style="font-size: 1.1rem;">{{ $addr->title }}</strong>
                                        @if($addr->is_default)
                                            <span style="background: var(--main-color); color: white; font-size: 0.75rem; padding: 3px 10px; border-radius: 15px;">Varsayılan</span>
                                        @endif
                                    </div>
                                    <p style="color: #666; margin: 0; line-height: 1.5;">{{ $addr->getFormattedAddress() }}</p>
                                    @if($addr->directions)
                                        <p style="color: #888; font-size: 0.85rem; margin: 8px 0 0; font-style: italic;">
                                            <i class="las la-info-circle"></i> {{ $addr->directions }}
                                        </p>
                                    @endif
                                </div>
                                <div style="display: flex; gap: 10px; align-items: start;">
                                    @if(!$addr->is_default)
                                        <button type="button" onclick="setDefaultAddress({{ $addr->id }})" title="Varsayılan Yap"
                                            style="width: 36px; height: 36px; border: none; background: #f0f0f0; border-radius: 10px; cursor: pointer;">
                                            <i class="las la-star" style="color: #666;"></i>
                                        </button>
                                    @endif
                                    <button type="button" onclick="editAddress({{ $addr->id }})" title="Düzenle"
                                        style="width: 36px; height: 36px; border: none; background: #f0f0f0; border-radius: 10px; cursor: pointer;">
                                        <i class="las la-pen" style="color: #666;"></i>
                                    </button>
                                    <button type="button" onclick="deleteProfileAddress({{ $addr->id }}, {{ $addresses->count() }})" title="Sil"
                                        style="width: 36px; height: 36px; border: none; background: #fee2e2; border-radius: 10px; cursor: pointer;">
                                        <i class="las la-trash" style="color: #dc2626;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="noAddressProfile" style="text-align: center; padding: 50px 20px; background: #f9f9f9; border-radius: 15px; border: 2px dashed #ddd;">
                            <i class="las la-map-marker-alt" style="font-size: 3rem; color: #ccc; margin-bottom: 15px; display: block;"></i>
                            <p style="color: #888; margin: 0 0 15px;">Henüz kayıtlı adresiniz yok</p>
                            <button type="button" onclick="openAddressModal()" class="profile-btn" style="padding: 12px 24px;">
                                <i class="las la-plus"></i> İlk Adresimi Ekle
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Order History Section -->
            <div class="profile-card orders-card" id="orders">
                <div class="profile-card-header">
                    <i class="las la-shopping-bag"></i>
                    <h3>Sipariş Geçmişi</h3>
                </div>
                @if($orders->count() > 0)
                    <div class="orders-list">
                        @foreach($orders as $order)
                            <div class="order-item">
                                <div class="order-header">
                                    <div class="order-id">
                                        <span class="order-label">Sipariş No:</span>
                                        <span class="order-value">#{{ $order->id }}</span>
                                    </div>
                                    <div class="order-status status-{{ $order->order_status }}">
                                        @switch($order->order_status)
                                            @case('pending')
                                                <i class="las la-clock"></i> Beklemede
                                                @break
                                            @case('preparing')
                                                <i class="las la-utensils"></i> Hazırlanıyor
                                                @break
                                            @case('on_way')
                                                <i class="las la-motorcycle"></i> Yolda
                                                @break
                                            @case('completed')
                                                <i class="las la-check-circle"></i> Tamamlandı
                                                @break
                                            @case('cancelled')
                                                <i class="las la-times-circle"></i> İptal
                                                @break
                                            @default
                                                {{ $order->order_status }}
                                        @endswitch
                                    </div>
                                </div>
                                <div class="order-body">
                                    <div class="order-products">
                                        @foreach($order->items as $item)
                                            <div class="order-product">
                                                <span class="product-qty">{{ $item->quantity }}x</span>
                                                <span class="product-name">{{ $item->product->product_name ?? 'Ürün' }}</span>
                                                <span class="product-price">{{ number_format($item->price * $item->quantity, 2) }} TL</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="order-footer">
                                        <div class="order-date">
                                            <i class="las la-calendar"></i>
                                            {{ $order->created_at->format('d.m.Y H:i') }}
                                        </div>
                                        <div class="order-total">
                                            Toplam: <strong>{{ number_format($order->order_total, 2) }} TL</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-orders">
                        <i class="las la-shopping-bag"></i>
                        <p>Henüz sipariş vermediniz.</p>
                        <a href="{{ route('home') }}" class="profile-btn">Alışverişe Başla</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .profile-page {
        padding-top: 100px;
        min-height: 100vh;
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 40px;
        padding: 30px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 10px 30px rgba(255, 126, 32, 0.4);
    }

    .profile-info h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 5px;
    }

    .profile-info p {
        color: #888;
        font-size: 1rem;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .profile-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f5f5f5;
    }

    .profile-card-header i {
        font-size: 1.8rem;
        color: var(--main-color);
    }

    .profile-card-header h3 {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0;
    }

    .profile-form .form-group {
        margin-bottom: 20px;
    }

    .profile-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-color);
    }

    .profile-form input,
    .profile-form textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 1rem;
        font-family: 'Quicksand', sans-serif;
        transition: all 0.3s ease;
    }

    .profile-form input:focus,
    .profile-form textarea:focus {
        outline: none;
        border-color: var(--main-color);
        box-shadow: 0 0 0 4px rgba(255, 126, 32, 0.1);
    }

    .profile-form input:disabled {
        background: #f9f9f9;
        color: #999;
    }

    .password-input-wrapper {
        position: relative;
    }

    .password-input-wrapper input {
        padding-right: 50px;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .toggle-password:hover {
        color: var(--main-color);
    }

    .profile-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Quicksand', sans-serif;
        text-decoration: none;
    }

    .profile-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(255, 126, 32, 0.4);
        color: white;
    }

    .profile-btn-secondary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .profile-btn-secondary:hover {
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    /* Orders Section */
    .orders-card {
        margin-top: 20px;
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-item {
        border: 2px solid #f0f0f0;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        border-color: var(--main-color);
        box-shadow: 0 5px 20px rgba(255, 126, 32, 0.1);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #fafafa;
    }

    .order-id {
        display: flex;
        gap: 10px;
    }

    .order-label {
        color: #888;
    }

    .order-value {
        font-weight: 700;
        color: var(--main-color);
    }

    .order-status {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-preparing {
        background: #cce5ff;
        color: #004085;
    }

    .status-on_way {
        background: #d4edda;
        color: #155724;
    }

    .status-completed {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .order-body {
        padding: 20px;
    }

    .order-products {
        margin-bottom: 15px;
    }

    .order-product {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 8px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .order-product:last-child {
        border-bottom: none;
    }

    .product-qty {
        font-weight: 700;
        color: var(--main-color);
        min-width: 35px;
    }

    .product-name {
        flex: 1;
    }

    .product-price {
        font-weight: 600;
        color: var(--text-color);
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 2px solid #f5f5f5;
    }

    .order-date {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #888;
        font-size: 0.9rem;
    }

    .order-total {
        font-size: 1.1rem;
    }

    .order-total strong {
        color: var(--main-color);
    }

    .empty-orders {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-orders i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-orders p {
        color: #888;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .order-header {
            flex-direction: column;
            gap: 10px;
        }

        .order-footer {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('la-eye');
            icon.classList.add('la-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('la-eye-slash');
            icon.classList.add('la-eye');
        }
    }

    // Profile Form Submit
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("profile.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message);
            } else {
                showAlert(data.message || 'Bir hata oluştu!', 'error');
            }
        })
        .catch(() => showAlert('Bir hata oluştu!', 'error'));
    });

    // Password Form Submit
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("profile.password") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message);
                this.reset();
            } else {
                showAlert(data.message || 'Bir hata oluştu!', 'error');
            }
        })
        .catch(() => showAlert('Bir hata oluştu!', 'error'));
    });

    // Address functions
    let editingAddressId = null;

    function openAddressModal(addressData = null) {
        editingAddressId = addressData?.id || null;
        document.getElementById('profileAddressModal').style.display = 'flex';
        document.getElementById('profileModalTitle').textContent = addressData ? 'Adresi Düzenle' : 'Yeni Adres Ekle';
        
        document.getElementById('profAddrTitle').value = addressData?.title || '';
        document.getElementById('profAddrType').value = addressData?.type || 'home';
        document.getElementById('profAddrFull').value = addressData?.full_address || '';
        document.getElementById('profAddrDistrict').value = addressData?.district || '';
        document.getElementById('profAddrCity').value = addressData?.city || '';
        document.getElementById('profAddrBuilding').value = addressData?.building_no || '';
        document.getElementById('profAddrFloor').value = addressData?.floor || '';
        document.getElementById('profAddrApartment').value = addressData?.apartment_no || '';
        document.getElementById('profAddrDirections').value = addressData?.directions || '';
        document.getElementById('profAddrDefault').checked = addressData?.is_default || false;
    }

    function closeAddressModal() {
        document.getElementById('profileAddressModal').style.display = 'none';
        editingAddressId = null;
    }

    function saveProfileAddress() {
        const data = {
            title: document.getElementById('profAddrTitle').value,
            address_type: document.getElementById('profAddrType').value,
            full_address: document.getElementById('profAddrFull').value,
            district: document.getElementById('profAddrDistrict').value,
            city: document.getElementById('profAddrCity').value,
            building_no: document.getElementById('profAddrBuilding').value,
            floor: document.getElementById('profAddrFloor').value,
            apartment_no: document.getElementById('profAddrApartment').value,
            directions: document.getElementById('profAddrDirections').value,
            is_default: document.getElementById('profAddrDefault').checked,
        };

        const url = editingAddressId ? '/adres/' + editingAddressId : '/adres';
        const method = editingAddressId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                showAlert(result.message);
                closeAddressModal();
                location.reload();
            } else {
                showAlert(result.message || 'Bir hata oluştu!', 'error');
            }
        })
        .catch(() => showAlert('Bir hata oluştu!', 'error'));
    }

    function editAddress(addressId) {
        fetch('/adres', {
            headers: { 'Accept': 'application/json' },
        })
        .then(res => res.json())
        .then(data => {
            const address = data.addresses.find(a => a.id == addressId);
            if (address) {
                openAddressModal(address);
            }
        });
    }

    function setDefaultAddress(addressId) {
        fetch('/adres/' + addressId + '/varsayilan', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                showAlert(result.message);
                location.reload();
            } else {
                showAlert(result.message, 'error');
            }
        });
    }

    function deleteProfileAddress(addressId, totalCount) {
        if (totalCount <= 1) {
            showAlert('Son adresinizi silemezsiniz! Önce yeni bir adres ekleyin ve varsayılan yapın.', 'error');
            return;
        }
        
        if (!confirm('Bu adresi silmek istediğinize emin misiniz?')) return;

        fetch('/adres/' + addressId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                showAlert(result.message);
                location.reload();
            } else {
                showAlert(result.message, 'error');
            }
        });
    }
</script>
@endpush

<!-- Address Modal -->
<div id="profileAddressModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
            <h3 id="profileModalTitle" style="margin: 0; font-weight: 600;">Yeni Adres Ekle</h3>
            <button type="button" onclick="closeAddressModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; margin-bottom: 6px;">Adres Başlığı *</label>
                <input type="text" id="profAddrTitle" placeholder="Örn: Evim, İş Yerim" 
                    style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; margin-bottom: 6px;">Adres Tipi</label>
                <select id="profAddrType" style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; background: white;">
                    <option value="home">🏠 Ev</option>
                    <option value="work">🏢 İş</option>
                    <option value="other">📍 Diğer</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; margin-bottom: 6px;">Tam Adres *</label>
                <textarea id="profAddrFull" rows="3" placeholder="Mahalle, sokak, cadde bilgileri..."
                    style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: none;"></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">İlçe</label>
                    <input type="text" id="profAddrDistrict" placeholder="İlçe" 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Şehir</label>
                    <input type="text" id="profAddrCity" placeholder="Şehir" 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Bina No</label>
                    <input type="text" id="profAddrBuilding" placeholder="No" 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Kat</label>
                    <input type="text" id="profAddrFloor" placeholder="Kat" 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Daire</label>
                    <input type="text" id="profAddrApartment" placeholder="Daire" 
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 500; margin-bottom: 6px;">Adres Tarifi (Opsiyonel)</label>
                <textarea id="profAddrDirections" rows="2" placeholder="Örn: Sarı bina, soldaki kapı..."
                    style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: none;"></textarea>
            </div>
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; margin-bottom: 20px;">
                <input type="checkbox" id="profAddrDefault" style="width: 18px; height: 18px; accent-color: var(--main-color);">
                <span>Varsayılan adres olarak kaydet</span>
            </label>
            <button type="button" onclick="saveProfileAddress()" 
                style="width: 100%; padding: 14px; background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                <i class="las la-save"></i> Kaydet
            </button>
        </div>
    </div>
</div>
@endsection
