@extends('admin.layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'İstatistikler ve özet bilgiler')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="las la-shopping-bag"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $todayOrders }}</h3>
            <p>Bugünkü Siparişler</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon success">
            <i class="las la-lira-sign"></i>
        </div>
        <div class="stat-info">
            <h3>{{ number_format($todayRevenue, 2) }} ₺</h3>
            <p>Bugünkü Gelir</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon info">
            <i class="las la-utensils"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalProducts }}</h3>
            <p>Toplam Ürün</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="las la-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalUsers }}</h3>
            <p>Kayıtlı Kullanıcı</p>
        </div>
    </div>
</div>

<!-- Summary Cards Row -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Bu Hafta</h3>
            <i class="las la-calendar-week" style="color: var(--admin-primary); font-size: 1.5rem;"></i>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <p style="color: var(--admin-text-light); font-size: 0.9rem;">Sipariş</p>
                <h4 style="font-size: 1.5rem;">{{ $weekOrders }}</h4>
            </div>
            <div>
                <p style="color: var(--admin-text-light); font-size: 0.9rem;">Gelir</p>
                <h4 style="font-size: 1.5rem; color: var(--admin-success);">{{ number_format($weekRevenue, 2) }} ₺</h4>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Bu Ay</h3>
            <i class="las la-calendar-alt" style="color: var(--admin-info); font-size: 1.5rem;"></i>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <p style="color: var(--admin-text-light); font-size: 0.9rem;">Sipariş</p>
                <h4 style="font-size: 1.5rem;">{{ $monthOrders }}</h4>
            </div>
            <div>
                <p style="color: var(--admin-text-light); font-size: 0.9rem;">Gelir</p>
                <h4 style="font-size: 1.5rem; color: var(--admin-success);">{{ number_format($monthRevenue, 2) }} ₺</h4>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Toplam</h3>
            <i class="las la-chart-line" style="color: var(--admin-success); font-size: 1.5rem;"></i>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <p style="color: var(--admin-text-light); font-size: 0.9rem;">Sipariş</p>
                <h4 style="font-size: 1.5rem;">{{ $totalOrders }}</h4>
            </div>
            <div>
                <p style="color: var(--admin-text-light); font-size: 0.9rem;">Gelir</p>
                <h4 style="font-size: 1.5rem; color: var(--admin-success);">{{ number_format($totalRevenue, 2) }} ₺</h4>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card" style="margin-top: 20px;">
    <div class="card-header">
        <h3 class="card-title">Son Siparişler</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
            Tümünü Gör <i class="las la-arrow-right"></i>
        </a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Sipariş No</th>
                <th>Müşteri</th>
                <th>Ürünler</th>
                <th>Toplam</th>
                <th>Durum</th>
                <th>Tarih</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->user->name ?? 'Bilinmiyor' }}</td>
                    <td>
                        @foreach($order->items->take(2) as $item)
                            <span style="display: block; font-size: 0.9rem;">{{ $item->quantity }}x {{ $item->product->product_name ?? 'Ürün' }}</span>
                        @endforeach
                        @if($order->items->count() > 2)
                            <span style="color: var(--admin-text-light); font-size: 0.8rem;">+{{ $order->items->count() - 2 }} ürün daha</span>
                        @endif
                    </td>
                    <td><strong>{{ number_format($order->order_total, 2) }} ₺</strong></td>
                    <td>
                        <span class="status-badge status-{{ $order->order_status }}">
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
                            @endswitch
                        </span>
                    </td>
                    <td style="color: var(--admin-text-light);">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                        <i class="las la-inbox" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                        Henüz sipariş yok
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
