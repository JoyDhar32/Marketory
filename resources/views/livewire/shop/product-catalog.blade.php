<div>
    <div class="row g-4">
        {{-- Filter Sidebar --}}
        <div class="col-lg-3">
            <div class="filter-sidebar">
                <h5 class="font-poppins fw-bold mb-3" style="font-size:1rem">Filters</h5>

                {{-- Search --}}
                <div class="mb-4">
                    <div class="filter-title">Search</div>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search products...">
                </div>

                {{-- Categories --}}
                <div class="mb-4">
                    <div class="filter-title">Category</div>
                    <div class="d-flex flex-column gap-1">
                        <button wire:click="$set('category', '')" class="btn btn-sm text-start {{ $category === '' ? 'btn-primary' : 'btn-light' }}">All Categories</button>
                        @foreach($this->categories as $cat)
                            <button wire:click="$set('category', '{{ $cat->slug }}')" class="btn btn-sm text-start {{ $category === $cat->slug ? 'btn-primary' : 'btn-light' }}">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range --}}
                <div class="mb-4">
                    <div class="filter-title">Price Range</div>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="number" wire:model.live="minPrice" class="form-control form-control-sm" min="0" placeholder="Min">
                        <span class="text-muted">–</span>
                        <input type="number" wire:model.live="maxPrice" class="form-control form-control-sm" min="0" placeholder="Max">
                    </div>
                </div>

                {{-- In Stock --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" wire:model.live="inStockOnly" class="form-check-input" id="inStockCheck">
                        <label class="form-check-label small fw-500" for="inStockCheck">In Stock Only</label>
                    </div>
                </div>

                {{-- Reset --}}
                <button wire:click="$set('search', ''); $set('category', ''); $set('sort', 'newest'); $set('inStockOnly', false); $set('minPrice', 0); $set('maxPrice', 2000)" class="btn btn-sm btn-outline-secondary w-100">Reset Filters</button>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="col-lg-9">
            {{-- Sort Bar --}}
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <span class="text-muted small">
                    Showing <strong>{{ $this->products->total() }}</strong> products
                    @if($search) for "<strong>{{ $search }}</strong>" @endif
                </span>
                <div class="d-flex align-items-center gap-2">
                    <label class="small text-muted mb-0 me-1">Sort:</label>
                    <select wire:model.live="sort" class="form-select form-select-sm" style="width:auto">
                        <option value="newest">Newest</option>
                        <option value="featured">Featured</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="name_asc">Name A–Z</option>
                    </select>
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width:auto">
                        <option value="12">12</option>
                        <option value="24">24</option>
                        <option value="48">48</option>
                    </select>
                </div>
            </div>

            @if($this->products->isEmpty())
                <div class="text-center py-5">
                    <svg width="72" height="72" fill="none" stroke="#D1D5DB" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <p class="text-muted">No products found. Try adjusting your filters.</p>
                    <button wire:click="$set('search', ''); $set('category', '')" class="btn btn-primary">Clear Filters</button>
                </div>
            @else
                <div class="row g-3">
                    @foreach($this->products as $product)
                        <div class="col-sm-6 col-xl-4">
                            <div class="product-card h-100">
                                <a href="{{ route('product.show', $product->slug) }}" class="product-img-wrap d-block">
                                    @if($product->is_on_sale)
                                        <span class="badge-sale">-{{ $product->discount_percent }}%</span>
                                    @endif
                                    @if($product->is_featured)
                                        <span class="badge-featured">Featured</span>
                                    @endif
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy"
                                         onerror="this.onerror=null;this.src='https://placehold.co/600x600/f1f5f9/94a3b8?text={{ rawurlencode($product->name) }}'">
                                </a>
                                <div class="product-body d-flex flex-column flex-grow-1">
                                    <div class="product-category">{{ $product->category->name }}</div>
                                    <a href="{{ route('product.show', $product->slug) }}" class="product-name text-decoration-none">{{ $product->name }}</a>

                                    {{-- Stars --}}
                                    @if($product->reviews->count() > 0)
                                        <div class="d-flex align-items-center gap-1 mb-2">
                                            <span class="star-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= round($product->average_rating) ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                            <span class="text-muted" style="font-size:0.75rem">({{ $product->reviews->count() }})</span>
                                        </div>
                                    @endif

                                    <div class="product-price mt-auto mb-2">
                                        @if($product->is_on_sale)
                                            <span class="sale-price">${{ number_format($product->sale_price, 2) }}</span>
                                            <span class="original-price">${{ number_format($product->base_price, 2) }}</span>
                                        @else
                                            ${{ number_format($product->base_price, 2) }}
                                        @endif
                                    </div>

                                    <div class="d-flex gap-2">
                                        @if($product->stock_quantity > 0 && !$product->is_variable)
                                            <button wire:click="addToCart({{ $product->id }})" class="btn-add-cart flex-grow-1">
                                                Add to Cart
                                            </button>
                                        @else
                                            <a href="{{ route('product.show', $product->slug) }}" class="btn-add-cart flex-grow-1 text-center">
                                                {{ $product->is_variable ? 'Select Options' : 'Out of Stock' }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $this->products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
