<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

class ProductCatalog extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $sort = 'newest';

    #[Url]
    public bool $inStockOnly = false;

    #[Url]
    public float $minPrice = 0;

    #[Url]
    public float $maxPrice = 2000;

    public int $perPage = 12;

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedCategory(): void { $this->resetPage(); }
    public function updatedSort(): void { $this->resetPage(); }
    public function updatedInStockOnly(): void { $this->resetPage(); }
    public function updatedMinPrice(): void { $this->resetPage(); }
    public function updatedMaxPrice(): void { $this->resetPage(); }

    #[Computed]
    public function categories()
    {
        return Category::active()->orderBy('sort_order')->get();
    }

    #[Computed]
    public function products()
    {
        $query = Product::active()->with(['images', 'category', 'reviews']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('short_description', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $this->category));
        }

        if ($this->inStockOnly) {
            $query->where('stock_quantity', '>', 0);
        }

        $query->whereBetween('base_price', [$this->minPrice, $this->maxPrice]);

        match ($this->sort) {
            'price_asc'  => $query->orderBy('base_price', 'asc'),
            'price_desc' => $query->orderBy('base_price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'featured'   => $query->orderBy('is_featured', 'desc')->orderBy('sort_order'),
            default      => $query->orderBy('created_at', 'desc'),
        };

        return $query->paginate($this->perPage);
    }

    public function addToCart(int $productId, CartService $cart): void
    {
        $cart->add($productId);
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart-sidebar');
        $this->dispatch('show-toast', message: 'Added to cart!', type: 'success');
    }

    public function render()
    {
        return view('livewire.shop.product-catalog');
    }
}
