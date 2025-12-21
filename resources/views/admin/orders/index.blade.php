@extends('admin.layouts.app')

@section('page-title', 'Siparişler')
@section('page-subtitle', 'Tüm siparişleri yönetin')

@section('content')
    <div class="admin-card">
        <div class="card-header">
            <h3 class="card-title">Sipariş Listesi</h3>
            <div style="display: flex; gap: 10px;">
                <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 10px;">
                    <select name="status" class="form-input" style="width: auto;" onchange="this.form.submit()">
                        <option value="">Tüm Durumlar</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Beklemede</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Hazırlanıyor
                        </option>
                        <option value="on_way" {{ request('status') == 'on_way' ? 'selected' : '' }}>Yolda</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal</option>
                    </select>
                </form>
            </div>
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
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <strong>{{ $order->user->name ?? 'Bilinmiyor' }}</strong>
                            <p style="font-size: 0.85rem; color: var(--admin-text-light);">{{ $order->phone }}</p>
                        </td>
                        <td>
                            @foreach($order->items->take(2) as $item)
                                <span style="display: block; font-size: 0.9rem;">{{ $item->quantity }}x
                                    {{ $item->product->product_name ?? 'Ürün' }}</span>
                            @endforeach
                            @if($order->items->count() > 2)
                                <span style="color: var(--admin-text-light); font-size: 0.8rem;">+{{ $order->items->count() - 2 }}
                                    ürün daha</span>
                            @endif
                        </td>
                        <td><strong>{{ number_format($order->order_total, 2) }} ₺</strong></td>
                        <td>
                            <select class="form-input" style="width: auto; padding: 8px 12px; font-size: 0.85rem;"
                                onchange="updateOrderStatus({{ $order->id }}, this.value)">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Beklemede
                                </option>
                                <option value="preparing" {{ $order->order_status == 'preparing' ? 'selected' : '' }}>Hazırlanıyor
                                </option>
                                <option value="on_way" {{ $order->order_status == 'on_way' ? 'selected' : '' }}>Yolda</option>
                                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Tamamlandı
                                </option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>İptal
                                </option>
                            </select>
                        </td>
                        <td style="color: var(--admin-text-light);">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">
                                <i class="las la-eye"></i> Detay
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--admin-text-light);">
                            <i class="las la-shopping-bag" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                            Henüz sipariş yok
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($orders->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $orders->links() }}
            </div>
        @endif
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
                            // Show success feedback
                            const alert = document.createElement('div');
                            alert.className = 'alert alert-success';
                            alert.innerHTML = '<i class="las la-check-circle"></i> ' + data.message;
                            document.querySelector('.admin-content').prepend(alert);
                            setTimeout(() => alert.remove(), 3000);
                        }
                    })
                    .catch(err => console.error(err));
            }
        </script>
    @endpush
@endsection