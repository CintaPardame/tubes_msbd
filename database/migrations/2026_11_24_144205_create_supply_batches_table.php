<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_batches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('origin_id')
                ->constrained('origins')
                ->restrictOnDelete();

            $table->string('variety');
            $table->string('process_method');
            $table->date('harvest_date');
            $table->decimal('quantity_kg', 10, 2);
            $table->string('status')->default('tersedia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_batches');
    }
};