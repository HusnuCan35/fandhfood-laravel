@extends('layouts.app')

@section('title', 'FandhFood - Lezzetli Türk Mutfağı')

@section('content')
    <div class="container">
        <!-- Hero Section -->
        <div class="row">
            <div class="col-lg-6 home-page-welcome">
                <h2 class="font-marck">Türk Mutfağı</h2>
                <h3>Çorba, pide, sulu yemek gibi çeşitlerimiz ile zengin mutfağımızı keşfedin ve hemen sipariş verin.</h3>
                <a href="#products"><button>Sipariş Ver <i class="las la-arrow-right"></i></button></a>
            </div>
            <div class="col-lg-6">
                <div class="background-1">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400" alt="Lezzetli Yemekler">
                    <div class="home-page-back-circle"></div>
                </div>
            </div>
            <div class="background-text font-quicksand-m">FandhFood</div>
        </div>

        <!-- Cards Module -->
        @if($modules['cards'] ?? false)
            @include('modules.cards')
        @endif

        <!-- Why Us Module -->
        @if($modules['why_us'] ?? false)
            @include('modules.why-us')
        @endif

        <!-- Products Module -->
        @if($modules['products'] ?? false)
            <section class="products-section" id="products">
                <article class="products-article">
                    <div class="row products-title-and-navigation">
                        <h2 class="col-lg-2 font-marck">Menü</h2>
                        <nav class="col-lg-10">
                            <ul>
                                @foreach($categories as $index => $category)
                                    <li onclick="getMenu({{ $index }})"
                                        class="products-navigation-button {{ $index === 0 ? 'products-navigation-active' : '' }}">
                                        {{ $category->category_name }}
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    @foreach($categories as $catIndex => $category)
                        <div class="products" style="{{ $catIndex === 0 ? 'display: flex;' : 'display: none;' }}">
                            <div class="row w-100">
                                @foreach($category->products as $product)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="product">
                                            @if($product->has_campaign)
                                                <div class="product-discount-badge">
                                                    <span>%{{ $product->campaign_discount }}</span>
                                                    <small>İNDİRİM</small>
                                                </div>
                                            @endif
                                            <div class="product-image">
                                                <img src="{{ $product->product_image }}" alt="{{ $product->product_name }}">
                                                <div class="product-image-blur"></div>
                                                <div class="product-price-and-addtocart">
                                                    @if($product->isInStock())
                                                        <div class="product-price-wrap">
                                                            @if($product->has_campaign)
                                                                <p class="product-price-old">₺ {{ number_format($product->product_price, 2) }}</p>
                                                                <p class="product-price product-price-discounted">₺ {{ number_format($product->discounted_price, 2) }}</p>
                                                            @else
                                                                <p class="product-price">₺ {{ number_format($product->product_price, 2) }}</p>
                                                            @endif
                                                        </div>
                                                        @auth
                                                            <button type="button" class="product-addtocart"
                                                                onclick="openProductPopup({{ $product->id }})">
                                                                <i class="las la-cart-plus"></i>
                                                            </button>
                                                        @else
                                                            <a href="{{ route('login') }}">
                                                                <button type="button" class="product-addtocart-login">
                                                                    <i class="las la-cart-plus"></i>
                                                                </button>
                                                            </a>
                                                        @endauth
                                                    @else
                                                        <div class="product-no-stock">Stokta Yok</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h2 class="product-title">{{ $product->product_name }}</h2>
                                                <div class="product-point-and-stars">
                                                    <div class="product-stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= floor($product->product_point))
                                                                <i class="las la-star"></i>
                                                            @elseif($i - 0.5 <= $product->product_point)
                                                                <i class="las la-star-half-alt"></i>
                                                            @else
                                                                <i class="lar la-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <div class="product-point">{{ $product->product_point }}</div>
                                                </div>
                                                <p class="product-description">{{ Str::limit($product->product_description, 80) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </article>
            </section>
        @endif

        <!-- Comments Module -->
        @if($modules['comments'] ?? false)
            <section class="comments-section" id="comments">
                <h2 class="font-marck">Müşteri Yorumları</h2>
                <div class="row justify-content-center">
                    @foreach($comments as $comment)
                        <div class="col-lg-6">
                            <div class="comment-card {{ $loop->first ? 'comment-card-active' : '' }}">
                                <div class="comment-card-header">
                                    <div class="comment-user-avatar">
                                        {{ strtoupper(substr($comment->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="comment-user-name">{{ $comment->user->name ?? 'Anonim' }}</div>
                                        <div class="comment-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="las la-star"
                                                    style="color: {{ $i <= $comment->rating ? '#ffc107' : '#ddd' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="comment-text">{{ $comment->comment_text }}</p>
                                <div class="comment-actions">
                                    <button class="comment-action-btn" onclick="likeComment({{ $comment->id }})">
                                        <i class="las la-thumbs-up"></i>
                                        <span id="helpful-{{ $comment->id }}">{{ $comment->helpful }}</span>
                                    </button>
                                    <button class="comment-action-btn" onclick="dislikeComment({{ $comment->id }})">
                                        <i class="las la-thumbs-down"></i>
                                        <span id="not-helpful-{{ $comment->id }}">{{ $comment->not_helpful }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Branches Module -->
        @if($modules['our_branches'] ?? false)
            <section class="branches-section" id="branches">
                <h2 class="font-marck">Şubelerimiz</h2>
                <div class="row">
                    <div class="col-lg-4">
                        @foreach($branches as $index => $branch)
                            <div class="branch-card {{ $index === 0 ? 'active' : '' }}"
                                onclick="selectBranch('{{ $branch->branch_name }}', {{ $branch->branch_lat }}, {{ $branch->branch_lng }}, this)">
                                <h3 class="branch-name">{{ $branch->branch_name }}</h3>
                                <p class="branch-address"><i class="las la-map-marker"></i> {{ $branch->branch_address }}</p>
                                <p class="branch-phone"><i class="las la-phone"></i> {{ $branch->branch_phone }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-8">
                        <div id="our-branches-map"></div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Who Are We Module -->
        @if($modules['who_are_we'] ?? false)
            @include('modules.who-are-we')
        @endif
    </div>

    @push('scripts')
        <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJYNPAXC6IZWpsK7SYrssjO3kvzA2XnuQ&callback=initMapCallback"></script>
        <script>
            function initMapCallback() {
                @if($branches->count() > 0)
                    const firstBranch = @json($branches->first());
                    selectBranch(firstBranch.branch_name, firstBranch.branch_lat, firstBranch.branch_lng, document.querySelector('.branch-card'));
                @endif
            }
        </script>
    @endpush
@endsection