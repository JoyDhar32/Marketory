<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private CartService $cart) {}

    public function createOrder(array $billing, array $shipping, string $paymentMethod = 'cod', ?string $notes = null, ?string $stripePaymentIntentId = null): Order
    {
        return DB::transaction(function () use ($billing, $shipping, $paymentMethod, $notes, $stripePaymentIntentId) {
            $subtotal = $this->cart->getSubtotal();
            $discount = $this->cart->getDiscount();
            $shippingAmt = $this->cart->getShipping();
            $tax = $this->cart->getTax();
            $total = $this->cart->getTotal();
            $couponCode = $this->cart->getCouponCode();

            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'user_id'        => auth()->id(),
                'status'         => 'pending',
                'billing_name'   => $billing['name'],
                'billing_email'  => $billing['email'],
                'billing_phone'  => $billing['phone'] ?? null,
                'billing_address' => $billing['address'],
                'billing_city'   => $billing['city'],
                'billing_state'  => $billing['state'],
                'billing_zip'    => $billing['zip'],
                'billing_country' => $billing['country'] ?? 'US',
                'shipping_name'  => $shipping['name'],
                'shipping_address' => $shipping['address'],
                'shipping_city'  => $shipping['city'],
                'shipping_state' => $shipping['state'],
                'shipping_zip'   => $shipping['zip'],
                'shipping_country' => $shipping['country'] ?? 'US',
                'subtotal'       => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => $shippingAmt,
                'tax_amount'     => $tax,
                'total'          => $total,
                'coupon_code'    => $couponCode,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'stripe' ? 'paid' : 'pending',
                'stripe_payment_intent_id' => $stripePaymentIntentId,
                'customer_notes' => $notes,
            ]);

            foreach ($this->cart->getItems() as $item) {
                OrderItem::create([
                    'order_id'          => $order->id,
                    'product_id'        => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'product_name'      => $item['name'],
                    'variant_label'     => $item['variant_label'],
                    'sku'               => $item['sku'],
                    'unit_price'        => $item['price'],
                    'quantity'          => $item['quantity'],
                    'line_total'        => $item['price'] * $item['quantity'],
                ]);

                // Decrement stock
                if ($item['variant_id']) {
                    ProductVariant::where('id', $item['variant_id'])
                        ->decrement('stock_quantity', $item['quantity']);
                }

                \App\Models\Product::where('id', $item['product_id'])
                    ->decrement('stock_quantity', $item['quantity']);
            }

            // Increment coupon usage
            if ($couponCode) {
                Coupon::where('code', $couponCode)->increment('used_count');
            }

            $this->cart->clear();

            return $order;
        });
    }

    public function updateStatus(Order $order, string $status): void
    {
        $updates = ['status' => $status];

        if ($status === 'shipped') $updates['shipped_at'] = now();
        if ($status === 'delivered') $updates['delivered_at'] = now();

        $order->update($updates);
    }
}
