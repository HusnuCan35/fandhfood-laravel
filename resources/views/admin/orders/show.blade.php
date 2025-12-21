@extends('admin.layouts.app')

@section('page-title', 'Sipariş Detayı')
@section('page-subtitle', 'Sipariş #' . $order->id)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <!-- Order Details -->
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Sipariş Ürünleri</h3>
            <span class="status-badge status-{{ $order->order_status }}">
                @switch($order->order_status)
                    @case('pending') <i class="las la-clock"></i> Beklemede @break
                    @case('preparing') <i class="las la-utensils"></i> Hazırlanıyor @break
                    @case('on_way') <i class="las la-motorcycle"></i> Yolda @break
                    @case('completed') <i class="las la-check-circle"></i> Tamamlandı @break
                    @case('cancelled') <i class="las la-times-circle"></i> İptal @break
                @endswitch
            </span>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ürün</th>
                    <th>Birim Fiyat</th>
                    <th>Adet</th>
                    <th>Toplam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="{{ $item->product->product_image ?? '' }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                                <strong>{{ $item->product->product_name ?? 'Ürün' }}</strong>
                            </div>
                        </td>
                        <td>{{ number_format($item->price, 2) }} ₺</td>
                        <td>{{ $item->quantity }}</td>
                        <td><strong>{{ number_format($item->price * $item->quantity, 2) }} ₺</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($order->discount_details && (($order->discount_details['campaign_savings'] ?? 0) > 0 || ($order->discount_details['coupon_savings'] ?? 0) > 0))
                    <tr>
                        <td colspan="4" style="padding: 0;">
                            <div style="background: #ecfdf5; border: 1px dashed #10b981; border-radius: 10px; padding: 15px; margin: 10px 0;">
                                <strong style="color: #059669; display: block; margin-bottom: 10px;">
                                    <i class="las la-gift"></i> Uygulanan İndirimler
                                </strong>
                                
                                {{-- Campaign Discounts --}}
                                @if(!empty($order->discount_details['campaigns']))
                                    @foreach($order->discount_details['campaigns'] as $campaign)
                                        <div style="display: flex; justify-content: space-between; color: #047857; font-size: 0.9rem; margin-bottom: 5px;">
                                            <span><i class="las la-tag"></i> {{ $campaign['name'] }} (%{{ $campaign['percent'] }})</span>
                                            <span style="font-weight: 600;">-{{ number_format($campaign['savings'], 2) }} ₺</span>
                                        </div>
                                    @endforeach
                                @endif
                                
                                {{-- Coupon Discount --}}
                                @if(!empty($order->discount_details['coupon']))
                                    <div style="display: flex; justify-content: space-between; color: #047857; font-size: 0.9rem; margin-bottom: 5px;">
                                        <span><i class="las la-ticket-alt"></i> Kupon ({{ $order->discount_details['coupon']['code'] }})</span>
                                        <span style="font-weight: 600;">-{{ number_format($order->discount_details['coupon']['discount'], 2) }} ₺</span>
                                    </div>
                                @endif
                                
                                <div style="display: flex; justify-content: space-between; color: #059669; font-weight: 700; margin-top: 10px; padding-top: 10px; border-top: 1px solid #a7f3d0;">
                                    <span>Toplam Tasarruf</span>
                                    <span>-{{ number_format($order->discount_details['total_savings'] ?? 0, 2) }} ₺</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: 600;">Toplam:</td>
                    <td><strong style="font-size: 1.2rem; color: var(--admin-primary);">{{ number_format($order->order_total, 2) }} ₺</strong></td>
                </tr>
            </tfoot>
        </table>

        @if($order->note)
            <div style="margin-top: 20px; padding: 15px; background: var(--admin-bg); border-radius: 10px;">
                <strong><i class="las la-comment"></i> Sipariş Notu:</strong>
                <p style="margin-top: 5px;">{{ $order->note }}</p>
            </div>
        @endif
    </div>

    <!-- Customer Info -->
    <div>
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title" style="margin-bottom: 20px;">Müşteri Bilgileri</h3>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <p style="color: var(--admin-text-light); font-size: 0.85rem;">Ad Soyad</p>
                    <strong>{{ $order->user->name ?? 'Bilinmiyor' }}</strong>
                </div>
                <div>
                    <p style="color: var(--admin-text-light); font-size: 0.85rem;">Telefon</p>
                    <strong>{{ $order->phone }}</strong>
                </div>
                <div>
                    <p style="color: var(--admin-text-light); font-size: 0.85rem;">Adres</p>
                    <strong>{{ $order->address }}</strong>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="admin-card" style="margin-bottom: 20px;">
            <h3 class="card-title" style="margin-bottom: 15px;">Ödeme Yöntemi</h3>
            <div style="display: flex; align-items: center; gap: 12px; padding: 15px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; border: 2px solid #e2e8f0;">
                @php
                    $paymentColors = [
                        'cash' => ['bg' => '#10b981', 'icon' => 'la-money-bill-wave'],
                        'card_at_door' => ['bg' => '#3b82f6', 'icon' => 'la-credit-card'],
                        'meal_card' => ['bg' => '#f59e0b', 'icon' => 'la-utensils'],
                    ];
                    $pm = $order->payment_method ?? 'cash';
                    $pmColor = $paymentColors[$pm] ?? $paymentColors['cash'];
                @endphp
                <div style="width: 45px; height: 45px; border-radius: 10px; background: {{ $pmColor['bg'] }}; display: flex; align-items: center; justify-content: center;">
                    <i class="las {{ $pmColor['icon'] }}" style="font-size: 1.5rem; color: white;"></i>
                </div>
                <div>
                    <strong style="display: block; font-size: 1.05rem;">{{ $order->getPaymentMethodLabel() }}</strong>
                    <span style="color: var(--admin-text-light); font-size: 0.85rem;">
                        @switch($order->payment_method)
                            @case('cash') Kapıda nakit ödeme @break
                            @case('card_at_door') Kapıda POS cihazı ile @break
                            @case('meal_card') Sodexo, Multinet, Ticket @break
                            @default Kapıda nakit ödeme
                        @endswitch
                    </span>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;">Durum Güncelle</h3>
            <select class="form-input" onchange="updateOrderStatus({{ $order->id }}, this.value)">
                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Beklemede</option>
                <option value="preparing" {{ $order->order_status == 'preparing' ? 'selected' : '' }}>Hazırlanıyor</option>
                <option value="on_way" {{ $order->order_status == 'on_way' ? 'selected' : '' }}>Yolda</option>
                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>İptal</option>
            </select>

            <p style="margin-top: 15px; color: var(--admin-text-light); font-size: 0.85rem;">
                <i class="las la-calendar"></i> {{ $order->created_at->format('d.m.Y H:i') }}
            </p>
        </div>
    </div>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="las la-arrow-left"></i> Siparişlere Dön
    </a>
</div>

@push('scripts')
<script>
    function updateOrderStatus(orderId, status) {
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ status: status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endpush
@endsection
