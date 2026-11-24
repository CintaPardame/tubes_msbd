<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('total_amount', 14, 2);
            $table->string('status')->default('menunggu_pembayaran'); // menunggu_pembayaran, diproses_kasir, dikirim, selesai, dibatalkan
            $table->string('recipient_name');
            $table->string('shipping_phone');
            $table->text('shipping_address');
            $table->text('customer_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity_package')->default(1); // Jumlah paket (1 paket = 1 kg)
            $table->decimal('weight_per_package_kg', 4, 2)->default(1.00); // 1 kg
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 14, 2);
            $table->string('grind_size')->default('Biji Utuh'); // Biji Utuh, Giling Kasar, Giling Sedang, Giling Halus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
