<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roasting_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_id')->nullable()->constrained('supplies')->nullOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('green_bean_weight_kg', 10, 2);
            $table->decimal('shrinkage_percentage', 5, 2);
            $table->decimal('roasted_weight_kg', 10, 2);
            $table->integer('packages_produced');
            $table->decimal('roasting_cost', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roasting_batches');
    }
};
