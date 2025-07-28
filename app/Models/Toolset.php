<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toolset extends Model
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

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'toolset_tools')
                    ->withPivot(['quantity', 'is_required', 'notes'])
                    ->withTimestamps();
    }

    public function requiredTools()
    {
        return $this->tools()->wherePivot('is_required', true);
    }

    public function optionalTools()
    {
        return $this->tools()->wherePivot('is_required', false);
    }

    public function getTotalToolsCountAttribute()
    {
        return $this->tools()->sum('toolset_tools.quantity');
    }

    public function getCalculatedTotalValueAttribute()
    {
        return $this->tools()
                    ->sum(\DB::raw('COALESCE(tools.purchase_price, 0) * toolset_tools.quantity'));
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
        $requiredTools = $this->requiredTools()->get();
        
        foreach ($requiredTools as $tool) {
            if ($tool->status !== 'available') {
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