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
        // Create stock table after items exist so FK can be added
        if (!Schema::hasTable('stock')) {
            Schema::create('stock', function (Blueprint $table) {
                $table->id();
                $table->foreignId('item_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                $table->enum('type', ['in', 'out']);
                $table->integer('quantity');
                $table->string('reference')->nullable();
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
