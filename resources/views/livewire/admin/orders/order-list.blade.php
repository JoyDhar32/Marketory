<div>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="font-poppins fw-bold mb-0">Orders</h4>
            <small class="text-muted">Manage customer orders</small>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-3 border p-3 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by order #, name, or email...">
            </div>
            <div class="col-md-3">
                <select wire:model.live="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\Order::STATUSES as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select wire:model.live="sort" class="form-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="total_desc">Highest Total</option>
                    <option value="total_asc">Lowest Total</option>
                </select>
            </div>
            <div class="col-md-2">
                <button wire:click="$set('search', ''); $set('status', '')" class="btn btn-outline-secondary w-100">Reset</button>
            </div>
        </div>
    </div>

    <div class="admin-table">
        <div class="table-responsive">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->orders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-primary">{{ $order->order_number }}</a></td>
                            <td>
                                <div class="fw-500 small">{{ $order->billing_name }}</div>
                                <div class="text-muted" style="font-size:0.75rem">{{ $order->billing_email }}</div>
                            </td>
                            <td class="small text-muted">{{ $order->items->count() }} items</td>
                            <td class="fw-bold">${{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_badge_class }}-subtle text-{{ $order->status_badge_class }} border border-{{ $order->status_badge_class }}-subtle px-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} border px-2" style="font-size:0.7rem">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">No orders found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $this->orders->links() }}
        </div>
    </div>
</div>
