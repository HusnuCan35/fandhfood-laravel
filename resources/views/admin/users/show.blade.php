@extends('admin.layouts.app')

@section('page-title', 'Kullanıcı Detayı')
@section('page-subtitle', $user->name)

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    <!-- User Info -->
    <div class="admin-card">
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 100px; height: 100px; border-radius: 20px; background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; margin: 0 auto 15px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h2 style="margin-bottom: 5px;">{{ $user->name }}</h2>
            @if($user->is_admin)
                <span class="status-badge status-completed">
                    <i class="las la-shield-alt"></i> Admin
                </span>
            @endif
            @if($user->is_banned)
                <span class="status-badge status-cancelled" style="margin-left: 5px;">
                    <i class="las la-ban"></i> Yasaklı
                </span>
            @endif
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.users.update', $user) }}" method="POST" style="margin-bottom: 20px;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 18px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">
                    <i class="las la-user" style="margin-right: 5px; color: var(--admin-primary);"></i> Ad Soyad
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 12px; font-size: 1rem; font-family: inherit; transition: all 0.3s; background: #fafafa;"
                    onfocus="this.style.borderColor='var(--admin-primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#fafafa'; this.style.boxShadow='none';">
            </div>
            
            <div style="margin-bottom: 18px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">
                    <i class="las la-envelope" style="margin-right: 5px; color: var(--admin-primary);"></i> E-posta
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 12px; font-size: 1rem; font-family: inherit; transition: all 0.3s; background: #fafafa;"
                    onfocus="this.style.borderColor='var(--admin-primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#fafafa'; this.style.boxShadow='none';">
            </div>
            
            <div style="margin-bottom: 18px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">
                    <i class="las la-phone" style="margin-right: 5px; color: var(--admin-primary);"></i> Telefon
                </label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="5XX XXX XX XX"
                    style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 12px; font-size: 1rem; font-family: inherit; transition: all 0.3s; background: #fafafa;"
                    onfocus="this.style.borderColor='var(--admin-primary)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(99, 102, 241, 0.1)';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#fafafa'; this.style.boxShadow='none';">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; border-radius: 12px; font-size: 1rem; font-weight: 600;">
                <i class="las la-save"></i> Bilgileri Güncelle
            </button>
        </form>

        <div style="padding-top: 15px; border-top: 1px solid var(--admin-border);">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; text-align: center;">
                <div>
                    <h3 style="font-size: 1.8rem; color: var(--admin-primary);">{{ $user->orders->count() }}</h3>
                    <p style="color: var(--admin-text-light); font-size: 0.9rem;">Sipariş</p>
                </div>
                <div>
                    <h3 style="font-size: 1.8rem; color: var(--admin-success);">{{ number_format($totalSpent, 2) }} ₺</h3>
                    <p style="color: var(--admin-text-light); font-size: 0.9rem;">Toplam Harcama</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid var(--admin-border);">
            <p style="color: var(--admin-text-light); font-size: 0.85rem;">Kayıt Tarihi</p>
            <strong>{{ $user->created_at->format('d.m.Y H:i') }}</strong>
        </div>
    </div>

    <!-- Right Column -->
    <div>
        <!-- Ban Section -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title" style="margin-bottom: 15px;">
                <i class="las la-ban"></i> Hesap Durumu
            </h3>
            
            @if($user->is_banned)
                <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border: 2px solid #f87171; border-radius: 15px; padding: 20px; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <div style="width: 40px; height: 40px; background: #dc2626; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="las la-ban" style="color: white; font-size: 1.3rem;"></i>
                        </div>
                        <strong style="color: #991b1b; font-size: 1.1rem;">Kullanıcı Yasaklı</strong>
                    </div>
                    <p style="margin: 0 0 8px; color: #7f1d1d; font-weight: 500;">
                        <i class="las la-quote-left" style="opacity: 0.5;"></i> {{ $user->ban_reason }}
                    </p>
                    <p style="margin: 0; font-size: 0.85rem; color: #b91c1c;">
                        <i class="las la-calendar"></i> Yasaklanma: {{ $user->banned_at?->format('d.m.Y H:i') }}
                    </p>
                </div>
                <form action="{{ route('admin.users.unban', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 14px; border-radius: 12px; font-size: 1rem; font-weight: 600;"
                        onclick="return confirm('Bu kullanıcının yasağını kaldırmak istediğinize emin misiniz?')">
                        <i class="las la-unlock"></i> Yasağı Kaldır
                    </button>
                </form>
            @else
                <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--admin-text); font-size: 0.9rem;">
                            <i class="las la-comment-alt" style="margin-right: 5px; color: #dc2626;"></i> Yasak Sebebi
                        </label>
                        <textarea name="ban_reason" required rows="3" placeholder="Yasaklama sebebini detaylı açıklayın..."
                            style="width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 12px; font-size: 1rem; font-family: inherit; transition: all 0.3s; background: #fafafa; resize: none;"
                            onfocus="this.style.borderColor='#dc2626'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(220, 38, 38, 0.1)';"
                            onblur="this.style.borderColor='#e0e0e0'; this.style.background='#fafafa'; this.style.boxShadow='none';"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger" style="width: 100%; padding: 14px; border-radius: 12px; font-size: 1rem; font-weight: 600;"
                        onclick="return confirm('Bu kullanıcıyı yasaklamak istediğinize emin misiniz?')">
                        <i class="las la-ban"></i> Kullanıcıyı Yasakla
                    </button>
                </form>
            @endif
        </div>

        <!-- User Orders -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;">Sipariş Geçmişi</h3>
            
            @if($user->orders->count() > 0)
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sipariş No</th>
                            <th>Ürünler</th>
                            <th>Toplam</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}"><strong>#{{ $order->id }}</strong></a></td>
                                <td>
                                    @foreach($order->items->take(2) as $item)
                                        <span style="display: block; font-size: 0.9rem;">{{ $item->quantity }}x {{ $item->product->product_name ?? 'Ürün' }}</span>
                                    @endforeach
                                </td>
                                <td><strong>{{ number_format($order->order_total, 2) }} ₺</strong></td>
                                <td>
                                    <span class="status-badge status-{{ $order->order_status }}">
                                        @switch($order->order_status)
                                            @case('pending') Beklemede @break
                                            @case('preparing') Hazırlanıyor @break
                                            @case('on_way') Yolda @break
                                            @case('completed') Tamamlandı @break
                                            @case('cancelled') İptal @break
                                        @endswitch
                                    </span>
                                </td>
                                <td style="color: var(--admin-text-light);">{{ $order->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                    <i class="las la-shopping-bag" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                    Bu kullanıcının siparişi yok
                </div>
            @endif
        </div>
    </div>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="las la-arrow-left"></i> Kullanıcılara Dön
    </a>
</div>
@endsection
