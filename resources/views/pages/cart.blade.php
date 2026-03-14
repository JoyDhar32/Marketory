<x-layouts.app title="Cart">

    <div class="py-3" style="background:#fff;border-bottom:1px solid #E5E7EB">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <livewire:cart.cart-page />
    </div>

</x-layouts.app>
