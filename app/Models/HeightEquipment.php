<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeightEquipment extends Model
{
    use HasFactory;

    protected $table = 'height_equipment';

    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_number',
        'type',
        'description',
        'status',
        'purchase_date',
        'purchase_price',
        'last_inspection_date',
        'next_inspection_date',
        'inspection_interval_months',
        'certification_number',
        'certification_expiry',
        'max_load_kg',
        'working_height_m',
        'location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'last_inspection_date' => 'date',
            'next_inspection_date' => 'date',
            'certification_expiry' => 'date',
            'purchase_price' => 'decimal:2',
            'max_load_kg' => 'decimal:2',
            'working_height_m' => 'decimal:2',
        ];
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'item_id')->where('item_type', 'height_equipment');
    }

    public function getCurrentTransferAttribute()
    {
        return $this->transfers()->where('status', 'active')->first();
    }

    public function heightEquipmentSets()
    {
        return $this->belongsToMany(HeightEquipmentSet::class, 'height_equipment_set_items')
                    ->withPivot(['quantity', 'is_required', 'notes'])
                    ->withTimestamps();
    }

    public function getIsInSetAttribute()
    {
        return $this->heightEquipmentSets()->count() > 0;
    }

    public function getSetsListAttribute()
    {
        return $this->heightEquipmentSets()->pluck('name')->join(', ');
    }
}
