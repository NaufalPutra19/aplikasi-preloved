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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // pcs, kg, liter, box, dll
            $table->string('symbol', 10)->nullable(); // kg, L, pcs
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Note: unit_id column sudah ada di create_items_table migration
        // Tidak perlu menambahkan di sini karena items table belum ada saat ini
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        // Note: unit_id column akan di-drop bersama items table
        Schema::dropIfExists('units');
    }
};
