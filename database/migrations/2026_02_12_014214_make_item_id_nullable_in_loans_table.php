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
        Schema::table('loans', function ($table) {
            // Mengubah kolom item_id menjadi nullable (boleh kosong)
            $table->unsignedBigInteger('item_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('loans', function ($table) {
            $table->unsignedBigInteger('item_id')->nullable(false)->change();
        });
    }
};
