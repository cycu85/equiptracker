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
        Schema::create('toolset_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toolset_id')->constrained()->onDelete('cascade');
            $table->foreignId('tool_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1); // Ilość danego narzędzia w zestawie
            $table->boolean('is_required')->default(true); // Czy narzędzie jest wymagane w zestawie
            $table->text('notes')->nullable(); // Notatki dotyczące narzędzia w zestawie
            $table->timestamps();
            
            $table->unique(['toolset_id', 'tool_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toolset_tools');
    }
};