<x-layouts.app :title="$product->name">

    <div class="py-3" style="background:#fff;border-bottom:1px solid #E5E7EB">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <livewire:shop.product-detail :slug="$product->slug" />
    </div>

</x-layouts.app>
