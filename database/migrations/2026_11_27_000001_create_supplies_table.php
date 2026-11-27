<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('bean_type');
            $table->string('origin_name');
            $table->decimal('weight_kg', 10, 2);
            $table->decimal('purchase_cost_per_kg', 12, 2)->default(0);
            $table->decimal('total_purchase_cost', 14, 2)->default(0);
            $table->string('status')->default('menunggu'); // menunggu, disetujui, ditolak
            $table->text('admin_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
