<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('vendor_id')->constrained('users');
            $table->foreignId('delivery_type_id')->constrained('delivery_types');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->enum('currency', ['USD','BDT'])->default('BDT');
            $table->decimal('exchange_rate_used', 18, 6)->default(1);
            $table->string('payment_status')->default('pending'); // unpaid|pending|paid|failed
            $table->string('order_status')->default('created'); // created|processing|delivered|canceled
            $table->string('coupon_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_discount_amount', 12, 2)->nullable();
            $table->string('coupon_discount_type')->nullable();
            $table->string('payment_method')->nullable(); // uddoktapay|cod
            $table->string('payment_invoice_id')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->string('product_name');
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('line_total', 12, 2);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('order_required_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('field_title');
            $table->string('field_name');
            $table->string('field_type');
            $table->text('value')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_delivery_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_delivery_id')->constrained('order_deliveries')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_delivery_files');
        Schema::dropIfExists('order_deliveries');
        Schema::dropIfExists('order_required_data');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
