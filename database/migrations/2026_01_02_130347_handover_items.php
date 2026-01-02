<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('handover_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handover_id')->constrained('handovers')->onDelete('cascade');
            $table->string('sku', 50);
            $table->string('item_name', 150);
            $table->integer('quantity')->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('handover_items');
    }
};
