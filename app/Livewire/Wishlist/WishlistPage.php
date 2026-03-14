<?php

namespace App\Livewire\Wishlist;

use App\Models\Wishlist;
use App\Services\CartService;
use Livewire\Component;

class WishlistPage extends Component
{
    public function removeFromWishlist(int $productId): void
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

        $this->dispatch('show-toast', message: 'Removed from wishlist.', type: 'info');
    }

    public function addToCart(int $productId, CartService $cart): void
    {
        $cart->add($productId, null, 1);
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-sidebar');
        $this->dispatch('show-toast', message: 'Added to cart!', type: 'success');
    }

    public function render()
    {
        $items = Wishlist::with(['product.images', 'product.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('livewire.wishlist.wishlist-page', compact('items'));
    }
}
