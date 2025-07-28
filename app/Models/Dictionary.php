<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'key',
        'value',
        'description',
        'sort_order',
        'is_active',
        'is_system'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_system' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('value');
    }

    // Helper method to get dictionary options for a category
    public static function getOptions($category)
    {
        return static::byCategory($category)
                     ->active()
                     ->ordered()
                     ->pluck('value', 'key')
                     ->toArray();
    }

    // Helper method to get category display name
    public function getCategoryDisplayNameAttribute()
    {
        $categoryNames = [
            'tool_categories' => 'Kategorie narzędzi',
            'tool_statuses' => 'Statusy narzędzi',
            'height_equipment_types' => 'Typy sprzętu wysokościowego',
            'height_equipment_statuses' => 'Statusy sprzętu wysokościowego',
            'it_equipment_types' => 'Typy sprzętu IT',
            'it_equipment_statuses' => 'Statusy sprzętu IT',
            'toolset_statuses' => 'Statusy zestawów narzędzi',
            'height_equipment_set_statuses' => 'Statusy zestawów sprzętu wysokościowego',
        ];

        return $categoryNames[$this->category] ?? $this->category;
    }

    // Get all available categories
    public static function getCategories()
    {
        return [
            'tool_categories' => 'Kategorie narzędzi',
            'tool_statuses' => 'Statusy narzędzi',
            'height_equipment_types' => 'Typy sprzętu wysokościowego',
            'height_equipment_statuses' => 'Statusy sprzętu wysokościowego',
            'it_equipment_types' => 'Typy sprzętu IT',
            'it_equipment_statuses' => 'Statusy sprzętu IT',
            'toolset_statuses' => 'Statusy zestawów narzędzi',
            'height_equipment_set_statuses' => 'Statusy zestawów sprzętu wysokościowego',
        ];
    }
}