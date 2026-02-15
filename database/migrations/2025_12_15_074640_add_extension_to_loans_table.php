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
            $table->date('request_return_date')->nullable(); // Tanggal baru yang diminta
            $table->string('extension_reason')->nullable(); // Alasan
            $table->enum('extension_status', ['pending', 'approved', 'rejected'])->nullable(); // Status perpanjangan
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
