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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->enum('item_type', ['tool', 'height_equipment', 'it_equipment']);
            $table->unsignedBigInteger('item_id');
            $table->foreignId('from_employee_id')->nullable()->constrained('employees');
            $table->foreignId('to_employee_id')->constrained('employees');
            $table->foreignId('created_by')->constrained('users');
            $table->date('transfer_date');
            $table->date('return_date')->nullable();
            $table->text('reason')->nullable();
            $table->text('condition_notes')->nullable();
            $table->enum('status', ['active', 'returned', 'permanent'])->default('active');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
            
            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
