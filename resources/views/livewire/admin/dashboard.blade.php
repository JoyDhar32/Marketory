<div>
    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#EFF6FF">
                    <span style="color:#3B82F6;font-size:1.5rem">💰</span>
                </div>
                <div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">${{ number_format($this->totalRevenue, 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#FFF7ED">
                    <span style="color:#F97316;font-size:1.5rem">📦</span>
                </div>
                <div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value">{{ number_format($this->totalOrders) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#FEF3C7">
                    <span style="color:#D97706;font-size:1.5rem">⏳</span>
                </div>
                <div>
                    <div class="stat-label">Pending Orders</div>
                    <div class="stat-value">{{ $this->pendingOrders }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#F0FDF4">
                    <span style="color:#22C55E;font-size:1.5rem">🛍️</span>
                </div>
                <div>
                    <div class="stat-label">Total Products</div>
                    <div class="stat-value">{{ $this->totalProducts }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stock Alerts --}}
    @if($this->lowStockProducts > 0 || $this->outOfStockProducts > 0)
        <div class="row g-3 mb-4">
            @if($this->lowStockProducts > 0)
                <div class="col-md-6">
                    <div class="alert alert-warning d-flex align-items-center gap-2 mb-0" role="alert">
                        <span>⚠️</span>
                        <div>
                            <strong>{{ $this->lowStockProducts }} product(s)</strong> are running low on stock.
                            <a href="{{ route('admin.products.index') }}?stock=low" class="alert-link ms-1">View Products →</a>
                        </div>
                    </div>
                </div>
            @endif
            @if($this->outOfStockProducts > 0)
                <div class="col-md-6">
                    <div class="alert alert-danger d-flex align-items-center gap-2 mb-0" role="alert">
                        <span>🚫</span>
                        <div>
                            <strong>{{ $this->outOfStockProducts }} product(s)</strong> are out of stock.
                            <a href="{{ route('admin.products.index') }}?stock=out" class="alert-link ms-1">View Products →</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="row g-4">
        {{-- Recent Orders --}}
        <div class="col-xl-8">
            <div class="admin-table">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                    <h6 class="font-poppins fw-bold mb-0">Recent Orders</h6>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->recentOrders as $order)
                                <tr>
                                    <td><span class="fw-600 text-primary">{{ $order->order_number }}</span></td>
                                    <td>
                                        <div class="fw-500 small">{{ $order->billing_name }}</div>
                                        <div class="text-muted" style="font-size:0.75rem">{{ $order->billing_email }}</div>
                                    </td>
                                    <td class="fw-bold">${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge_class }}-subtle text-{{ $order->status_badge_class }} border border-{{ $order->status_badge_class }}-subtle px-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No orders yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="col-xl-4">
            <div class="admin-table">
                <div class="p-3 border-bottom">
                    <h6 class="font-poppins fw-bold mb-0">Top Products</h6>
                </div>
                <div class="p-3">
                    @forelse($this->topProducts as $product)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $product->primary_image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:0.5rem">
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="small fw-600 text-truncate">{{ $product->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $product->order_items_count }} sold</div>
                            </div>
                            <span class="fw-bold text-primary">${{ number_format($product->effective_price, 2) }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">No data yet</p>
                    @endforelse
                </div>
            </div>

            <div class="admin-table mt-3">
                <div class="p-3 border-bottom">
                    <h6 class="font-poppins fw-bold mb-0">Quick Actions</h6>
                </div>
                <div class="p-3 d-flex flex-column gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Add New Product</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">View All Orders</a>
                    <a href="{{ route('shop') }}" target="_blank" class="btn btn-outline-secondary btn-sm">View Store ↗</a>
                </div>
            </div>
        </div>
    </div>
</div>
