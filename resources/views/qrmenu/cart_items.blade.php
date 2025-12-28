@forelse($cart as $item)
    <div class="cart-item">
        <div>
            <span style="display: block; font-weight: 600;">{{ $item['name'] }}</span>
            <span class="text-muted">{{ number_format($item['price'], 2) }} ₺</span>
        </div>
        <div class="qty-control">
            <!-- Basic remove/add logic would go here, implemented simply for now -->
            <span style="font-weight: 600; padding: 0 10px;">x{{ $item['quantity'] }}</span>
        </div>
    </div>
@empty
    <p class="text-center text-muted py-3">Sepetiniz boş.</p>
@endforelse