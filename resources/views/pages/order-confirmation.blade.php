<x-layouts.app title="Order Confirmed">

    <div class="container py-5">
        <div class="text-center py-5 my-3">
            <div style="width:80px;height:80px;border-radius:50%;background:#DCFCE7;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem" class="fs-1">
                ✓
            </div>
            <h1 class="font-poppins fw-bold text-success mb-2">Order Placed Successfully!</h1>
            <p class="text-muted fs-5 mb-4">Thank you for your purchase. Your order has been received and is being processed.</p>

            <div class="d-inline-block bg-white border rounded-3 px-5 py-3 mb-4">
                <div class="text-muted small">Order Number</div>
                <div class="font-poppins fw-bold fs-4 text-primary">{{ $order->order_number }}</div>
            </div>

            <div class="row g-3 justify-content-center mb-5">
                <div class="col-md-8">
                    <div class="bg-white border rounded-3 p-4">
                        <h5 class="font-poppins fw-bold mb-4">Order Summary</h5>
                        @foreach($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small">{{ $item->product_name }}
                                    @if($item->variant_label) <span class="text-muted">({{ $item->variant_label }})</span> @endif
                                    ×{{ $item->quantity }}
                                </span>
                                <span class="small fw-600">${{ number_format($item->line_total, 2) }}</span>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total Paid</span>
                            <span class="fw-bold text-primary fs-5">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">Continue Shopping</a>
                <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-lg px-4">Browse More</a>
            </div>

            <div class="mt-4 text-muted small">
                A confirmation will be sent to <strong>{{ $order->billing_email }}</strong>
            </div>
        </div>
    </div>

</x-layouts.app>
