<div>
    @if($items->isEmpty())
        <div class="text-center py-5">
            <svg width="80" height="80" fill="none" stroke="#D1D5DB" stroke-width="1.5" viewBox="0 0 24 24" class="mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h4 class="font-poppins fw-bold text-muted mb-2">Your wishlist is empty</h4>
            <p class="text-muted mb-4">Save items you love and come back to them anytime.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary px-5">Browse Products</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($items as $item)
                @php $product = $item->product; @endphp
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="product-card h-100 d-flex flex-col">
                        <a href="{{ route('product.show', $product->slug) }}" class="d-block position-relative overflow-hidden" style="border-radius:12px 12px 0 0">
                            <img
                                src="{{ $product->primary_image_url }}"
                                alt="{{ $product->name }}"
                                style="width:100%;height:220px;object-fit:cover"
                            >
                            @if($product->is_on_sale)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                    -{{ $product->discount_percent }}%
                                </span>
                            @endif
                        </a>
                        <div class="product-card-body d-flex flex-column flex-grow-1 p-3">
                            <div class="text-muted small mb-1">{{ $product->category->name }}</div>
                            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">
                                <h6 class="fw-600 mb-2" style="line-height:1.4">{{ $product->name }}</h6>
                            </a>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="fw-bold fs-5 {{ $product->is_on_sale ? 'text-danger' : 'text-dark' }}">
                                        ${{ number_format($product->effective_price, 2) }}
                                    </span>
                                    @if($product->is_on_sale)
                                        <span class="text-muted text-decoration-line-through small">${{ number_format($product->base_price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    @if(!$product->is_variable && $product->stock_quantity > 0)
                                        <button
                                            wire:click="addToCart({{ $product->id }})"
                                            class="btn btn-primary btn-sm flex-grow-1"
                                        >
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1" style="vertical-align:-2px">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Add to Cart
                                        </button>
                                    @else
                                        <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                            View Options
                                        </a>
                                    @endif
                                    <button
                                        wire:click="removeFromWishlist({{ $product->id }})"
                                        wire:confirm="Remove from wishlist?"
                                        class="btn btn-outline-danger btn-sm px-2"
                                        title="Remove from wishlist"
                                    >
                                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
