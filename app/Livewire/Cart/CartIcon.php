<?php

namespace App\Livewire\Cart;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    public int $count = 0;

    public function mount(CartService $cart): void
    {
        $this->count = $cart->getItemCount();
    }

    #[On('cart-updated')]
    public function refresh(CartService $cart): void
    {
        $this->count = $cart->getItemCount();
    }

    public function render()
    {
        return view('livewire.cart.cart-icon');
    }
}
