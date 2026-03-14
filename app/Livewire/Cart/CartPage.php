<?php

namespace App\Livewire\Cart;

use App\Services\CartService;
use Livewire\Component;

class CartPage extends Component
{
    public array $items = [];
    public float $subtotal = 0;
    public float $discount = 0;
    public float $shipping = 0;
    public float $tax = 0;
    public float $total = 0;
    public ?string $couponCode = null;
    public string $couponInput = '';
    public ?string $couponMessage = null;
    public bool $couponSuccess = false;

    public function mount(CartService $cart): void
    {
        $this->loadCart($cart);
    }

    private function loadCart(CartService $cart): void
    {
        $this->items     = $cart->getItems();
        $this->subtotal  = $cart->getSubtotal();
        $this->discount  = $cart->getDiscount();
        $this->shipping  = $cart->getShipping();
        $this->tax       = $cart->getTax();
        $this->total     = $cart->getTotal();
        $this->couponCode = $cart->getCouponCode();
    }

    public function updateQty(string $key, int $qty, CartService $cart): void
    {
        $cart->updateQuantity($key, $qty);
        $this->loadCart($cart);
        $this->dispatch('cart-updated');
    }

    public function removeItem(string $key, CartService $cart): void
    {
        $cart->remove($key);
        $this->loadCart($cart);
        $this->dispatch('cart-updated');
    }

    public function applyCoupon(CartService $cart): void
    {
        $result = $cart->applyCoupon($this->couponInput);
        if ($result === true) {
            $this->couponSuccess = true;
            $this->couponMessage = 'Coupon applied successfully!';
            $this->couponInput = '';
        } else {
            $this->couponSuccess = false;
            $this->couponMessage = $result;
        }
        $this->loadCart($cart);
    }

    public function removeCoupon(CartService $cart): void
    {
        $cart->removeCoupon();
        $this->couponMessage = null;
        $this->loadCart($cart);
    }

    public function render()
    {
        return view('livewire.cart.cart-page');
    }
}
