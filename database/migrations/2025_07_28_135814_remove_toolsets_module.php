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
        // Remove the Toolsets module as it should be part of Tools module
        \DB::table('modules')->where('name', 'Toolsets')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add the Toolsets module if rollback is needed
        \DB::table('modules')->insert([
            'name' => 'Toolsets',
            'display_name' => 'Zestawy narzędzi',
            'description' => 'Zarządzanie zestawami narzędzi',
            'is_enabled' => true,
            'sort_order' => 5,
            'icon' => 'fa-toolbox',
            'route_prefix' => 'toolsets',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};