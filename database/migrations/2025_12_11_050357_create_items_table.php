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
        if (!Schema::hasTable('items')) {
            Schema::create('items', function (Blueprint $table) {
                $table->id();
                $table->string('sku')->unique();
                $table->string('name', 200);
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->foreignId('unit_id')->nullable()->constrained('unit')->onDelete('set null');
                $table->integer('stock')->default(0);
                $table->integer('stock_min')->default(0);
                $table->decimal('price', 15, 2)->default(0);
                $table->text('description')->nullable();
                $table->string('condition')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
