<div class="py-4" id="checkout-form-root">
    <h2 class="font-poppins fw-bold mb-4">Checkout</h2>

    {{-- Steps --}}
    <div class="checkout-steps mb-4">
        <div class="step {{ $step >= 1 ? ($step > 1 ? 'done' : 'active') : '' }}">
            <div class="step-num">{{ $step > 1 ? '✓' : '1' }}</div>
            <div class="step-label">Shipping</div>
            <div class="step-line"></div>
        </div>
        <div class="step {{ $step >= 2 ? ($step > 2 ? 'done' : 'active') : '' }}">
            <div class="step-num">{{ $step > 2 ? '✓' : '2' }}</div>
            <div class="step-label">Payment</div>
            <div class="step-line"></div>
        </div>
        <div class="step {{ $step >= 3 ? 'active' : '' }}">
            <div class="step-num">3</div>
            <div class="step-label">Review</div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Step 1: Shipping --}}
            @if($step === 1)
                <div class="bg-white rounded-3 border p-4">
                    <h5 class="font-poppins fw-bold mb-4">Billing Address</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" wire:model="billing_name" class="form-control @error('billing_name') is-invalid @enderror" placeholder="John Doe">
                            @error('billing_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" wire:model="billing_email" class="form-control @error('billing_email') is-invalid @enderror" placeholder="john@example.com">
                            @error('billing_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="tel" wire:model="billing_phone" class="form-control" placeholder="+1 234 567 8900">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Street Address *</label>
                            <input type="text" wire:model="billing_address" class="form-control @error('billing_address') is-invalid @enderror" placeholder="123 Main St">
                            @error('billing_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City *</label>
                            <input type="text" wire:model="billing_city" class="form-control @error('billing_city') is-invalid @enderror" placeholder="New York">
                            @error('billing_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State *</label>
                            <input type="text" wire:model="billing_state" class="form-control @error('billing_state') is-invalid @enderror" placeholder="NY">
                            @error('billing_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ZIP Code *</label>
                            <input type="text" wire:model="billing_zip" class="form-control @error('billing_zip') is-invalid @enderror" placeholder="10001">
                            @error('billing_zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" wire:model.live="same_as_billing" class="form-check-input" id="sameAsBilling" checked>
                                <label class="form-check-label" for="sameAsBilling">Ship to the same address</label>
                            </div>
                        </div>

                        @if(!$same_as_billing)
                            <div class="col-12 mt-2">
                                <hr>
                                <h6 class="font-poppins fw-bold mb-3">Shipping Address</h6>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Street Address</label>
                                <input type="text" wire:model="shipping_address" class="form-control" placeholder="123 Main St">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" wire:model="shipping_city" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" wire:model="shipping_state" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ZIP</label>
                                <input type="text" wire:model="shipping_zip" class="form-control">
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button wire:click="nextStep" class="btn btn-primary px-5">Continue to Payment →</button>
                    </div>
                </div>
            @endif

            {{-- Step 2: Payment --}}
            @if($step === 2)
                <div class="bg-white rounded-3 border p-4">
                    <h5 class="font-poppins fw-bold mb-4">Payment Method</h5>
                    <div class="d-flex flex-column gap-3">

                        {{-- Stripe --}}
                        <label class="d-flex align-items-center gap-3 p-3 border rounded-3 {{ $payment_method === 'stripe' ? 'border-primary bg-light' : '' }}" style="cursor:pointer">
                            <input type="radio" wire:model.live="payment_method" value="stripe" class="form-check-input mt-0">
                            <div class="flex-grow-1">
                                <div class="fw-600 d-flex align-items-center gap-2">
                                    Credit / Debit Card
                                    <span class="d-flex gap-1">
                                        <img src="https://cdn.jsdelivr.net/npm/@fontsource/inter/files/../../../public/visa.svg" height="20" alt=""
                                             onerror="this.style.display='none'">
                                    </span>
                                    <span class="badge bg-success ms-1" style="font-size:0.7rem">Secure</span>
                                </div>
                                <small class="text-muted">Visa, Mastercard, Amex — powered by Stripe</small>
                            </div>
                            <svg width="32" height="20" viewBox="0 0 60 25" fill="none"><rect width="60" height="25" rx="4" fill="#635BFF"/><text x="30" y="17" font-size="10" fill="white" text-anchor="middle" font-family="sans-serif" font-weight="bold">stripe</text></svg>
                        </label>

                        {{-- Info when stripe is selected --}}
                        @if($payment_method === 'stripe')
                            <div class="border rounded-3 p-3 bg-white" style="border-color:#635BFF!important">
                                <div class="d-flex align-items-center gap-2">
                                    <svg width="14" height="14" fill="#22c55e" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    <small class="text-muted">Enter your card details on the Review step.</small>
                                </div>
                                <div class="mt-2 p-2 rounded" style="background:#f0fdf4;border:1px solid #bbf7d0">
                                    <small class="text-success fw-600">🧪 Test card: <code>4242 4242 4242 4242</code> · Any future date · Any CVC</small>
                                </div>
                            </div>
                        @endif

                        {{-- Cash on Delivery --}}
                        <label class="d-flex align-items-center gap-3 p-3 border rounded-3 {{ $payment_method === 'cod' ? 'border-primary bg-light' : '' }}" style="cursor:pointer">
                            <input type="radio" wire:model.live="payment_method" value="cod" class="form-check-input mt-0">
                            <div>
                                <div class="fw-600">Cash on Delivery</div>
                                <small class="text-muted">Pay when your order arrives</small>
                            </div>
                        </label>

                        {{-- Bank Transfer --}}
                        <label class="d-flex align-items-center gap-3 p-3 border rounded-3 {{ $payment_method === 'bank_transfer' ? 'border-primary bg-light' : '' }}" style="cursor:pointer">
                            <input type="radio" wire:model.live="payment_method" value="bank_transfer" class="form-check-input mt-0">
                            <div>
                                <div class="fw-600">Bank Transfer</div>
                                <small class="text-muted">Transfer directly to our bank account</small>
                            </div>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label class="form-label">Order Notes (optional)</label>
                        <textarea wire:model="customer_notes" class="form-control" rows="3" placeholder="Any special instructions for your order..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button wire:click="prevStep" class="btn btn-outline-secondary px-4">← Back</button>
                        <button wire:click="nextStep" class="btn btn-primary px-5">Review Order →</button>
                    </div>
                </div>
            @endif

            {{-- Step 3: Review --}}
            @if($step === 3)
                <div class="bg-white rounded-3 border p-4">
                    <h5 class="font-poppins fw-bold mb-4">Review Your Order</h5>

                    {{-- Shipping Info --}}
                    <div class="mb-4">
                        <h6 class="fw-600 text-muted small text-uppercase mb-2">Shipping To</h6>
                        <p class="mb-0">{{ $billing_name }}<br>
                        {{ $billing_address }}, {{ $billing_city }}, {{ $billing_state }} {{ $billing_zip }}<br>
                        <a href="mailto:{{ $billing_email }}">{{ $billing_email }}</a></p>
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-4">
                        <h6 class="fw-600 text-muted small text-uppercase mb-2">Payment</h6>
                        <p class="mb-0">
                            @if($payment_method === 'stripe')
                                <span class="badge" style="background:#635BFF">Stripe</span> Credit / Debit Card (secured)
                            @elseif($payment_method === 'cod')
                                Cash on Delivery
                            @else
                                Bank Transfer
                            @endif
                        </p>
                    </div>

                    {{-- Items --}}
                    <h6 class="fw-600 text-muted small text-uppercase mb-2">Items</h6>
                    @foreach($items as $item)
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="{{ $item['image_url'] }}" style="width:48px;height:48px;object-fit:cover;border-radius:0.375rem">
                            <div class="flex-grow-1">
                                <div class="small fw-600">{{ $item['name'] }}</div>
                                @if($item['variant_label']) <div class="small text-muted">{{ $item['variant_label'] }}</div> @endif
                            </div>
                            <div class="small fw-600">${{ number_format($item['price'] * $item['quantity'], 2) }} ×{{ $item['quantity'] }}</div>
                        </div>
                    @endforeach

                    {{-- Stripe Card Element for final step --}}
                    @if($payment_method === 'stripe')
                        <div wire:ignore id="stripe-card-wrapper-final" class="border rounded-3 p-3 mt-4" style="border-color:#635BFF!important">
                            <label class="form-label fw-600 mb-2">Card Details</label>
                            <div id="stripe-payment-element" style="min-height:44px"></div>
                            <div id="stripe-payment-errors" class="text-danger small mt-2" role="alert"></div>
                            <div class="mt-2 p-2 rounded" style="background:#f0fdf4;border:1px solid #bbf7d0">
                                <small class="text-success fw-600">🧪 Test: <code>4242 4242 4242 4242</code> · Any future date · Any CVC</small>
                            </div>
                        </div>
                    @endif

                    <div id="stripe-processing" class="text-center py-3 d-none">
                        <div class="spinner-border text-primary spinner-border-sm me-2"></div>
                        <span class="text-muted">Processing payment…</span>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button wire:click="prevStep" class="btn btn-outline-secondary px-4" id="btn-back-review">← Back</button>
                        <button
                            id="btn-place-order"
                            wire:click="{{ $payment_method === 'stripe' ? '' : 'placeOrder' }}"
                            @if($payment_method === 'stripe') onclick="stripeSubmit(event)" @endif
                            class="btn btn-success btn-lg px-5"
                        >
                            @if($payment_method === 'stripe')
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-2" style="vertical-align:-2px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            @endif
                            Pay ${{ number_format($total, 2) }}
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-4">
            <div class="order-summary-card">
                <h6 class="font-poppins fw-bold mb-3">Order Summary</h6>
                @foreach($items as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">{{ Str::limit($item['name'], 30) }} ×{{ $item['quantity'] }}</span>
                        <span class="small fw-600">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="summary-row">
                    <span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span>
                </div>
                @if($discount > 0)
                    <div class="summary-row text-success">
                        <span>Discount</span><span>−${{ number_format($discount, 2) }}</span>
                    </div>
                @endif
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>{{ $shipping == 0 ? 'Free' : '$' . number_format($shipping, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Tax</span><span>${{ number_format($tax, 2) }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span><span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
(function () {
    const STRIPE_KEY = '{{ config('services.stripe.key') }}';
    let stripe       = null;
    let cardElement  = null;
    let clientSecret = null;
    let domObserver  = null;

    // ── Init Stripe ───────────────────────────────────────────────────────────
    function initStripe() {
        if (!STRIPE_KEY || STRIPE_KEY.startsWith('sk_') || STRIPE_KEY.includes('00000')) {
            console.warn('[Stripe] STRIPE_KEY must be a pk_test_... publishable key.');
            return;
        }
        try {
            stripe = Stripe(STRIPE_KEY);
            console.log('[Stripe] Initialized OK');
            startDomObserver();
        } catch (e) {
            console.error('[Stripe] Init failed:', e.message);
        }
    }

    // ── Watch DOM for #stripe-payment-element appearing ───────────────────────
    // Using MutationObserver is the most reliable way to react to Livewire
    // morphing the DOM — works regardless of Livewire hook API version.
    function startDomObserver() {
        if (domObserver) return;
        domObserver = new MutationObserver(function () {
            tryMountCard();
        });
        domObserver.observe(document.body, { childList: true, subtree: true });
        // Also try immediately in case the element is already in the DOM
        tryMountCard();
    }

    // ── Mount card element (idempotent) ──────────────────────────────────────
    function tryMountCard() {
        const container = document.getElementById('stripe-payment-element');
        if (!stripe || !container) return;

        // Already has an iframe → Stripe card is mounted, nothing to do
        if (container.querySelector('iframe')) return;

        // Unmount stale instance if we have one
        if (cardElement) {
            try { cardElement.unmount(); } catch (_) {}
            cardElement = null;
        }

        console.log('[Stripe] Mounting card element…');
        const elements = stripe.elements();
        cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#0F172A',
                    fontFamily: 'Inter, sans-serif',
                    '::placeholder': { color: '#9CA3AF' },
                },
                invalid: { color: '#EF4444' },
            },
            hidePostalCode: true,
        });
        cardElement.mount(container);
        cardElement.on('change', function (e) {
            const err = document.getElementById('stripe-payment-errors');
            if (err) err.textContent = e.error ? e.error.message : '';
        });
        console.log('[Stripe] Card element mounted');
    }

    // ── Find CheckoutForm Livewire component ──────────────────────────────────
    function getCheckoutComponent() {
        const root = document.getElementById('checkout-form-root');
        const id   = root?.getAttribute('wire:id');
        if (id) return Livewire.find(id);
        for (const c of Livewire.all()) {
            if (c.name?.includes('checkout')) return c;
        }
        return null;
    }

    // ── Confirm payment with Stripe after server creates PaymentIntent ────────
    async function confirmPayment() {
        if (!stripe || !clientSecret || !cardElement) {
            console.error('[Stripe] confirmPayment missing:', { stripe: !!stripe, clientSecret: !!clientSecret, cardElement: !!cardElement });
            return;
        }

        const processing = document.getElementById('stripe-processing');
        const btn        = document.getElementById('btn-place-order');
        const backBtn    = document.getElementById('btn-back-review');
        const errEl      = document.getElementById('stripe-payment-errors');

        if (processing) processing.classList.remove('d-none');
        if (btn)        btn.disabled = true;
        if (backBtn)    backBtn.disabled = true;

        const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: { card: cardElement },
        });

        if (processing) processing.classList.add('d-none');
        if (btn)        btn.disabled = false;
        if (backBtn)    backBtn.disabled = false;

        if (error) {
            if (errEl) errEl.textContent = error.message;
            console.error('[Stripe] Payment error:', error.message);
            return;
        }

        if (paymentIntent?.status === 'succeeded') {
            console.log('[Stripe] Payment succeeded:', paymentIntent.id);
            getCheckoutComponent()?.call('finalizeStripeOrder', paymentIntent.id);
        }
    }

    // ── Bootstrap after Livewire is ready ────────────────────────────────────
    document.addEventListener('livewire:init', function () {
        initStripe();

        Livewire.on('stripe-ready', function (data) {
            const payload = Array.isArray(data) ? data[0] : data;
            clientSecret  = payload?.clientSecret ?? null;
            console.log('[Stripe] Got client secret, confirming…');
            if (clientSecret) confirmPayment();
        });
    });

    // ── Pay button handler ────────────────────────────────────────────────────
    window.stripeSubmit = function (e) {
        e.preventDefault();

        if (!stripe) {
            alert('Stripe is not ready. Make sure STRIPE_KEY in .env is your publishable key (pk_test_...) and restart the server.');
            return;
        }

        // Last-chance mount attempt (covers edge cases where observer missed it)
        tryMountCard();

        if (!cardElement) {
            alert('Card field not loaded. Please wait a moment and try again, or refresh the page.');
            return;
        }

        getCheckoutComponent()?.call('createPaymentIntent');
    };
})();
</script>
@endpush
