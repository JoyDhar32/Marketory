<x-layouts.app title="Shop">

    <div class="py-4" style="background:#fff;border-bottom:1px solid #E5E7EB">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </nav>
            <h1 class="font-poppins fw-bold mb-0" style="font-size:1.75rem">All Products</h1>
        </div>
    </div>

    <div class="container py-5">
        <livewire:shop.product-catalog />
    </div>

</x-layouts.app>
