<div class="py-4">
    <h2 class="font-poppins fw-bold mb-4">Shopping Cart</h2>

    @if(empty($items))
        <div class="text-center py-5">
            <svg width="80" height="80" fill="none" stroke="#D1D5DB" stroke-width="1.5" viewBox="0 0 24 24" class="mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h4 class="text-muted">Your cart is empty</h4>
            <p class="text-muted">Add some products to get started!</p>
            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg mt-2">Continue Shopping</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="cart-table">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                                            <div>
                                                <a href="{{ route('product.show', $item['slug']) }}" class="fw-600 text-dark" style="font-size:0.9rem">{{ $item['name'] }}</a>
                                                @if($item['variant_label'])
                                                    <div class="text-muted" style="font-size:0.8rem">{{ $item['variant_label'] }}</div>
                                                @endif
                                                @if($item['sku'])
                                                    <div class="text-muted" style="font-size:0.75rem">SKU: {{ $item['sku'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle fw-600">${{ number_format($item['price'], 2) }}</td>
                                    <td class="text-center align-middle">
                                        <div class="qty-control justify-content-center">
                                            <button wire:click="updateQty('{{ $key }}', {{ $item['quantity'] - 1 }})">−</button>
                                            <input type="number" value="{{ $item['quantity'] }}" min="1" max="99"
                                                wire:change="updateQty('{{ $key }}', $event.target.value)">
                                            <button wire:click="updateQty('{{ $key }}', {{ $item['quantity'] + 1 }})">+</button>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle fw-bold text-primary">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td class="align-middle">
                                        <button wire:click="removeItem('{{ $key }}')" class="btn btn-sm btn-light text-danger" title="Remove">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Coupon --}}
                <div class="mt-3 p-3 bg-white rounded-3 border">
                    <div class="fw-600 small mb-2">Have a coupon code?</div>
                    @if($couponCode)
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success px-3 py-2">{{ $couponCode }} applied!</span>
                            <button wire:click="removeCoupon" class="btn btn-sm btn-outline-danger">Remove</button>
                        </div>
                    @else
                        <div class="d-flex gap-2">
                            <input type="text" wire:model="couponInput" class="form-control" placeholder="Enter coupon code" style="max-width:220px">
                            <button wire:click="applyCoupon" class="btn btn-outline-primary">Apply</button>
                        </div>
                        @if($couponMessage)
                            <div class="mt-2 small {{ $couponSuccess ? 'text-success' : 'text-danger' }}">{{ $couponMessage }}</div>
                        @endif
                        <div class="mt-2">
                            <small class="text-muted">Try: WELCOME10, SAVE20, VIP30, FLASH50</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-lg-4">
                <div class="order-summary-card">
                    <h5 class="font-poppins fw-bold mb-3">Order Summary</h5>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    @if($discount > 0)
                        <div class="summary-row text-success">
                            <span>Discount</span>
                            <span>−${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>{{ $shipping == 0 ? '<span class="text-success">Free</span>' : '$' . number_format($shipping, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (8%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100 mt-3 btn-lg">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2">
                        Continue Shopping
                    </a>
                    @if($subtotal < 50)
                        <div class="mt-3 p-2 rounded-2 text-center" style="background:#FEF3C7;font-size:0.8rem;color:#92400E">
                            Add ${{ number_format(50 - $subtotal, 2) }} more for <strong>free shipping!</strong>
                        </div>
                    @else
                        <div class="mt-3 p-2 rounded-2 text-center" style="background:#DCFCE7;font-size:0.8rem;color:#166534">
                            You qualify for <strong>free shipping!</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
