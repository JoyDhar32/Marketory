<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\AttributeType;
use App\Models\Attribute;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Livewire\Component;
use Livewire\Attributes\Computed;

class ProductForm extends Component
{
    public ?int $productId = null;

    // Basic Info
    public string $name            = '';
    public string $short_description = '';
    public string $description     = '';
    public int $category_id        = 0;
    public string $base_price      = '';
    public string $sale_price      = '';
    public string $cost_price      = '';
    public string $sku             = '';
    public int $stock_quantity     = 0;
    public bool $is_featured       = false;
    public bool $is_active         = true;
    public bool $is_variable       = false;

    // Images
    public array $images = [['url' => '', 'is_primary' => true]];

    // Variants
    public array $variants = [];

    public function mount(?int $id = null): void
    {
        $this->productId = $id;

        if ($id) {
            $product = Product::with(['images', 'allVariants.variantAttributes'])->findOrFail($id);
            $this->name              = $product->name;
            $this->short_description = $product->short_description ?? '';
            $this->description       = $product->description ?? '';
            $this->category_id       = $product->category_id;
            $this->base_price        = (string) $product->base_price;
            $this->sale_price        = $product->sale_price ? (string) $product->sale_price : '';
            $this->cost_price        = $product->cost_price ? (string) $product->cost_price : '';
            $this->sku               = $product->sku ?? '';
            $this->stock_quantity    = $product->stock_quantity;
            $this->is_featured       = $product->is_featured;
            $this->is_active         = $product->is_active;
            $this->is_variable       = $product->is_variable;

            $this->images = $product->images->map(fn($img) => [
                'url'        => $img->image_url,
                'is_primary' => $img->is_primary,
            ])->toArray();

            if (empty($this->images)) {
                $this->images = [['url' => '', 'is_primary' => true]];
            }

            $this->variants = $product->allVariants->map(fn($v) => [
                'sku'            => $v->sku ?? '',
                'price_modifier' => (string) $v->price_modifier,
                'stock_quantity' => $v->stock_quantity,
                'attribute_ids'  => $v->variantAttributes->pluck('id')->toArray(),
            ])->toArray();
        }
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    #[Computed]
    public function attributeTypes()
    {
        return AttributeType::with('attributes')->get();
    }

    public function addImage(): void
    {
        $this->images[] = ['url' => '', 'is_primary' => false];
    }

    public function removeImage(int $index): void
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function addVariant(): void
    {
        $this->variants[] = [
            'sku'            => '',
            'price_modifier' => '0',
            'stock_quantity' => 0,
            'attribute_ids'  => [],
        ];
    }

    public function removeVariant(int $index): void
    {
        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function save(): void
    {
        $this->validate([
            'name'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
        ]);

        $data = [
            'category_id'       => $this->category_id,
            'name'              => $this->name,
            'short_description' => $this->short_description ?: null,
            'description'       => $this->description ?: null,
            'base_price'        => $this->base_price,
            'sale_price'        => $this->sale_price ?: null,
            'cost_price'        => $this->cost_price ?: null,
            'sku'               => $this->sku ?: null,
            'stock_quantity'    => $this->is_variable
                ? collect($this->variants)->sum('stock_quantity')
                : $this->stock_quantity,
            'is_featured'       => $this->is_featured,
            'is_active'         => $this->is_active,
            'is_variable'       => $this->is_variable,
        ];

        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update($data);
        } else {
            $product = Product::create($data);
        }

        // Sync Images
        $product->images()->delete();
        foreach (array_filter($this->images, fn($i) => !empty($i['url'])) as $idx => $img) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_url'  => $img['url'],
                'is_primary' => $idx === 0,
                'sort_order' => $idx,
            ]);
        }

        // Sync Variants
        if ($this->is_variable) {
            $product->allVariants()->delete();
            foreach ($this->variants as $vData) {
                $variant = ProductVariant::create([
                    'product_id'     => $product->id,
                    'sku'            => $vData['sku'] ?: null,
                    'price_modifier' => $vData['price_modifier'] ?? 0,
                    'stock_quantity' => $vData['stock_quantity'] ?? 0,
                    'is_active'      => true,
                ]);
                if (!empty($vData['attribute_ids'])) {
                    $variant->variantAttributes()->attach($vData['attribute_ids']);
                }
            }
        }

        session()->flash('success', 'Product saved successfully!');
        redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.products.product-form')
            ->layout('layouts.admin', ['title' => $this->productId ? 'Edit Product' : 'Add Product']);
    }
}
