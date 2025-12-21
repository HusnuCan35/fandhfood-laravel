<div class="addtocart-popup">
    <button class="addtocart-popup-close" onclick="closeProductPopup()">
        <i class="las la-times"></i>
    </button>

    <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}" class="addtocart-popup-image">

    <h2 class="addtocart-popup-title">{{ $product->product_name }}</h2>
    @if($product->has_campaign)
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <span class="addtocart-popup-price" style="text-decoration: line-through; opacity: 0.6; font-size: 1rem;">₺
                {{ number_format($product->product_price, 2) }}</span>
            <span class="addtocart-popup-price" style="color: #10b981;">₺
                {{ number_format($product->discounted_price, 2) }}</span>
            <span
                style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 3px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">%{{ $product->campaign_discount }}
                İNDİRİM</span>
        </div>
    @else
        <p class="addtocart-popup-price">₺ {{ number_format($product->product_price, 2) }}</p>
    @endif

    @if($product->product_description)
        <p style="color: #888; margin-bottom: 20px;">{{ $product->product_description }}</p>
    @endif

    <form id="addtocartForm">
        @foreach($optionSettings as $setting)
            <div class="option-group">
                <h4 class="option-group-title">
                    {{ $setting->options_title ?? $setting->options_name }}
                    @if($setting->isRadio())
                        <span style="color: #ff4444; font-size: 0.8rem;">(Zorunlu)</span>
                    @endif
                </h4>

                @foreach($setting->options as $option)
                    <label class="option-item">
                        <input type="{{ $setting->isRadio() ? 'radio' : 'checkbox' }}"
                            name="{{ $setting->isRadio() ? 'radio_' . $setting->id : 'checkbox_' . $setting->id . '[]' }}"
                            value="{{ $option->id }}" {{ $setting->isRadio() && $loop->first ? 'checked' : '' }}>
                        <span>{{ $option->option_name }}</span>
                        @if($option->option_price > 0)
                            <span class="option-price">+₺ {{ number_format($option->option_price, 2) }}</span>
                        @endif
                    </label>
                @endforeach
            </div>
        @endforeach

        <div class="quantity-control">
            <button type="button" class="quantity-btn" onclick="decreaseQuantity()">
                <i class="las la-minus"></i>
            </button>
            <input type="number" name="quantity" class="cart-item-quantity" value="1" min="1"
                max="{{ $product->stock }}" readonly>
            <button type="button" class="quantity-btn" onclick="increaseQuantity()">
                <i class="las la-plus"></i>
            </button>
            <span style="color: #888; font-size: 0.9rem;">Stok: {{ $product->stock }}</span>
        </div>

        <textarea name="note" class="addtocart-textarea" rows="3" placeholder="Sipariş notunuz (opsiyonel)"></textarea>

        <button type="button" class="addtocart-submit" onclick="addToCart({{ $product->id }})">
            <i class="las la-cart-plus"></i> Sepete Ekle
        </button>
    </form>
</div>