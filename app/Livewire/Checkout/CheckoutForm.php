<?php

namespace App\Livewire\Checkout;

use App\Services\CartService;
use App\Services\OrderService;
use Livewire\Component;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutForm extends Component
{
    public int $step = 1;

    // Billing
    public string $billing_name    = '';
    public string $billing_email   = '';
    public string $billing_phone   = '';
    public string $billing_address = '';
    public string $billing_city    = '';
    public string $billing_state   = '';
    public string $billing_zip     = '';
    public string $billing_country = 'US';

    public bool $same_as_billing = true;

    // Shipping
    public string $shipping_name    = '';
    public string $shipping_address = '';
    public string $shipping_city    = '';
    public string $shipping_state   = '';
    public string $shipping_zip     = '';
    public string $shipping_country = 'US';

    // Payment
    public string $payment_method  = 'stripe';
    public string $customer_notes  = '';
    public string $stripeClientSecret = '';

    // Cart summary
    public float $subtotal  = 0;
    public float $discount  = 0;
    public float $shipping  = 0;
    public float $tax       = 0;
    public float $total     = 0;
    public array $items     = [];
    public ?string $couponCode = null;

    public function mount(CartService $cart): void
    {
        if (empty($cart->getItems())) {
            redirect()->route('cart');
            return;
        }

        $this->loadCartSummary($cart);

        if (auth()->check()) {
            $this->billing_name  = auth()->user()->name;
            $this->billing_email = auth()->user()->email;
        }
    }

    private function loadCartSummary(CartService $cart): void
    {
        $this->items     = $cart->getItems();
        $this->subtotal  = $cart->getSubtotal();
        $this->discount  = $cart->getDiscount();
        $this->shipping  = $cart->getShipping();
        $this->tax       = $cart->getTax();
        $this->total     = $cart->getTotal();
        $this->couponCode = $cart->getCouponCode();
    }

    public function nextStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'billing_name'    => 'required|string|max:255',
                'billing_email'   => 'required|email|max:255',
                'billing_address' => 'required|string|max:500',
                'billing_city'    => 'required|string|max:100',
                'billing_state'   => 'required|string|max:100',
                'billing_zip'     => 'required|string|max:20',
            ]);
        }
        if ($this->step < 3) $this->step++;
    }

    public function prevStep(): void
    {
        if ($this->step > 1) $this->step--;
    }

    /** Called from JS after Stripe confirms payment */
    public function finalizeStripeOrder(string $paymentIntentId, CartService $cart, OrderService $orderService): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);
        } catch (\Exception $e) {
            $this->dispatch('show-toast', message: 'Payment verification failed. Please try again.', type: 'error');
            return;
        }

        if ($intent->status !== 'succeeded') {
            $this->dispatch('show-toast', message: 'Payment not completed. Please try again.', type: 'error');
            return;
        }

        $billing  = $this->billingArray();
        $shipping = $this->same_as_billing ? $billing : $this->shippingArray($billing);

        $order = $orderService->createOrder($billing, $shipping, 'stripe', $this->customer_notes ?: null, $paymentIntentId);

        $this->dispatch('cart-updated');
        $this->redirect(route('order.confirmation', $order->order_number));
    }

    /** Called from JS to get client_secret for Stripe.js */
    public function createPaymentIntent(CartService $cart): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $amountInCents = (int) round($cart->getTotal() * 100);

        $intent = PaymentIntent::create([
            'amount'   => $amountInCents,
            'currency' => 'usd',
            'metadata' => [
                'customer_email' => $this->billing_email,
                'customer_name'  => $this->billing_name,
            ],
        ]);

        $this->stripeClientSecret = $intent->client_secret;
        $this->dispatch('stripe-ready', clientSecret: $intent->client_secret);
    }

    public function placeOrder(CartService $cart, OrderService $orderService): void
    {
        $this->validate([
            'billing_name'    => 'required',
            'billing_email'   => 'required|email',
            'billing_address' => 'required',
            'billing_city'    => 'required',
            'billing_state'   => 'required',
            'billing_zip'     => 'required',
            'payment_method'  => 'required',
        ]);

        // Stripe is handled entirely via JS → finalizeStripeOrder()
        if ($this->payment_method === 'stripe') {
            $this->dispatch('stripe-submit');
            return;
        }

        $billing  = $this->billingArray();
        $shipping = $this->same_as_billing ? $billing : $this->shippingArray($billing);

        $order = $orderService->createOrder($billing, $shipping, $this->payment_method, $this->customer_notes ?: null);

        $this->dispatch('cart-updated');
        $this->redirect(route('order.confirmation', $order->order_number));
    }

    private function billingArray(): array
    {
        return [
            'name'    => $this->billing_name,
            'email'   => $this->billing_email,
            'phone'   => $this->billing_phone,
            'address' => $this->billing_address,
            'city'    => $this->billing_city,
            'state'   => $this->billing_state,
            'zip'     => $this->billing_zip,
            'country' => $this->billing_country,
        ];
    }

    private function shippingArray(array $billing): array
    {
        return [
            'name'    => $this->shipping_name    ?: $billing['name'],
            'address' => $this->shipping_address ?: $billing['address'],
            'city'    => $this->shipping_city    ?: $billing['city'],
            'state'   => $this->shipping_state   ?: $billing['state'],
            'zip'     => $this->shipping_zip     ?: $billing['zip'],
            'country' => $this->shipping_country ?: $billing['country'],
        ];
    }

    public function render(CartService $cart)
    {
        $this->loadCartSummary($cart);
        return view('livewire.checkout.checkout-form');
    }
}
