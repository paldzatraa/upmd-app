<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('loan_letter')->nullable()->after('purpose'); // File surat
            $table->string('pickup_status')->default('pending')->after('status'); // Status pengambilan
            // Hapus item_id karena sekarang pakai tabel detail (Opsional, hati-hati jika ada data lama)
            // $table->dropForeign(['item_id']);
            // $table->dropColumn('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            //
        });
    }
};
