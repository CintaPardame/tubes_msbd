<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah field untuk Fitur 1 (bukti bayar, verifikasi) & Fitur 2 (resi ekspedisi) di tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('customer_notes'); // Path bukti bayar / transfer
            $table->timestamp('paid_at')->nullable()->after('payment_proof');
            $table->foreignId('verified_by')->nullable()->after('paid_at')->constrained('users')->nullOnDelete();
            
            $table->string('courier_name')->nullable()->after('verified_by'); // JNE, J&T, Kurir Roastery, dll
            $table->string('tracking_number')->nullable()->after('courier_name'); // Nomor Resi
            $table->timestamp('shipped_at')->nullable()->after('tracking_number');
        });

        // 2. Buat tabel untuk Fitur 3: Rekap Tutup Buku Kasir Harian
        Schema::create('daily_cashier_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained('users')->cascadeOnDelete();
            $table->date('closing_date');
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_revenue', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('status')->default('closed'); // closed, submitted_to_admin, verified_by_admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_cashier_summaries');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'payment_proof',
                'paid_at',
                'verified_by',
                'courier_name',
                'tracking_number',
                'shipped_at',
            ]);
        });
    }
};
