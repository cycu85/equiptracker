<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeightEquipmentSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'status',
        'location',
        'total_value',
        'notes'
    ];

    protected function casts(): array
    {
        return [
            'total_value' => 'decimal:2'
        ];
    }

    public function heightEquipment()
    {
        return $this->belongsToMany(HeightEquipment::class, 'height_equipment_set_items')
                    ->withPivot(['quantity', 'is_required', 'notes'])
                    ->withTimestamps();
    }

    public function requiredEquipment()
    {
        return $this->heightEquipment()->wherePivot('is_required', true);
    }

    public function optionalEquipment()
    {
        return $this->heightEquipment()->wherePivot('is_required', false);
    }

    public function getTotalEquipmentCountAttribute()
    {
        return $this->heightEquipment()->sum('height_equipment_set_items.quantity');
    }

    public function getCalculatedTotalValueAttribute()
    {
        return $this->heightEquipment()
                    ->sum(\DB::raw('COALESCE(height_equipment.purchase_price, 0) * height_equipment_set_items.quantity'));
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => 'bg-success',
            'inactive' => 'bg-secondary',
            'maintenance' => 'bg-warning'
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => 'Aktywny',
            'inactive' => 'Nieaktywny', 
            'maintenance' => 'Konserwacja'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function isComplete()
    {
        $requiredEquipment = $this->requiredEquipment()->get();
        
        foreach ($requiredEquipment as $equipment) {
            if ($equipment->status !== 'available') {
                return false;
            }
        }
        
        return true;
    }

    public function getCompletionStatusAttribute()
    {
        return $this->isComplete() ? 'complete' : 'incomplete';
    }
}