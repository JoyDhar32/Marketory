<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Component;

class InventoryManager extends Component
{
    public Product $product;
    public int $simpleStock = 0;
    public array $variantStocks = [];

    public function mount(int $id): void
    {
        $this->product = Product::with(['allVariants.variantAttributes.attributeType'])->findOrFail($id);
        $this->simpleStock = $this->product->stock_quantity;

        foreach ($this->product->allVariants as $variant) {
            $this->variantStocks[$variant->id] = $variant->stock_quantity;
        }
    }

    public function save(): void
    {
        if ($this->product->is_variable) {
            $total = 0;
            foreach ($this->variantStocks as $variantId => $qty) {
                $qty = max(0, (int) $qty);
                ProductVariant::where('id', $variantId)->update(['stock_quantity' => $qty]);
                $total += $qty;
            }
            $this->product->update(['stock_quantity' => $total]);
            $this->simpleStock = $total;
        } else {
            $this->product->update(['stock_quantity' => max(0, $this->simpleStock)]);
        }

        $this->dispatch('show-toast', message: 'Inventory updated!', type: 'success');
    }

    public function adjustVariantStock(int $variantId, int $amount): void
    {
        $current = $this->variantStocks[$variantId] ?? 0;
        $this->variantStocks[$variantId] = max(0, $current + $amount);
    }

    public function render()
    {
        return view('livewire.admin.products.inventory-manager')
            ->layout('layouts.admin', ['title' => 'Inventory: ' . $this->product->name]);
    }
}
