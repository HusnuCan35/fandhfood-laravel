@extends('layouts.app')

@section('title', 'Sipariş Tamamla - FandhFood')

@section('content')
    <div class="container" style="min-height: 80vh; padding-top: 120px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div
                    style="background: white; border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header -->
                    <div
                        style="background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%); padding: 30px; color: white;">
                        <h1 style="font-family: 'Marck Script', cursive; font-size: 2.5rem; margin: 0;">Sipariş Özeti</h1>
                        <p style="opacity: 0.9; margin-top: 10px;">Siparişinizi tamamlamak için aşağıdaki bilgileri doldurun
                        </p>
                    </div>

                    <div style="padding: 30px;">
                        <!-- Delivery Options (at top) -->
                        <div
                            style="margin-bottom: 30px; background: #f0f9ff; border-radius: 16px; padding: 20px; border: 2px solid #bae6fd;">
                            <h3 style="font-weight: 600; margin-bottom: 15px; color: #0369a1; font-size: 1.1rem;">
                                <i class="las la-cog"></i> Teslimat Seçenekleri
                            </h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                                <label
                                    style="display: flex; align-items: center; background: white; padding: 12px 16px; border-radius: 10px; cursor: pointer; flex: 1; min-width: 200px; border: 2px solid #e0e0e0; transition: all 0.3s;">
                                    <input type="checkbox" id="leave_at_door" name="leave_at_door"
                                        style="width: 18px; height: 18px; margin-right: 10px; accent-color: var(--main-color);">
                                    <span style="display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-door-open"
                                            style="font-size: 1.3rem; color: var(--main-color);"></i>
                                        Kapıya Bırak
                                    </span>
                                </label>
                                <label
                                    style="display: flex; align-items: center; background: white; padding: 12px 16px; border-radius: 10px; cursor: pointer; flex: 1; min-width: 200px; border: 2px solid #e0e0e0; transition: all 0.3s;">
                                    <input type="checkbox" id="no_bell" name="no_bell"
                                        style="width: 18px; height: 18px; margin-right: 10px; accent-color: var(--main-color);">
                                    <span style="display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-bell-slash"
                                            style="font-size: 1.3rem; color: var(--main-color);"></i>
                                        Zili Çalma
                                    </span>
                                </label>
                                <label
                                    style="display: flex; align-items: center; background: white; padding: 12px 16px; border-radius: 10px; cursor: pointer; flex: 1; min-width: 200px; border: 2px solid #e0e0e0; transition: all 0.3s;">
                                    <input type="checkbox" id="eco_friendly" name="eco_friendly"
                                        style="width: 18px; height: 18px; margin-right: 10px; accent-color: #10b981;">
                                    <span style="display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-leaf" style="font-size: 1.3rem; color: #10b981;"></i>
                                        Doğayı Koru <small style="color: #888; font-size: 0.75rem;">(Plastik çatal, bıçak
                                            istemiyorum)</small>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Delivery Time Selection -->
                        <div
                            style="margin-bottom: 30px; background: #fdf4ff; border-radius: 16px; padding: 20px; border: 2px solid #e879f9;">
                            <h3 style="font-weight: 600; margin-bottom: 15px; color: #a21caf; font-size: 1.1rem;">
                                <i class="las la-clock"></i> Teslimat Zamanı
                            </h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 15px;">
                                <label id="deliveryNowLabel"
                                    style="display: flex; align-items: center; background: white; padding: 14px 20px; border-radius: 10px; cursor: pointer; flex: 1; min-width: 180px; border: 2px solid #a21caf; transition: all 0.3s;">
                                    <input type="radio" name="delivery_time_type" value="now" id="deliveryNow" checked
                                        style="width: 18px; height: 18px; margin-right: 10px; accent-color: #a21caf;">
                                    <span style="display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-bolt" style="font-size: 1.3rem; color: #a21caf;"></i>
                                        <strong>Şimdi Gelsin</strong>
                                    </span>
                                </label>
                                <label id="deliveryScheduledLabel"
                                    style="display: flex; align-items: center; background: white; padding: 14px 20px; border-radius: 10px; cursor: pointer; flex: 1; min-width: 180px; border: 2px solid #e0e0e0; transition: all 0.3s;">
                                    <input type="radio" name="delivery_time_type" value="scheduled" id="deliveryScheduled"
                                        style="width: 18px; height: 18px; margin-right: 10px; accent-color: #a21caf;">
                                    <span style="display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-calendar-check" style="font-size: 1.3rem; color: #a21caf;"></i>
                                        <strong>İleri Tarihli</strong>
                                    </span>
                                </label>
                            </div>
                            <!-- Scheduled delivery options (hidden by default) -->
                            <div id="scheduledOptions"
                                style="display: none; background: white; padding: 15px; border-radius: 10px; border: 2px solid #e9d5ff;">
                                <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                                    <div style="flex: 1; min-width: 150px;">
                                        <label
                                            style="display: block; font-weight: 500; margin-bottom: 8px; color: #7c3aed;">Tarih</label>
                                        <select id="delivery_date"
                                            style="width: 100%; padding: 12px; border: 2px solid #e9d5ff; border-radius: 8px; font-size: 1rem; background: white;">
                                            <option value="{{ date('Y-m-d') }}">Bugün ({{ date('d.m.Y') }})</option>
                                            <option value="{{ date('Y-m-d', strtotime('+1 day')) }}">Yarın
                                                ({{ date('d.m.Y', strtotime('+1 day')) }})</option>
                                        </select>
                                    </div>
                                    <div style="flex: 1; min-width: 150px;">
                                        <label
                                            style="display: block; font-weight: 500; margin-bottom: 8px; color: #7c3aed;">Saat</label>
                                        <select id="delivery_hour"
                                            style="width: 100%; padding: 12px; border: 2px solid #e9d5ff; border-radius: 8px; font-size: 1rem; background: white;">
                                            <option value="10:00">10:00</option>
                                            <option value="11:00">11:00</option>
                                            <option value="12:00">12:00</option>
                                            <option value="13:00">13:00</option>
                                            <option value="14:00">14:00</option>
                                            <option value="15:00">15:00</option>
                                            <option value="16:00">16:00</option>
                                            <option value="17:00">17:00</option>
                                            <option value="18:00">18:00</option>
                                            <option value="19:00">19:00</option>
                                            <option value="20:00">20:00</option>
                                            <option value="21:00">21:00</option>
                                            <option value="22:00">22:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div style="margin-bottom: 30px;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h3 style="font-weight: 600; margin: 0; color: var(--text-color);">
                                    <i class="las la-shopping-cart"></i> Sepetinizdeki Ürünler
                                </h3>
                                <button type="button" onclick="clearCart()"
                                    style="background: #fee2e2; color: #dc2626; border: none; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 5px;">
                                    <i class="las la-trash"></i> Sepeti Boşalt
                                </button>
                            </div>

                            <div id="cartItemsContainer">
                                @foreach($cartItems as $item)
                                    <div class="cart-item-row" data-item-id="{{ $item->id }}"
                                        style="display: flex; align-items: center; padding: 15px; background: #f9f9f9; border-radius: 12px; margin-bottom: 10px;">
                                        <img src="{{ $item->product->product_image }}" alt="{{ $item->product->product_name }}"
                                            style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover; margin-right: 15px;">
                                        <div style="flex: 1;">
                                            <h4 style="font-weight: 600; margin: 0 0 5px 0;">{{ $item->product->product_name }}
                                            </h4>
                                            @if($item->options->count() > 0)
                                                <p style="font-size: 0.85rem; color: #888; margin: 0;">
                                                    {{ $item->options->map(fn($o) => $o->productOption->option_name)->join(', ') }}
                                                </p>
                                            @endif
                                        </div>
                                        <!-- Quantity Controls -->
                                        <div style="display: flex; align-items: center; gap: 10px; margin-right: 15px;">
                                            <button type="button" onclick="updateQuantity({{ $item->id }}, 'decrease')"
                                                style="width: 32px; height: 32px; border-radius: 8px; border: 2px solid #e0e0e0; background: white; cursor: pointer; font-size: 1rem; font-weight: bold; color: #666;">−</button>
                                            <span id="qty-{{ $item->id }}"
                                                style="font-weight: 600; min-width: 25px; text-align: center;">{{ $item->product_number }}</span>
                                            <button type="button" onclick="updateQuantity({{ $item->id }}, 'increase')"
                                                style="width: 32px; height: 32px; border-radius: 8px; border: 2px solid #e0e0e0; background: white; cursor: pointer; font-size: 1rem; font-weight: bold; color: #666;">+</button>
                                        </div>
                                        <div style="text-align: right; min-width: 80px;">
                                            @if($item->product->has_campaign)
                                                <span
                                                    style="text-decoration: line-through; opacity: 0.6; font-size: 0.85rem; display: block;">₺{{ number_format($item->product->product_price, 2) }}</span>
                                                <span
                                                    style="font-weight: 600; color: #10b981;">₺{{ number_format($item->product->discounted_price, 2) }}</span>
                                            @else
                                                <span
                                                    style="font-weight: 600; color: var(--main-color);">₺{{ number_format($item->product->product_price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Subtotal (Ara Toplam) -->
                            <div
                                style="display: flex; justify-content: space-between; padding: 20px; background: linear-gradient(135deg, #f0f0f0 0%, #fafafa 100%); border-radius: 12px; margin-top: 15px;">
                                <span style="font-size: 1.2rem; font-weight: 600;">Ara Toplam</span>
                                <span id="subtotal"
                                    style="font-size: 1.4rem; font-weight: 700; color: var(--text-color);">₺{{ number_format($cart->total_price, 2) }}</span>
                            </div>

                            <!-- Coupon Code -->
                            <div
                                style="margin-top: 15px; padding: 20px; background: #fff8f0; border: 2px dashed var(--main-color); border-radius: 12px;">
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 10px; color: var(--main-color);">
                                    <i class="las la-ticket-alt"></i> Kupon Kodu
                                </label>
                                <div style="display: flex; gap: 10px;">
                                    <input type="text" id="couponCode" placeholder="Kupon kodunu girin"
                                        value="{{ $appliedCoupon['code'] ?? '' }}" {{ $appliedCoupon ? 'readonly' : '' }}
                                        style="flex: 1; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; text-transform: uppercase; {{ $appliedCoupon ? 'background: #f0f0f0;' : '' }}">
                                    @if($appliedCoupon)
                                        <button type="button" onclick="removeCoupon()" id="removeCouponBtn"
                                            style="padding: 12px 20px; background: #dc2626; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: inherit; display: flex; align-items: center; gap: 5px;">
                                            <i class="las la-times"></i> Kaldır
                                        </button>
                                    @else
                                        <button type="button" onclick="applyCoupon()" id="couponBtn"
                                            style="padding: 12px 20px; background: var(--main-color); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: inherit;">
                                            Uygula
                                        </button>
                                    @endif
                                </div>
                                <p id="couponMessage" style="margin-top: 8px; font-size: 0.9rem; display: none;"></p>
                            </div>

                            <!-- All Discounts Display (Campaign + Coupon) -->
                            @php
                                $campaignSavings = 0;
                                $campaignDetails = [];
                                foreach ($cartItems as $item) {
                                    if ($item->product->has_campaign) {
                                        $saving = ($item->product->product_price - $item->product->discounted_price) * $item->product_number;
                                        $campaignSavings += $saving;
                                        $campaign = $item->product->getActiveCampaign();
                                        if ($campaign) {
                                            $campaignDetails[$campaign->id] = [
                                                'name' => $campaign->name,
                                                'percent' => $campaign->discount_percent,
                                                'savings' => ($campaignDetails[$campaign->id]['savings'] ?? 0) + $saving,
                                            ];
                                        }
                                    }
                                }
                                $couponDiscount = $appliedCoupon['discount'] ?? 0;
                                $totalDiscounts = $campaignSavings + $couponDiscount;
                            @endphp

                            @if($campaignSavings > 0 || $couponDiscount > 0)
                                <div id="discountsSection"
                                    style="margin-top: 15px; padding: 15px 20px; background: #ecfdf5; border: 2px dashed #10b981; border-radius: 12px;">
                                    <div
                                        style="font-weight: 600; margin-bottom: 10px; color: #059669; display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-gift" style="font-size: 1.2rem;"></i> Uygulanan İndirimler
                                    </div>

                                    <!-- Campaign Discounts -->
                                    @foreach($campaignDetails as $detail)
                                        <div
                                            style="display: flex; justify-content: space-between; color: #047857; font-size: 0.95rem; margin-bottom: 5px;">
                                            <span><i class="las la-tag"></i> {{ $detail['name'] }}
                                                (%{{ $detail['percent'] }})</span>
                                            <span style="font-weight: 600;">-₺{{ number_format($detail['savings'], 2) }}</span>
                                        </div>
                                    @endforeach

                                    <!-- Coupon Discount - only show if coupon is applied -->
                                    @if($couponDiscount > 0)
                                        <div id="couponDiscountRow"
                                            style="display: flex; justify-content: space-between; color: #047857; font-size: 0.95rem; margin-bottom: 5px;">
                                            <span><i class="las la-ticket-alt"></i> Kupon (<span
                                                    id="appliedCode">{{ $appliedCoupon['code'] ?? '' }}</span>)</span>
                                            <span style="font-weight: 600;">-₺<span
                                                    id="discountAmount">{{ number_format($couponDiscount, 2) }}</span></span>
                                        </div>
                                    @else
                                        <div id="couponDiscountRow"
                                            style="display: none; justify-content: space-between; color: #047857; font-size: 0.95rem; margin-bottom: 5px;">
                                            <span><i class="las la-ticket-alt"></i> Kupon (<span id="appliedCode"></span>)</span>
                                            <span style="font-weight: 600;">-₺<span id="discountAmount">0</span></span>
                                        </div>
                                    @endif

                                    <div
                                        style="display: flex; justify-content: space-between; color: #059669; font-weight: 700; margin-top: 10px; padding-top: 10px; border-top: 1px solid #a7f3d0;">
                                        <span>Toplam Tasarruf</span>
                                        <span id="totalSavings">-₺{{ number_format($totalDiscounts, 2) }}</span>
                                    </div>
                                </div>
                            @else
                                <div id="discountsSection"
                                    style="margin-top: 15px; padding: 15px 20px; background: #ecfdf5; border: 2px dashed #10b981; border-radius: 12px; display: none;">
                                    <div
                                        style="font-weight: 600; margin-bottom: 10px; color: #059669; display: flex; align-items: center; gap: 8px;">
                                        <i class="las la-gift" style="font-size: 1.2rem;"></i> Uygulanan İndirimler
                                    </div>
                                    <div id="couponDiscountRow"
                                        style="display: flex; justify-content: space-between; color: #047857; font-size: 0.95rem; margin-bottom: 5px;">
                                        <span><i class="las la-ticket-alt"></i> Kupon (<span id="appliedCode"></span>)</span>
                                        <span style="font-weight: 600;">-₺<span id="discountAmount">0</span></span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; color: #059669; font-weight: 700; margin-top: 10px; padding-top: 10px; border-top: 1px solid #a7f3d0;">
                                        <span>Toplam Tasarruf</span>
                                        <span id="totalSavings">-₺0.00</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Final Total -->
                            <div
                                style="display: flex; justify-content: space-between; padding: 20px; background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%); border-radius: 12px; margin-top: 15px; color: white;">
                                <span style="font-size: 1.2rem; font-weight: 600;">Toplam Tutar</span>
                                <span id="finalTotal" style="font-size: 1.6rem; font-weight: 700;">
                                    ₺{{ number_format($cart->total_price - $couponDiscount, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Delivery Form -->
                        <form id="checkoutForm">
                            <h3 style="font-weight: 600; margin-bottom: 20px; color: var(--text-color);">
                                <i class="las la-truck"></i> Teslimat Bilgileri
                            </h3>

                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-weight: 500; margin-bottom: 8px;">Telefon Numarası
                                    *</label>
                                <div style="position: relative;">
                                    <input type="tel" name="phone" id="phone" value="{{ $user->phone }}"
                                        placeholder="05XX XXX XX XX" required
                                        style="width: 100%; padding: 15px 15px 15px 50px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; font-family: inherit; transition: all 0.3s;">
                                    <i class="las la-phone"
                                        style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 1.2rem;"></i>
                                </div>
                            </div>

                            <!-- Address Selection -->
                            <div style="margin-bottom: 20px;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <label style="font-weight: 500;">Teslimat Adresi *</label>
                                    <button type="button" onclick="openAddressModal()"
                                        style="background: var(--main-color); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                        <i class="las la-plus"></i> Yeni Adres
                                    </button>
                                </div>

                                <input type="hidden" name="address_id" id="selectedAddressId"
                                    value="{{ $defaultAddress?->id }}">

                                <div id="addressList" style="display: grid; gap: 12px;">
                                    @forelse($addresses as $addr)
                                        <div class="address-card {{ $addr->is_default ? 'selected' : '' }}"
                                            data-address-id="{{ $addr->id }}" onclick="selectAddress({{ $addr->id }})"
                                            style="padding: 16px; border: 2px solid {{ $addr->is_default ? 'var(--main-color)' : '#e0e0e0' }}; border-radius: 12px; cursor: pointer; transition: all 0.3s; background: {{ $addr->is_default ? '#fff8f0' : 'white' }}; position: relative;">
                                            <div style="display: flex; align-items: start; gap: 12px;">
                                                <div
                                                    style="width: 40px; height: 40px; border-radius: 10px; background: {{ $addr->address_type == 'home' ? '#fef3c7' : ($addr->address_type == 'work' ? '#dbeafe' : '#f3e8ff') }}; display: flex; align-items: center; justify-content: center;">
                                                    <i class="las {{ $addr->getTypeIcon() }}"
                                                        style="font-size: 1.4rem; color: {{ $addr->address_type == 'home' ? '#b45309' : ($addr->address_type == 'work' ? '#1d4ed8' : '#7c3aed') }};"></i>
                                                </div>
                                                <div style="flex: 1;">
                                                    <div
                                                        style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                                        <strong style="font-size: 1.05rem;">{{ $addr->title }}</strong>
                                                        @if($addr->is_default)
                                                            <span
                                                                style="background: var(--main-color); color: white; font-size: 0.7rem; padding: 2px 8px; border-radius: 10px;">Varsayılan</span>
                                                        @endif
                                                    </div>
                                                    <p style="color: #666; font-size: 0.9rem; margin: 0; line-height: 1.4;">
                                                        {{ $addr->getFormattedAddress() }}
                                                    </p>
                                                    @if($addr->directions)
                                                        <p
                                                            style="color: #888; font-size: 0.8rem; margin: 6px 0 0 0; font-style: italic;">
                                                            <i class="las la-info-circle"></i> {{ $addr->directions }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div style="display: flex; gap: 8px;">
                                                    <button type="button"
                                                        onclick="event.stopPropagation(); editAddress({{ $addr->id }})"
                                                        style="width: 32px; height: 32px; border: none; background: #f0f0f0; border-radius: 8px; cursor: pointer;">
                                                        <i class="las la-pen" style="color: #666;"></i>
                                                    </button>
                                                    <button type="button"
                                                        onclick="event.stopPropagation(); deleteAddress({{ $addr->id }})"
                                                        style="width: 32px; height: 32px; border: none; background: #fee2e2; border-radius: 8px; cursor: pointer;">
                                                        <i class="las la-trash" style="color: #dc2626;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Selection indicator -->
                                            <div class="selection-check"
                                                style="position: absolute; top: 10px; right: 10px; width: 24px; height: 24px; border-radius: 50%; background: var(--main-color); display: {{ $addr->is_default ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
                                                <i class="las la-check" style="color: white; font-size: 0.9rem;"></i>
                                            </div>
                                        </div>
                                    @empty
                                        <div id="noAddressMessage"
                                            style="text-align: center; padding: 40px 20px; background: #f9f9f9; border-radius: 12px; border: 2px dashed #ddd;">
                                            <i class="las la-map-marker-alt"
                                                style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                                            <p style="color: #888; margin: 0;">Henüz kayıtlı adresiniz yok</p>
                                            <button type="button" onclick="openAddressModal()"
                                                style="margin-top: 15px; background: var(--main-color); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 600; cursor: pointer;">
                                                <i class="las la-plus"></i> İlk Adresimi Ekle
                                            </button>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Payment Method Selection -->
                            <div style="margin-bottom: 25px;">
                                <label style="display: block; font-weight: 600; margin-bottom: 12px; font-size: 1.05rem;">
                                    <i class="las la-credit-card" style="color: var(--main-color); margin-right: 5px;"></i>
                                    Ödeme Yöntemi *
                                </label>

                                <div style="display: grid; gap: 12px;">
                                    <!-- Cash -->
                                    <label class="payment-option selected" data-method="cash"
                                        onclick="selectPaymentMethod('cash')"
                                        style="display: flex; align-items: center; gap: 15px; padding: 18px 20px; border: 2px solid var(--main-color); border-radius: 14px; cursor: pointer; background: #fff8f0; transition: all 0.3s;">
                                        <div
                                            style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="las la-money-bill-wave" style="font-size: 1.6rem; color: white;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <strong style="display: block; font-size: 1.05rem; margin-bottom: 3px;">Nakit
                                                Ödeme</strong>
                                            <span style="color: #666; font-size: 0.9rem;">Kapıda nakit olarak ödeme
                                                yapın</span>
                                        </div>
                                        <div class="payment-check"
                                            style="width: 26px; height: 26px; border-radius: 50%; background: var(--main-color); display: flex; align-items: center; justify-content: center;">
                                            <i class="las la-check" style="color: white; font-size: 0.9rem;"></i>
                                        </div>
                                    </label>

                                    <!-- Card at Door -->
                                    <label class="payment-option" data-method="card_at_door"
                                        onclick="selectPaymentMethod('card_at_door')"
                                        style="display: flex; align-items: center; gap: 15px; padding: 18px 20px; border: 2px solid #e0e0e0; border-radius: 14px; cursor: pointer; background: white; transition: all 0.3s;">
                                        <div
                                            style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="las la-credit-card" style="font-size: 1.6rem; color: white;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <strong style="display: block; font-size: 1.05rem; margin-bottom: 3px;">Kapıda
                                                Kartla Ödeme</strong>
                                            <span style="color: #666; font-size: 0.9rem;">Kredi/banka kartı ile ödeme
                                                yapın</span>
                                        </div>
                                        <div class="payment-check"
                                            style="width: 26px; height: 26px; border-radius: 50%; background: var(--main-color); display: none; align-items: center; justify-content: center;">
                                            <i class="las la-check" style="color: white; font-size: 0.9rem;"></i>
                                        </div>
                                    </label>

                                    <!-- Meal Card -->
                                    <label class="payment-option" data-method="meal_card"
                                        onclick="selectPaymentMethod('meal_card')"
                                        style="display: flex; align-items: center; gap: 15px; padding: 18px 20px; border: 2px solid #e0e0e0; border-radius: 14px; cursor: pointer; background: white; transition: all 0.3s;">
                                        <div
                                            style="width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="las la-utensils" style="font-size: 1.6rem; color: white;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <strong style="display: block; font-size: 1.05rem; margin-bottom: 3px;">Yemek
                                                Kartı ile Ödeme</strong>
                                            <span style="color: #666; font-size: 0.9rem;">Sodexo, Multinet, Ticket
                                                vb.</span>
                                        </div>
                                        <div class="payment-check"
                                            style="width: 26px; height: 26px; border-radius: 50%; background: var(--main-color); display: none; align-items: center; justify-content: center;">
                                            <i class="las la-check" style="color: white; font-size: 0.9rem;"></i>
                                        </div>
                                    </label>
                                </div>

                                <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="cash">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-weight: 500; margin-bottom: 8px;">Sipariş Notu
                                    (Opsiyonel)</label>
                                <div style="position: relative;">
                                    <textarea name="note" id="note" rows="2"
                                        placeholder="Varsa özel isteklerinizi belirtin..."
                                        style="width: 100%; padding: 15px 15px 15px 50px; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; font-family: inherit; resize: none; transition: all 0.3s;"></textarea>
                                    <i class="las la-comment"
                                        style="position: absolute; left: 16px; top: 20px; color: #aaa; font-size: 1.2rem;"></i>
                                </div>
                            </div>

                            <!-- Courier Note (at bottom) -->
                            <div
                                style="margin-bottom: 30px; background: #fef3c7; border-radius: 12px; padding: 20px; border: 2px solid #fcd34d;">
                                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #b45309;">
                                    <i class="las la-motorcycle"></i> Kuryeye Not (Opsiyonel)
                                </label>
                                <textarea name="courier_note" id="courier_note" rows="2"
                                    placeholder="Örn: Sarı renkli bina, 3. kat kapı zili çalışmıyor..."
                                    style="width: 100%; padding: 12px; border: 2px solid #fcd34d; border-radius: 10px; font-size: 0.95rem; font-family: inherit; resize: none; background: white;"></textarea>
                            </div>

                            <div style="display: flex; gap: 15px;">
                                <a href="{{ route('home') }}"
                                    style="flex: 1; padding: 16px; border: 2px solid #eee; border-radius: 12px; text-align: center; text-decoration: none; color: var(--text-color); font-weight: 600; transition: all 0.3s;">
                                    <i class="las la-arrow-left"></i> Alışverişe Devam
                                </a>
                                <button type="submit" id="submitBtn"
                                    style="flex: 2; padding: 16px; background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: inherit;">
                                    <i class="las la-check-circle"></i> Siparişi Onayla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Current cart total from se         rver
            let currentSubtotal = {{ $cart->total_price }};
            let currentCouponDiscount = {{ $couponDiscount }};
            let campaignSavings = {{ $campaignSavings }};

            // Toggle scheduled delivery options
            document.querySelectorAll('input[name="delivery_time_type"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    const scheduledOptions = document.getElementById('scheduledOptions');
                    const nowLabel = document.getElementById('deliveryNowLabel');
                    const scheduledLabel = document.getElementById('deliveryScheduledLabel');

                    if (this.value === 'scheduled') {
                        scheduledOptions.style.display = 'block';
                        scheduledLabel.style.borderColor = '#a21caf';
                        nowLabel.style.borderColor = '#e0e0e0';
                    } else {
                        scheduledOptions.style.display = 'none';
                        nowLabel.style.borderColor = '#a21caf';
                        scheduledLabel.style.borderColor = '#e0e0e0';
                    }
                });
            });

            // Update quantity
            function updateQuantity(itemId, action) {
                fetch('{{ url("/sepet") }}/' + itemId, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: action }),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.quantity === 0) {
                                document.querySelector(`[data-item-id="${itemId}"]`).remove();
                            } else {
                                document.getElementById('qty-' + itemId).textContent = data.quantity;
                            }
                            location.reload();
                        }
                    })
                    .catch(err => {
                        showAlert('Bir hata oluştu!', 'error');
                    });
            }

            // Clear cart
            function clearCart() {
                if (!confirm('Sepetinizi boşaltmak istediğinize emin misiniz?')) return;

                fetch('{{ route("cart.clear") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message);
                            setTimeout(() => {
                                window.location.href = '{{ route("home") }}';
                            }, 1500);
                        } else {
                            showAlert(data.message, 'error');
                        }
                    })
                    .catch(err => {
                        showAlert('Bir hata oluştu!', 'error');
                    });
            }

            // Apply coupon code
            function applyCoupon() {
                const code = document.getElementById('couponCode').value.trim();
                if (!code) {
                    showCouponMessage('Lütfen kupon kodu girin.', false);
                    return;
                }

                const btn = document.getElementById('couponBtn');
                btn.disabled = true;
                btn.textContent = '...';

                fetch('{{ route("cart.applyCoupon") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ coupon_code: code }),
                })
                    .then(res => res.json())
                    .then(data => {
                        btn.disabled = false;
                        btn.textContent = 'Uygula';

                        if (data.success) {
                            showCouponMessage(data.message, true);
                            currentCouponDiscount = data.discount;

                            // Show discounts section
                            document.getElementById('discountsSection').style.display = 'block';
                            document.getElementById('couponDiscountRow').style.display = 'flex';
                            document.getElementById('appliedCode').textContent = data.coupon_code;
                            document.getElementById('discountAmount').textContent = data.discount.toFixed(2);

                            // Update total savings
                            const totalSavings = campaignSavings + data.discount;
                            document.getElementById('totalSavings').textContent = '-₺' + totalSavings.toFixed(2);

                            // Update final total (subtract coupon from current subtotal)
                            document.getElementById('finalTotal').textContent = '₺' + data.new_total.toFixed(2);
                            // U                    pdate coupon input to readonly
                            const couponInput = document.getElementById('couponCode');
                            couponInput.readOnly = true;
                            couponInput.style.background = '#f0f0f0';

                            // Replace "Uygula" button with "Kaldır" button
                            btn.outerHTML = `<button type="button" onclick="removeCoupon()" id="removeCouponBtn"
                                                                                        style="padding: 12px 20px; background: #dc2626; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-family: inherit; display: flex; align-items: center; gap: 5px;">
                                                                                        <i class="las la-times"></i> Kaldır
                                                                                    </button>`;
                        } else {
                            showCouponMessage(data.message, false);
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.textContent = 'Uygula';
                        showCouponMessage('Bir hata oluştu.', false);
                    });
            }

            function showCouponMessage(msg, success) {
                const el = document.getElementById('couponMessage');
                el.textContent = msg;
                el.style.display = 'block';
                el.style.color = success ? '#10b981' : '#ef4444';
            }

            // Remove coupon code
            function removeCoupon() {
                const btn = document.getElementById('removeCouponBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="las la-spinner la-spin"></i>';

                fetch('{{ route("cart.removeCoupon") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showCouponMessage(data.message, true);
                            // Reload page to reset coupon state
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        } else {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="las la-times"></i> Kaldır';
                            showCouponMessage(data.message, false);
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="las la-times"></i> Kaldır';
                        showCouponMessage('Bir hata oluştu.', false);
                    });
            }

            document.getElementById('checkoutForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="las la-spinner la-spin"></i> İşleniyor...';

                const deliveryTimeType = document.querySelector('input[name="delivery_time_type"]:checked').value;

                fetch('{{ route("cart.placeOrder") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        phone: document.getElementById('phone').value,
                        address_id: document.getElementById('selectedAddressId').value,
                        payment_method: document.getElementById('selectedPaymentMethod').value,
                        note: document.getElementById('note').value,
                        leave_at_door: document.getElementById('leave_at_door').checked,
                        no_bell: document.getElementById('no_bell').checked,
                        eco_friendly: document.getElementById('eco_friendly').checked,
                        courier_note: document.getElementById('courier_note').value,
                        delivery_time_type: deliveryTimeType,
                        delivery_date: deliveryTimeType === 'scheduled' ? document.getElementById('delivery_date').value : null,
                        delivery_hour: deliveryTimeType === 'scheduled' ? document.getElementById('delivery_hour').value : null,
                    }),
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showAlert(data.message);
                            setTimeout(() => {
                                window.location.href = '{{ route("home") }}';
                            }, 2000);
                        } else {
                            showAlert(data.message, 'error');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="las la-check-circle"></i> Siparişi Onayla';
                        }
                    })
                    .catch(err => {
                        showAlert('Bir hata oluştu!', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="las la-check-circle"></i> Siparişi Onayla';
                    });
            });

            // Style focus states
            document.querySelectorAll('input, textarea, select').forEach(el => {
                el.addEventListener('focus', function () {
                    this.style.borderColor = 'var(--main-color)';
                    this.style.boxShadow = '0 0 0 4px rgba(255, 126, 32, 0.1)';
                });
                el.addEventListener('blur', function () {
                    this.style.borderColor = '#eee';
                    this.style.boxShadow = 'none';
                });
            });

            // Checkbox hover effects
            document.querySelectorAll('label:has(input[type="checkbox"])').forEach(label => {
                label.addEventListener('mouseenter', function () {
                    this.style.borderColor = 'var(--main-color)';
                    this.style.background = '#fff8f0';
                });
                label.addEventListener('mouseleave', function () {
                    if (!this.querySelector('input').checked) {
                        this.style.borderColor = '#e0e0e0';
                        this.style.background = 'white';
                    }
                });
                label.querySelector('input').addEventListener('change', function () {
                    if (this.checked) {
                        label.style.borderColor = 'var(--main-color)';
                        label.style.background = '#fff8f0';
                    } else {
                        label.style.borderColor = '#e0e0e0';
                        label.style.background = 'white';
                    }
                });
            });

            // Payment method selection
            function selectPaymentMethod(method) {
                document.getElementById('selectedPaymentMethod').value = method;

                document.querySelectorAll('.payment-option').forEach(opt => {
                    const isSelected = opt.dataset.method === method;
                    opt.style.borderColor = isSelected ? 'var(--main-color)' : '#e0e0e0';
                    opt.style.background = isSelected ? '#fff8f0' : 'white';
                    opt.classList.toggle('selected', isSelected);
                    opt.querySelector('.payment-check').style.display = isSelected ? 'flex' : 'none';
                });
            }

            // Address functions
            let editingAddressId = null;

            function openAddressModal(addressData = null) {
                editingAddressId = addressData?.id || null;
                document.getElementById('addressModal').style.display = 'flex';
                document.getElementById('modalTitle').textContent = addressData ? 'Adresi Düzenle' : 'Yeni Adres Ekle';

                // Fill form if editing
                document.getElementById('addrTitle').value = addressData?.title || '';
                document.getElementById('addrType').value = addressData?.type || 'home';
                document.getElementById('addrFull').value = addressData?.full_address || '';
                document.getElementById('addrDistrict').value = addressData?.district || '';
                document.getElementById('addrCity').value = addressData?.city || '';
                document.getElementById('addrBuilding').value = addressData?.building_no || '';
                document.getElementById('addrFloor').value = addressData?.floor || '';
                document.getElementById('addrApartment').value = addressData?.apartment_no || '';
                document.getElementById('addrDirections').value = addressData?.directions || '';
                document.getElementById('addrDefault').checked = addressData?.is_default || false;
            }

            function closeAddressModal() {
                document.getElementById('addressModal').style.display = 'none';
                editingAddressId = null;
            }

            function saveAddress() {
                const data = {
                    title: document.getElementById('addrTitle').value,
                    address_type: document.getElementById('addrType').value,
                    full_address: document.getElementById('addrFull').value,
                    district: document.getElementById('addrDistrict').value,
                    city: document.getElementById('addrCity').value,
                    building_no: document.getElementById('addrBuilding').value,
                    floor: document.getElementById('addrFloor').value,
                    apartment_no: document.getElementById('addrApartment').value,
                    directions: document.getElementById('addrDirections').value,
                    is_default: document.getElementById('addrDefault').checked,
                };

                const url = editingAddressId
                    ? '{{ url("/adres") }}/' + editingAddressId
                    : '{{ route("address.store") }}';
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
                            showAlert(result.message, 'error');
                        }
                    })
                    .catch(err => {
                        showAlert('Bir hata oluştu!', 'error');
                    });
            }

            function selectAddress(addressId) {
                document.getElementById('selectedAddressId').value = addressId;

                // Update visual selection
                document.querySelectorAll('.address-card').forEach(card => {
                    const isSelected = card.dataset.addressId == addressId;
                    card.style.borderColor = isSelected ? 'var(--main-color)' : '#e0e0e0';
                    card.style.background = isSelected ? '#fff8f0' : 'white';
                    card.querySelector('.selection-check').style.display = isSelected ? 'flex' : 'none';
                });
            }

            function editAddress(addressId) {
                fetch('{{ route("address.index") }}', {
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

            function deleteAddress(addressId) {
                if (!confirm('Bu adresi silmek istediğinize emin misiniz?')) return;

                fetch('{{ url("/adres") }}/' + addressId, {
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
    <div id="addressModal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
        <div
            style="background: white; border-radius: 20px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
            <div
                style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h3 id="modalTitle" style="margin: 0; font-weight: 600;">Yeni Adres Ekle</h3>
                <button type="button" onclick="closeAddressModal()"
                    style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666;">&times;</button>
            </div>
            <div style="padding: 20px;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Adres Başlığı *</label>
                    <input type="text" id="addrTitle" placeholder="Örn: Evim, İş Yerim"
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Adres Tipi</label>
                    <select id="addrType"
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; background: white;">
                        <option value="home">🏠 Ev</option>
                        <option value="work">🏢 İş</option>
                        <option value="other">📍 Diğer</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Tam Adres *</label>
                    <textarea id="addrFull" rows="3" placeholder="Mahalle, sokak, cadde bilgileri..."
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: none;"></textarea>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 6px;">İlçe</label>
                        <input type="text" id="addrDistrict" placeholder="İlçe"
                            style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 6px;">Şehir</label>
                        <input type="text" id="addrCity" placeholder="Şehir"
                            style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 6px;">Bina No</label>
                        <input type="text" id="addrBuilding" placeholder="No"
                            style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 6px;">Kat</label>
                        <input type="text" id="addrFloor" placeholder="Kat"
                            style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 6px;">Daire</label>
                        <input type="text" id="addrApartment" placeholder="Daire"
                            style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem;">
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 500; margin-bottom: 6px;">Adres Tarifi (Opsiyonel)</label>
                    <textarea id="addrDirections" rows="2" placeholder="Örn: Sarı bina, soldaki kapı..."
                        style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; resize: none;"></textarea>
                </div>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; margin-bottom: 20px;">
                    <input type="checkbox" id="addrDefault"
                        style="width: 18px; height: 18px; accent-color: var(--main-color);">
                    <span>Varsayılan adres olarak kaydet</span>
                </label>
                <button type="button" onclick="saveAddress()"
                    style="width: 100%; padding: 14px; background: var(--main-color); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer;">
                    <i class="las la-save"></i> Kaydet
                </button>
            </div>
        </div>
    </div>
@endsection