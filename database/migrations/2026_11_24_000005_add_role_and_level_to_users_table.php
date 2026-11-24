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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password'); // admin, kasir, petani, user
            $table->integer('level')->default(3)->after('role'); // Level 1: Admin, Level 2: Kasir & Petani, Level 3: User/Konsumen
            $table->string('phone')->nullable()->after('level');
            $table->text('address')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'level', 'phone', 'address']);
        });
    }
};
