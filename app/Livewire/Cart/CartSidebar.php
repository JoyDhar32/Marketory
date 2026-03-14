<?php

namespace App\Livewire\Cart;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartSidebar extends Component
{
    public array $items = [];
    public float $subtotal = 0;
    public float $total = 0;
    public int $count = 0;

    public function mount(CartService $cart): void
    {
        $this->loadCart($cart);
    }

    #[On('cart-updated')]
    public function refresh(CartService $cart): void
    {
        $this->loadCart($cart);
    }

    private function loadCart(CartService $cart): void
    {
        $this->items    = $cart->getItems();
        $this->subtotal = $cart->getSubtotal();
        $this->total    = $cart->getTotal();
        $this->count    = $cart->getItemCount();
    }

    public function removeItem(string $key, CartService $cart): void
    {
        $cart->remove($key);
        $this->loadCart($cart);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart.cart-sidebar');
    }
}
