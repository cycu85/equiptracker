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
        Schema::create('height_equipment_set_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('height_equipment_set_id')->constrained()->onDelete('cascade');
            $table->foreignId('height_equipment_id')->constrained('height_equipment')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->boolean('is_required')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['height_equipment_set_id', 'height_equipment_id'], 'height_set_equipment_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('height_equipment_set_items');
    }
};