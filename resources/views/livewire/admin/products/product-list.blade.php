<div>
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="font-poppins fw-bold mb-0">Products</h4>
            <small class="text-muted">Manage your product catalog</small>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-3 border p-3 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by name or SKU...">
            </div>
            <div class="col-md-3">
                <select wire:model.live="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($this->categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select wire:model.live="stock" class="form-select">
                    <option value="">All Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                </select>
            </div>
            <div class="col-md-2">
                <select wire:model.live="sort" class="form-select">
                    <option value="newest">Newest</option>
                    <option value="name">Name</option>
                    <option value="price_asc">Price ↑</option>
                    <option value="price_desc">Price ↓</option>
                    <option value="stock_asc">Stock ↑</option>
                </select>
            </div>
            <div class="col-md-1">
                <button wire:click="$set('search', ''); $set('category', ''); $set('stock', '')" class="btn btn-outline-secondary w-100" title="Reset">↺</button>
            </div>
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    @if($deleteId)
        <div class="modal show d-block" style="background:rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-4">
                        <div class="mb-3 text-danger" style="font-size:2.5rem">🗑️</div>
                        <h5 class="fw-bold">Delete Product?</h5>
                        <p class="text-muted small mb-4">This action cannot be undone.</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <button wire:click="$set('deleteId', null)" class="btn btn-outline-secondary">Cancel</button>
                            <button wire:click="deleteProduct" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Table --}}
    <div class="admin-table">
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $product->primary_image_url }}" style="width:48px;height:48px;object-fit:cover;border-radius:0.5rem">
                                    <div>
                                        <div class="fw-600 small">{{ $product->name }}</div>
                                        @if($product->sku)
                                            <div class="text-muted" style="font-size:0.75rem">{{ $product->sku }}</div>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size:0.65rem">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="small">{{ $product->category->name }}</td>
                            <td>
                                <div class="fw-600">${{ number_format($product->effective_price, 2) }}</div>
                                @if($product->is_on_sale)
                                    <div class="text-muted text-decoration-line-through small">${{ number_format($product->base_price, 2) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="stock-badge {{ $product->stock_status === 'in_stock' ? 'in-stock' : ($product->stock_status === 'low_stock' ? 'low-stock' : 'out-stock') }}">
                                    {{ $product->stock_quantity }} units
                                </span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $product->id }})" {{ $product->is_active ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="{{ route('admin.products.inventory', $product->id) }}" class="btn btn-sm btn-outline-secondary" title="Inventory">📦</a>
                                    <button wire:click="confirmDelete({{ $product->id }})" class="btn btn-sm btn-outline-danger">Del</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $this->products->links() }}
        </div>
    </div>
</div>
