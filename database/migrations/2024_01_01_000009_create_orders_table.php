<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 20)->default('pending');
            // Billing
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_phone', 50)->nullable();
            $table->string('billing_address', 500);
            $table->string('billing_city', 100);
            $table->string('billing_state', 100);
            $table->string('billing_zip', 20);
            $table->string('billing_country', 100)->default('US');
            // Shipping
            $table->string('shipping_name');
            $table->string('shipping_address', 500);
            $table->string('shipping_city', 100);
            $table->string('shipping_state', 100);
            $table->string('shipping_zip', 20);
            $table->string('shipping_country', 100)->default('US');
            // Financials
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('shipping_amount', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->string('coupon_code', 50)->nullable();
            // Payment
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_status', 20)->default('pending');
            $table->string('payment_reference')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            // Notes
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
