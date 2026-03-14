<div class="offcanvas offcanvas-end offcanvas-cart" tabindex="-1" id="cartSidebar" aria-labelledby="cartSidebarLabel">
    <div class="offcanvas-header border-bottom py-3">
        <h5 class="offcanvas-title font-poppins fw-bold" id="cartSidebarLabel">
            Shopping Cart
            @if($count > 0)
                <span class="badge bg-primary ms-1">{{ $count }}</span>
            @endif
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0" style="overflow-y:auto">
        @if(empty($items))
            <div class="text-center py-5 px-3">
                <svg width="64" height="64" fill="none" stroke="#D1D5DB" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-muted mb-3">Your cart is empty</p>
                <a href="{{ route('shop') }}" class="btn btn-primary" data-bs-dismiss="offcanvas">Continue Shopping</a>
            </div>
        @else
            <div class="px-3">
                @foreach($items as $key => $item)
                    <div class="cart-item d-flex gap-3">
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" loading="lazy">
                        <div class="flex-grow-1">
                            <a href="{{ route('product.show', $item['slug']) }}" class="fw-600 text-dark small" style="font-size:0.875rem;font-weight:600;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $item['name'] }}</a>
                            @if($item['variant_label'])
                                <div class="text-muted" style="font-size:0.75rem">{{ $item['variant_label'] }}</div>
                            @endif
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <span class="fw-bold text-primary">${{ number_format($item['price'], 2) }}</span>
                                <span class="text-muted small">×{{ $item['quantity'] }}</span>
                            </div>
                        </div>
                        <button wire:click="removeItem('{{ $key }}')" class="btn btn-sm btn-light p-1 align-self-start" title="Remove">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @if(!empty($items))
        <div class="border-top p-3">
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-600">Subtotal</span>
                <span class="fw-700 fs-5">${{ number_format($subtotal, 2) }}</span>
            </div>
            <a href="{{ route('cart') }}" class="btn btn-outline-primary w-100 mb-2" data-bs-dismiss="offcanvas">View Cart</a>
            <a href="{{ route('checkout') }}" class="btn btn-primary w-100" data-bs-dismiss="offcanvas">Checkout</a>
        </div>
    @endif
</div>
