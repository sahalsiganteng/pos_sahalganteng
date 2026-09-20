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
        Schema::table('penjualan', function (Blueprint $table) {
            // Nominal uang tunai yang diberikan pelanggan (khusus metode CASH)
            $table->unsignedBigInteger('cash_given')->nullable()->after('metode_pembayaran');
            // Nominal kembalian yang diterima pelanggan (khusus metode CASH)
            $table->unsignedBigInteger('kembalian')->nullable()->after('cash_given');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['cash_given', 'kembalian']);
        });
    }
};
