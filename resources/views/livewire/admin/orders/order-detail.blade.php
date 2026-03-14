<div>
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
        <div>
            <h4 class="font-poppins fw-bold mb-0">{{ $order->order_number }}</h4>
            <small class="text-muted">Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}</small>
        </div>
        <span class="badge bg-{{ $order->status_badge_class }}-subtle text-{{ $order->status_badge_class }} border border-{{ $order->status_badge_class }}-subtle px-3 py-2">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Items --}}
            <div class="admin-table mb-4">
                <div class="p-3 border-bottom">
                    <h6 class="font-poppins fw-bold mb-0">Order Items</h6>
                </div>
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="fw-600 small">{{ $item->product_name }}</div>
                                    @if($item->sku) <div class="text-muted" style="font-size:0.75rem">{{ $item->sku }}</div> @endif
                                </td>
                                <td class="small text-muted">{{ $item->variant_label ?? '—' }}</td>
                                <td class="small">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="small">{{ $item->quantity }}</td>
                                <td class="fw-600">${{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-top">
                        <tr><td colspan="4" class="text-end fw-500">Subtotal</td><td>${{ number_format($order->subtotal, 2) }}</td></tr>
                        @if($order->discount_amount > 0)
                            <tr><td colspan="4" class="text-end text-success fw-500">Discount</td><td class="text-success">−${{ number_format($order->discount_amount, 2) }}</td></tr>
                        @endif
                        <tr><td colspan="4" class="text-end fw-500">Shipping</td><td>{{ $order->shipping_amount > 0 ? '$' . number_format($order->shipping_amount, 2) : 'Free' }}</td></tr>
                        <tr><td colspan="4" class="text-end fw-500">Tax</td><td>${{ number_format($order->tax_amount, 2) }}</td></tr>
                        <tr class="border-top"><td colspan="4" class="text-end fw-bold">Total</td><td class="fw-bold fs-5 text-primary">${{ number_format($order->total, 2) }}</td></tr>
                    </tfoot>
                </table>
            </div>

            {{-- Addresses --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="bg-white rounded-3 border p-3">
                        <h6 class="font-poppins fw-bold mb-2">Billing Address</h6>
                        <p class="small mb-0">
                            <strong>{{ $order->billing_name }}</strong><br>
                            {{ $order->billing_address }}<br>
                            {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}<br>
                            {{ $order->billing_country }}<br>
                            <a href="mailto:{{ $order->billing_email }}">{{ $order->billing_email }}</a><br>
                            @if($order->billing_phone) {{ $order->billing_phone }} @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white rounded-3 border p-3">
                        <h6 class="font-poppins fw-bold mb-2">Shipping Address</h6>
                        <p class="small mb-0">
                            <strong>{{ $order->shipping_name }}</strong><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                            {{ $order->shipping_country }}
                        </p>
                    </div>
                </div>
            </div>

            @if($order->customer_notes)
                <div class="bg-white rounded-3 border p-3">
                    <h6 class="font-poppins fw-bold mb-2">Customer Notes</h6>
                    <p class="small text-muted mb-0">{{ $order->customer_notes }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Update Status --}}
            <div class="bg-white rounded-3 border p-4 mb-3">
                <h6 class="font-poppins fw-bold mb-3">Update Order</h6>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select wire:model="newStatus" class="form-select">
                        @foreach(\App\Models\Order::STATUSES as $s)
                            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Admin Notes</label>
                    <textarea wire:model="adminNotes" class="form-control" rows="3" placeholder="Internal notes..."></textarea>
                </div>
                <button wire:click="updateStatus" class="btn btn-primary w-100">Save Changes</button>
            </div>

            {{-- Payment --}}
            <div class="bg-white rounded-3 border p-4 mb-3">
                <h6 class="font-poppins fw-bold mb-3">Payment Info</h6>
                <div class="small">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Method</span>
                        <span class="fw-500">{{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Status</span>
                        <span class="fw-600 {{ $order->payment_status === 'paid' ? 'text-success' : 'text-warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    @if($order->coupon_code)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Coupon</span>
                            <span class="badge bg-success-subtle text-success">{{ $order->coupon_code }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Timeline --}}
            <div class="bg-white rounded-3 border p-4">
                <h6 class="font-poppins fw-bold mb-3">Timeline</h6>
                <div class="small">
                    <div class="d-flex gap-2 mb-2">
                        <span class="text-muted">Created:</span>
                        <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    @if($order->shipped_at)
                        <div class="d-flex gap-2 mb-2">
                            <span class="text-muted">Shipped:</span>
                            <span>{{ $order->shipped_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                    @if($order->delivered_at)
                        <div class="d-flex gap-2">
                            <span class="text-muted">Delivered:</span>
                            <span>{{ $order->delivered_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
