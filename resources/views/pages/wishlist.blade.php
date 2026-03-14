<x-layouts.app title="My Wishlist">

    <div class="py-4" style="background:#fff;border-bottom:1px solid #E5E7EB">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Wishlist</li>
                </ol>
            </nav>
            <h1 class="font-poppins fw-bold mb-0" style="font-size:1.75rem">My Wishlist</h1>
        </div>
    </div>

    <div class="container py-5">
        @auth
            <livewire:wishlist.wishlist-page />
        @else
            <div class="text-center py-5">
                <h4 class="font-poppins fw-bold mb-3">Please log in to view your wishlist</h4>
                <a href="{{ route('login') }}" class="btn btn-primary px-5">Log In</a>
            </div>
        @endauth
    </div>

</x-layouts.app>
