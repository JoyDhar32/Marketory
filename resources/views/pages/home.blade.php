<x-layouts.app title="Home — Modern Online Store">

    {{-- Hero --}}
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <p class="text-accent fw-600 mb-2 text-uppercase" style="letter-spacing:0.1em;font-size:0.85rem">New Season Arrivals</p>
                    <h1>Discover <span class="hero-accent">Premium</span> Products for Every Lifestyle</h1>
                    <p class="mt-3 mb-4">Shop thousands of curated products across electronics, fashion, home, and more — all with fast shipping and hassle-free returns.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('shop') }}" class="btn btn-lg px-5" style="background:#F97316;color:#fff;font-weight:600">Shop Now</a>
                        <a href="{{ route('shop', ['sort' => 'featured']) }}" class="btn btn-lg btn-outline-light px-5">Featured Items</a>
                    </div>
                    <div class="d-flex gap-4 mt-4">
                        <div class="text-white">
                            <div class="fw-bold fs-4 font-poppins">100+</div>
                            <div class="small" style="color:rgba(255,255,255,0.6)">Products</div>
                        </div>
                        <div class="text-white">
                            <div class="fw-bold fs-4 font-poppins">10</div>
                            <div class="small" style="color:rgba(255,255,255,0.6)">Categories</div>
                        </div>
                        <div class="text-white">
                            <div class="fw-bold fs-4 font-poppins">Free</div>
                            <div class="small" style="color:rgba(255,255,255,0.6)">Shipping $50+</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center d-none d-lg-block">
                    <div style="position:relative;display:inline-block">
                        <div style="width:420px;height:420px;border-radius:50%;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;margin:0 auto">
                            <div style="width:350px;height:350px;border-radius:50%;background:rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:center">
                                <img src="https://picsum.photos/seed/hero-main/320/320" style="width:280px;height:280px;object-fit:cover;border-radius:50%;border:4px solid rgba(255,255,255,0.2)">
                            </div>
                        </div>
                        {{-- Floating cards --}}
                        <div style="position:absolute;top:20px;right:-20px;background:#fff;border-radius:0.75rem;padding:0.75rem 1rem;box-shadow:0 8px 25px rgba(0,0,0,0.15);min-width:140px">
                            <div style="font-size:0.7rem;color:#6B7280">Today's Deal</div>
                            <div style="font-weight:700;color:#0F172A;font-size:0.9rem">Up to 50% OFF</div>
                        </div>
                        <div style="position:absolute;bottom:30px;left:-20px;background:#fff;border-radius:0.75rem;padding:0.75rem 1rem;box-shadow:0 8px 25px rgba(0,0,0,0.15);min-width:140px">
                            <div style="font-size:0.7rem;color:#6B7280">Free Shipping</div>
                            <div style="font-weight:700;color:#0F172A;font-size:0.9rem">Orders over $50</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Value Propositions --}}
    <section class="py-4" style="background:#fff;border-bottom:1px solid #E5E7EB">
        <div class="container">
            <div class="row g-3 text-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 justify-content-center">
                        <span style="font-size:2rem">🚚</span>
                        <div class="text-start">
                            <div class="fw-600 small">Free Shipping</div>
                            <div class="text-muted" style="font-size:0.8rem">On orders over $50</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 justify-content-center">
                        <span style="font-size:2rem">🔄</span>
                        <div class="text-start">
                            <div class="fw-600 small">Easy Returns</div>
                            <div class="text-muted" style="font-size:0.8rem">30-day return policy</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 justify-content-center">
                        <span style="font-size:2rem">🔒</span>
                        <div class="text-start">
                            <div class="fw-600 small">Secure Checkout</div>
                            <div class="text-muted" style="font-size:0.8rem">256-bit SSL encryption</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex align-items-center gap-3 justify-content-center">
                        <span style="font-size:2rem">🎧</span>
                        <div class="text-start">
                            <div class="fw-600 small">24/7 Support</div>
                            <div class="text-muted" style="font-size:0.8rem">Customer care anytime</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between mb-4">
                <h2 class="section-title mb-0">Shop by Category</h2>
                <a href="{{ route('shop') }}" class="text-primary fw-500 small">View All →</a>
            </div>
            <div class="row g-3">
                @foreach($categories as $cat)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('shop', ['category' => $cat->slug]) }}" class="category-card d-block text-decoration-none">
                            <img src="{{ $cat->image_url ?? 'https://picsum.photos/seed/cat-' . $cat->id . '/400/300' }}" alt="{{ $cat->name }}" loading="lazy">
                            <div class="overlay">
                                <h5>{{ $cat->name }}</h5>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    @if($featured->isNotEmpty())
        <section class="py-5" style="background:#fff">
            <div class="container">
                <div class="d-flex align-items-end justify-content-between mb-4">
                    <h2 class="section-title mb-0">Featured Products</h2>
                    <a href="{{ route('shop', ['sort' => 'featured']) }}" class="text-primary fw-500 small">View All →</a>
                </div>
                <div class="row g-3">
                    @foreach($featured as $product)
                        <div class="col-sm-6 col-lg-3">
                            <div class="product-card h-100">
                                <a href="{{ route('product.show', $product->slug) }}" class="product-img-wrap d-block">
                                    @if($product->is_on_sale)
                                        <span class="badge-sale">-{{ $product->discount_percent }}%</span>
                                    @endif
                                    <span class="badge-featured">Featured</span>
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy">
                                </a>
                                <div class="product-body d-flex flex-column">
                                    <div class="product-category">{{ $product->category->name }}</div>
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-name text-decoration-none">{{ $product->name }}</a>
                                    @if($product->reviews->count() > 0)
                                        <div class="d-flex align-items-center gap-1 mb-2">
                                            <span class="star-rating">{{ str_repeat('★', round($product->average_rating)) }}{{ str_repeat('☆', 5 - round($product->average_rating)) }}</span>
                                            <span class="text-muted" style="font-size:0.75rem">({{ $product->reviews->count() }})</span>
                                        </div>
                                    @endif
                                    <div class="product-price mt-auto mb-2">
                                        @if($product->is_on_sale)
                                            <span class="sale-price">${{ number_format($product->sale_price, 2) }}</span>
                                            <span class="original-price">${{ number_format($product->base_price, 2) }}</span>
                                        @else
                                            ${{ number_format($product->base_price, 2) }}
                                        @endif
                                    </div>
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn-add-cart d-block text-center">
                                        {{ $product->is_variable ? 'Select Options' : 'View Product' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Sale Banner --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4 align-items-center rounded-4 overflow-hidden" style="background:linear-gradient(135deg,#0F172A,#1E3A5F)">
                <div class="col-lg-6 p-5">
                    <p class="text-accent fw-600 mb-1 text-uppercase" style="font-size:0.8rem;letter-spacing:0.1em">Limited Time</p>
                    <h2 class="text-white font-poppins fw-bold mb-2">Flash Sale — Up to 50% OFF</h2>
                    <p class="mb-4" style="color:rgba(255,255,255,0.7)">Don't miss out on incredible deals across all categories. Use code <strong class="text-accent">FLASH50</strong> at checkout.</p>
                    <a href="{{ route('shop', ['sort' => 'price_asc']) }}" class="btn btn-lg px-5" style="background:#F97316;color:#fff">Shop Sale</a>
                </div>
                <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center p-4">
                    <div class="row g-2" style="max-width:380px">
                        @foreach($onSale->take(4) as $p)
                            <div class="col-6">
                                <img src="{{ $p->primary_image_url }}" style="width:100%;height:130px;object-fit:cover;border-radius:0.5rem;opacity:0.85">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- New Arrivals --}}
    @if($newArrivals->isNotEmpty())
        <section class="py-5" style="background:#fff">
            <div class="container">
                <div class="d-flex align-items-end justify-content-between mb-4">
                    <h2 class="section-title mb-0">New Arrivals</h2>
                    <a href="{{ route('shop', ['sort' => 'newest']) }}" class="text-primary fw-500 small">View All →</a>
                </div>
                <div class="row g-3">
                    @foreach($newArrivals as $product)
                        <div class="col-sm-6 col-lg-3">
                            <div class="product-card h-100">
                                <a href="{{ route('product.show', $product->slug) }}" class="product-img-wrap d-block">
                                    <span class="badge-featured" style="background:#22C55E">New</span>
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy">
                                </a>
                                <div class="product-body">
                                    <div class="product-category">{{ $product->category->name }}</div>
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-name text-decoration-none">{{ $product->name }}</a>
                                    <div class="product-price mt-2 mb-2">${{ number_format($product->effective_price, 2) }}</div>
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn-add-cart d-block text-center">View Product</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-5 text-center" style="background:#3B82F6">
        <div class="container">
            <h2 class="text-white font-poppins fw-bold mb-2">Start Shopping Today</h2>
            <p class="text-white mb-4" style="opacity:0.85">Create your account and enjoy exclusive member discounts and early access to sales.</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-lg btn-light px-5 fw-600">Create Account</a>
                <a href="{{ route('shop') }}" class="btn btn-lg btn-outline-light px-5">Browse Shop</a>
            </div>
        </div>
    </section>

</x-layouts.app>
