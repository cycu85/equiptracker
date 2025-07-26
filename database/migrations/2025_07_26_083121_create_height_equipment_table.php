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
        Schema::create('height_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->string('type');
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'damaged', 'retired'])->default('available');
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('last_inspection_date')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->integer('inspection_interval_months')->default(12);
            $table->string('certification_number')->nullable();
            $table->date('certification_expiry')->nullable();
            $table->decimal('max_load_kg', 8, 2)->nullable();
            $table->decimal('working_height_m', 5, 2)->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('height_equipment');
    }
};
