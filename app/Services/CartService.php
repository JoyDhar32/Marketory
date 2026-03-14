<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'marketory_cart';
    private const SHIPPING_THRESHOLD = 50.00;
    private const SHIPPING_COST = 5.99;
    private const TAX_RATE = 0.08;

    public function getCart(): array
    {
        return Session::get(self::SESSION_KEY, ['items' => [], 'coupon_code' => null, 'discount' => 0]);
    }

    private function saveCart(array $cart): void
    {
        Session::put(self::SESSION_KEY, $cart);
    }

    public function add(int $productId, ?int $variantId = null, int $qty = 1): void
    {
        $product = Product::with('images')->findOrFail($productId);
        $variant = $variantId ? ProductVariant::with('variantAttributes')->findOrFail($variantId) : null;

        $key = $productId . '-' . ($variantId ?? '0');
        $cart = $this->getCart();

        $price = $variant ? $variant->effective_price : $product->effective_price;
        $variantLabel = $variant ? $variant->label : null;

        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] += $qty;
        } else {
            $cart['items'][$key] = [
                'product_id'    => $productId,
                'variant_id'    => $variantId,
                'name'          => $product->name,
                'variant_label' => $variantLabel,
                'price'         => (float) $price,
                'quantity'      => $qty,
                'image_url'     => $product->primary_image_url,
                'sku'           => $variant?->sku ?? $product->sku,
                'slug'          => $product->slug,
            ];
        }

        $this->saveCart($cart);
    }

    public function remove(string $key): void
    {
        $cart = $this->getCart();
        unset($cart['items'][$key]);
        $this->saveCart($cart);
    }

    public function updateQuantity(string $key, int $qty): void
    {
        $cart = $this->getCart();
        if (isset($cart['items'][$key])) {
            if ($qty <= 0) {
                unset($cart['items'][$key]);
            } else {
                $cart['items'][$key]['quantity'] = $qty;
            }
        }
        $this->saveCart($cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function getItems(): array
    {
        return $this->getCart()['items'];
    }

    public function getSubtotal(): float
    {
        return array_reduce($this->getItems(), function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0.0);
    }

    public function getDiscount(): float
    {
        return (float) $this->getCart()['discount'];
    }

    public function getCouponCode(): ?string
    {
        return $this->getCart()['coupon_code'];
    }

    public function getShipping(): float
    {
        if (empty($this->getItems())) return 0;
        return $this->getSubtotal() >= self::SHIPPING_THRESHOLD ? 0 : self::SHIPPING_COST;
    }

    public function getTax(): float
    {
        return round(($this->getSubtotal() - $this->getDiscount()) * self::TAX_RATE, 2);
    }

    public function getTotal(): float
    {
        return max(0, $this->getSubtotal() - $this->getDiscount() + $this->getShipping() + $this->getTax());
    }

    public function getItemCount(): int
    {
        return array_sum(array_column($this->getItems(), 'quantity'));
    }

    public function applyCoupon(string $code): bool|string
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon) return 'Invalid coupon code.';
        if (!$coupon->is_valid) return 'This coupon is no longer valid.';
        if ($this->getSubtotal() < $coupon->minimum_order) {
            return "Minimum order of $" . number_format($coupon->minimum_order, 2) . " required.";
        }

        $cart = $this->getCart();
        $cart['coupon_code'] = strtoupper($code);
        $cart['discount'] = $coupon->calculateDiscount($this->getSubtotal());
        $this->saveCart($cart);

        return true;
    }

    public function removeCoupon(): void
    {
        $cart = $this->getCart();
        $cart['coupon_code'] = null;
        $cart['discount'] = 0;
        $this->saveCart($cart);
    }
}
