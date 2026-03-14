<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

class ProductList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $stock = '';

    #[Url]
    public string $sort = 'newest';

    public ?int $deleteId = null;

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedCategory(): void { $this->resetPage(); }
    public function updatedStock(): void { $this->resetPage(); }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    #[Computed]
    public function products()
    {
        $query = Product::with(['category'])->withTrashed(false);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->stock === 'low') {
            $query->whereBetween('stock_quantity', [1, 10]);
        } elseif ($this->stock === 'out') {
            $query->where('stock_quantity', '<=', 0);
        }

        match ($this->sort) {
            'price_asc'  => $query->orderBy('base_price'),
            'price_desc' => $query->orderBy('base_price', 'desc'),
            'name'       => $query->orderBy('name'),
            'stock_asc'  => $query->orderBy('stock_quantity'),
            default      => $query->latest(),
        };

        return $query->paginate(15);
    }

    public function toggleActive(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);
        $this->dispatch('show-toast', message: 'Product status updated.', type: 'success');
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
    }

    public function deleteProduct(): void
    {
        if ($this->deleteId) {
            Product::findOrFail($this->deleteId)->delete();
            $this->deleteId = null;
            $this->dispatch('show-toast', message: 'Product deleted.', type: 'success');
        }
    }

    public function render()
    {
        return view('livewire.admin.products.product-list')
            ->layout('layouts.admin', ['title' => 'Products']);
    }
}
