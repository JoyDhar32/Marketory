<div>
    <a href="#" class="position-relative text-white d-flex align-items-center gap-1" data-bs-toggle="offcanvas" data-bs-target="#cartSidebar">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        @if($count > 0)
            <span class="cart-badge">{{ $count }}</span>
        @endif
    </a>
</div>
