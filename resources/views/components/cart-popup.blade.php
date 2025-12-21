@auth
    @if($cartItems->count() > 0)
        <div class="cart-popup-cards">
            @foreach($cartItems as $item)
                <div class="cart-popup-card">
                    <div class="cart-popup-card-left">
                        <img class="cart-popup-image" src="{{ $item->product->product_image }}"
                            alt="{{ $item->product->product_name }}">
                        <div class="cart-popup-cart-info">
                            <h3 class="cart-popup-food-name">{{ $item->product->product_name }}</h3>
                            @if($item->options->count() > 0)
                                <p style="font-size: 0.8rem; color: #888;">
                                    {{ $item->options->map(fn($o) => $o->productOption->option_name)->join(', ') }}
                                </p>
                            @endif
                            @if($item->product->has_campaign)
                                <p class="cart-popup-food-price"
                                    style="text-decoration: line-through; opacity: 0.6; font-size: 0.85rem; margin-bottom: 2px;">
                                    {{ number_format($item->product->product_price, 2) }} TL</p>
                                <p class="cart-popup-food-price" style="color: #10b981;">
                                    {{ number_format($item->product->discounted_price, 2) }} TL</p>
                            @else
                                <p class="cart-popup-food-price">{{ number_format($item->product->product_price, 2) }} TL</p>
                            @endif
                        </div>
                    </div>
                    <div class="cart-popup-number-container">
                        <div class="cart-popup-number">{{ $item->product_number }}</div>
                        <div class="cart-popup-number-arrows">
                            <i class="las la-angle-up" onclick="updateCartItemQuantity({{ $item->id }}, 'increase')"></i>
                            <i class="las la-angle-down" onclick="updateCartItemQuantity({{ $item->id }}, 'decrease')"></i>
                        </div>
                        <i class="las la-trash" style="cursor: pointer; color: #ff4444; margin-left: 10px;"
                            onclick="removeCartItem({{ $item->id }})"></i>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-popup-footer">
            <div class="cart-popup-total-price">
                <p>Toplam</p>
                <span>{{ number_format($cart->total_price, 2) }} TL</span>
            </div>
            <a href="{{ route('cart.checkout') }}" class="cart-popup-go-cart">Siparişi Tamamla</a>
        </div>
    @else
        <div class="cart-popup-alert">
            <i class="las la-shopping-cart"></i><br>
            Sepetinizde hiç ürün yok. Hemen alışverişe başlamak için mükemmel bir gün.
        </div>
    @endif
@else
    <div class="cart-popup-alert">
        <i class="las la-user"></i><br>
        Sipariş özelliğini kullanabilmek için giriş yapmanız gerekir.
        <a href="{{ route('login') }}" class="cart-popup-login-btn">Giriş Yap</a>
    </div>
@endauth