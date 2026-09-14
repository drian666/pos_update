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
            // Cek dulu apakah kolom 'status' belum ada
            if (!Schema::hasColumn('penjualan', 'status')) {
                $table->string('status')->default('completed')->after('total_pembayaran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
