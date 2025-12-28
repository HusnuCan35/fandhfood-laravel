@extends('qrmenu.layout')

@section('content')
    <!-- Hero Section -->
    <div class="hero-banner">
        <img src="{{ asset('photo/coffe.jpg') }}" class="shop-logo animate__animated animate__fadeInDown">
        <h1 class="animate__animated animate__fadeIn">AtomFood Burger</h1>
        <div class="table-info animate__animated animate__fadeIn">
            <i class="las la-chair"></i> {{ $table->name }}
        </div>
        <p class="text-muted mb-0">Hoş geldiniz, masanıza lezzet getirelim!</p>
    </div>

<!-- Active Orders Status -->
<div id="liveOrderContainer" style="{{ $activeOrders->count() > 0 ? '' : 'display:none;' }}">
    <div class="menu-section">
        <h2 class="section-title">Canlı Sipariş Takibi</h2>
        <div id="orderList">
            @foreach($activeOrders as $order)
            <div class="order-status-card animate__animated animate__fadeIn" id="order-{{ $order->id }}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span style="font-weight: 700; font-size: 0.9rem;">Sipariş #{{ $order->id }}</span>
                    <span class="badge badge-pill badge-light time-ago">{{ $order->created_at->diffForHumans() }}</span>
                </div>
                <div class="status-steps">
                    <div class="step step-1 {{ $order->order_status == 'pending' ? 'active' : 'completed' }}">
                        <div class="step-icon"><i class="las la-check"></i></div>
                        <div class="step-label">Alındı</div>
                    </div>
                    <div class="step step-2 {{ $order->order_status == 'preparing' ? 'active' : ($order->order_status == 'ready' ? 'completed' : '') }}">
                        <div class="step-icon"><i class="las la-utensils"></i></div>
                        <div class="step-label">Hazırlanıyor</div>
                    </div>
                    <div class="step step-3 {{ $order->order_status == 'ready' ? 'active' : '' }}">
                        <div class="step-icon"><i class="las la-bell"></i></div>
                        <div class="step-label">Hazır</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

    <!-- Search Bar -->
    <div class="search-container animate__animated animate__fadeInUp">
        <div class="search-wrapper">
            <i class="las la-search"></i>
            <input type="text" id="menuSearch" class="search-input" placeholder="Ürün veya kategori ara...">
        </div>
    </div>

    <!-- Categories Nav -->
    <div class="categories-nav">
        <a href="#" class="category-pill active" data-target="all">Tümü</a>
        @foreach($categories as $category)
            @if($category->products->count() > 0)
                <a href="#cat-{{ $category->id }}" class="category-pill"
                    data-target="cat-{{ $category->id }}">{{ $category->category_name }}</a>
            @endif
        @endforeach
    </div>

    <!-- Menu Items -->
    <div class="menu-items-container">
        @foreach($categories as $category)
            @if($category->products->count() > 0)
                <div id="cat-{{ $category->id }}" class="menu-section">
                    <h2 class="section-title">{{ $category->category_name }}</h2>
                    @foreach($category->products as $product)
                        <div class="product-card animate__animated animate__fadeInUp"
                            data-name="{{ strtolower($product->product_name) }}" data-category="{{ $category->category_name }}">
                            <img src="{{ $product->product_image }}" class="product-image" alt="{{ $product->product_name }}">
                            <div class="product-details">
                                <div>
                                    <div class="p-name">{{ $product->product_name }}</div>
                                    <div class="p-desc">{{ $product->product_description }}</div>
                                    @if($product->allergens->count() > 0)
                                        <div class="allergen-icons">
                                            @foreach($product->allergens as $allergen)
                                                <div class="allergen-icon" title="{{ $allergen->name }}">
                                                    <i class="{{ $allergen->icon }}"></i>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="p-footer">
                                    <span class="p-price">{{ number_format($product->product_price, 2) }} ₺</span>
                                    <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})">
                                        <i class="las la-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <!-- Footer Cart Bar -->
    <div class="footer-cart {{ count($cart) > 0 ? 'show' : '' }}" id="footerCart" onclick="$('#cartModal').modal('show')">
        <div>
            <span class="badge-count" id="cartBadge">{{ count($cart) }}</span>
            <span style="font-weight: 600;">Sepeti Gör</span>
        </div>
        <div class="total-amount" id="cartTotal">{{ number_format($total, 2) }} ₺</div>
    </div>

    <!-- Waiter Call Buttons -->
    <div class="waiter-fab">
        <button class="fab-btn fab-bill" onclick="callWaiter('bill')" title="Hesap İste">
            <i class="las la-file-invoice-dollar"></i>
        </button>
        <button class="fab-btn fab-waiter" onclick="callWaiter('waiter')" title="Garson Çağır">
            <i class="las la-concierge-bell"></i>
        </button>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: 800;">Siparişiniz</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="cartModalBody">
                    @include('qrmenu.cart_items', ['cart' => $cart])
                </div>
                <div class="modal-footer flex-column p-4">
                    <div class="d-flex justify-content-between w-100 mb-3" style="font-size: 1.2rem; font-weight: 800;">
                        <span>Toplam</span>
                        <span class="text-primary" id="modalTotal">{{ number_format($total, 2) }} ₺</span>
                    </div>
                    <form action="{{ route('qrmenu.order.place') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block py-3"
                            style="border-radius: 16px; background: var(--primary-color); border: none; font-weight: 700;">
                            Siparişi Onayla
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Real-time Search
        document.getElementById('menuSearch').addEventListener('input', function (e) {
            let q = e.target.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                let name = card.getAttribute('data-name');
                if (name.includes(q)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            // Hide empty sections
            document.querySelectorAll('.menu-section').forEach(section => {
                let hasVisible = Array.from(section.querySelectorAll('.product-card')).some(c => c.style.display !== 'none');
                section.style.display = hasVisible ? 'block' : 'none';
            });
        });

        // SMOOTH SCROLL FOR CATEGORIES
        document.querySelectorAll('.category-pill').forEach(pill => {
            pill.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                let target = this.getAttribute('data-target');
                if (target === 'all') {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    document.getElementById(target).scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        function addToCart(productId) {
            fetch('{{ route("qrmenu.cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateCartUI(data);
                    }
                });
        }

        function updateCartUI(data) {
            // UI updates for counts and totals
            $('#cartBadge').text(data.cartCount);
            $('#cartTotal').text(formatMoney(data.total));
            $('#modalTotal').text(formatMoney(data.total));

            if (data.cartCount > 0) {
                $('#footerCart').addClass('show');
            } else {
                $('#footerCart').removeClass('show');
            }

            // Animated feedback
            let $btn = event.target.tagName === 'I' ? $(event.target).parent() : $(event.target);
            $btn.addClass('animate__animated animate__pulse');
            setTimeout(() => $btn.removeClass('animate__animated animate__pulse'), 500);

            // Ideally here you'd re-fetch cart_items partial instead of reload
            // For rapid dev we can do a reload or better, a partial refresh
            // Let's do a quiet reload without page flash if possible or just location.reload() for now
            location.reload();
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2 }).format(amount) + ' ₺';
        }

        function callWaiter(type) {
            fetch('{{ route("qrmenu.call") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ type: type })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
            });
        }

        // Real-time Status Polling
        function refreshOrderStatus() {
            fetch('{{ route("qrmenu.orders.status") }}')
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    if(data.orders.length > 0) {
                        $('#liveOrderContainer').show();
                        
                        data.orders.forEach(order => {
                            let $card = $(`#order-${order.id}`);
                            if($card.length > 0) {
                                // Update existing card status
                                $card.find('.time-ago').text(order.time);
                                
                                let $s1 = $card.find('.step-1');
                                let $s2 = $card.find('.step-2');
                                let $s3 = $card.find('.step-3');
                                
                                // Reset classes
                                $s1.removeClass('active completed');
                                $s2.removeClass('active completed');
                                $s3.removeClass('active completed');
                                
                                if(order.status === 'pending') {
                                    $s1.addClass('active');
                                } else if(order.status === 'preparing') {
                                    $s1.addClass('completed');
                                    $s2.addClass('active');
                                } else if(order.status === 'ready') {
                                    $s1.addClass('completed');
                                    $s2.addClass('completed');
                                    $s3.addClass('active');
                                }
                            } else {
                                // If a new order appeared (unlikely in this flow, but good for robust UX)
                                location.reload(); 
                            }
                        });
                    } else {
                        $('#liveOrderContainer').hide();
                    }
                }
            });
        }

        // Start polling every 10 seconds
        setInterval(refreshOrderStatus, 10000);
    </script>
@endpush