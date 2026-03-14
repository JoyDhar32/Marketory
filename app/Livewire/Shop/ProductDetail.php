<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use App\Models\Wishlist;
use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\Computed;

class ProductDetail extends Component
{
    public Product $product;
    public array $selectedAttributes = [];
    public int $quantity = 1;
    public ?int $selectedVariantId = null;
    public bool $inWishlist = false;

    public function mount(string $slug): void
    {
        $this->product = Product::with(['images', 'category', 'reviews', 'variants.variantAttributes.attributeType'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if (auth()->check()) {
            $this->inWishlist = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $this->product->id)
                ->exists();
        }
    }

    // Called by a dedicated method so Livewire properly tracks state
    public function selectAttribute(string $typeSlug, int $attrId): void
    {
        $this->selectedAttributes[$typeSlug] = $attrId;
        $this->quantity = 1; // reset qty on variant change
        $this->findMatchingVariant();
    }

    private function findMatchingVariant(): void
    {
        if (empty($this->selectedAttributes)) {
            $this->selectedVariantId = null;
            return;
        }

        $attrIds = array_values($this->selectedAttributes);

        foreach ($this->product->variants as $variant) {
            $variantAttrIds = $variant->variantAttributes->pluck('id')->toArray();
            sort($attrIds);
            sort($variantAttrIds);
            if ($attrIds === $variantAttrIds) {
                $this->selectedVariantId = $variant->id;
                return;
            }
        }

        $this->selectedVariantId = null;
    }

    #[Computed]
    public function effectivePrice(): float
    {
        if ($this->selectedVariantId) {
            $variant = $this->product->variants->firstWhere('id', $this->selectedVariantId);
            return $variant ? $variant->effective_price : $this->product->effective_price;
        }
        return $this->product->effective_price;
    }

    #[Computed]
    public function isInStock(): bool
    {
        if ($this->product->is_variable) {
            if (!$this->selectedVariantId) return false;
            $variant = $this->product->variants->firstWhere('id', $this->selectedVariantId);
            return $variant ? $variant->stock_quantity > 0 : false;
        }
        return $this->product->stock_quantity > 0;
    }

    #[Computed]
    public function maxStock(): int
    {
        if ($this->product->is_variable) {
            if (!$this->selectedVariantId) return 0;
            $variant = $this->product->variants->firstWhere('id', $this->selectedVariantId);
            return $variant ? $variant->stock_quantity : 0;
        }
        return $this->product->stock_quantity;
    }

    #[Computed]
    public function groupedAttributes(): array
    {
        $grouped = [];
        foreach ($this->product->variants as $variant) {
            foreach ($variant->variantAttributes as $attr) {
                $typeSlug    = $attr->attributeType->slug;
                $displayType = $attr->attributeType->display_type;
                if (!isset($grouped[$typeSlug])) {
                    $grouped[$typeSlug] = [
                        'name'         => $attr->attributeType->name,
                        'display_type' => $displayType,
                        'attributes'   => [],
                    ];
                }
                if (!isset($grouped[$typeSlug]['attributes'][$attr->id])) {
                    $grouped[$typeSlug]['attributes'][$attr->id] = [
                        'id'        => $attr->id,
                        'value'     => $attr->value,
                        'color_hex' => $attr->color_hex,
                    ];
                }
            }
        }
        return $grouped;
    }

    public function addToCart(CartService $cart): void
    {
        if ($this->product->is_variable && !$this->selectedVariantId) {
            $this->dispatch('show-toast', message: 'Please select all options first.', type: 'warning');
            return;
        }

        if (!$this->isInStock) {
            $this->dispatch('show-toast', message: 'This item is out of stock.', type: 'error');
            return;
        }

        $max = $this->maxStock;
        if ($this->quantity > $max) {
            $this->quantity = $max;
        }

        $cart->add($this->product->id, $this->selectedVariantId, $this->quantity);
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-sidebar');
        $this->dispatch('show-toast', message: 'Added to cart!', type: 'success');
    }

    public function buyNow(CartService $cart): void
    {
        if ($this->product->is_variable && !$this->selectedVariantId) {
            $this->dispatch('show-toast', message: 'Please select all options first.', type: 'warning');
            return;
        }

        if (!$this->isInStock) {
            $this->dispatch('show-toast', message: 'This item is out of stock.', type: 'error');
            return;
        }

        $cart->add($this->product->id, $this->selectedVariantId, $this->quantity);
        $this->dispatch('cart-updated');
        $this->redirect(route('checkout'));
    }

    public function toggleWishlist(): void
    {
        if (!auth()->check()) {
            $this->dispatch('show-toast', message: 'Please log in to save to wishlist.', type: 'info');
            return;
        }

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($exists) {
            $exists->delete();
            $this->inWishlist = false;
            $this->dispatch('show-toast', message: 'Removed from wishlist.', type: 'info');
        } else {
            Wishlist::create([
                'user_id'    => auth()->id(),
                'product_id' => $this->product->id,
            ]);
            $this->inWishlist = true;
            $this->dispatch('show-toast', message: 'Added to wishlist!', type: 'success');
        }
    }

    public function incrementQty(): void
    {
        $max = $this->maxStock;
        if ($max === 0) return; // out of stock — do nothing
        if ($this->quantity < min(10, $max)) {
            $this->quantity++;
        }
    }

    public function decrementQty(): void
    {
        if ($this->quantity > 1) $this->quantity--;
    }

    public function render()
    {
        return view('livewire.shop.product-detail');
    }
}
