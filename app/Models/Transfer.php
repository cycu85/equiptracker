<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_number',
        'item_type',
        'item_id',
        'from_employee_id',
        'to_employee_id',
        'created_by',
        'transfer_date',
        'return_date',
        'reason',
        'condition_notes',
        'status',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'transfer_date' => 'date',
            'return_date' => 'date',
        ];
    }

    public function fromEmployee()
    {
        return $this->belongsTo(Employee::class, 'from_employee_id');
    }

    public function toEmployee()
    {
        return $this->belongsTo(Employee::class, 'to_employee_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getItemAttribute()
    {
        switch ($this->item_type) {
            case 'tool':
                return Tool::find($this->item_id);
            case 'height_equipment':
                return HeightEquipment::find($this->item_id);
            case 'it_equipment':
                return ITEquipment::find($this->item_id);
            default:
                return null;
        }
    }
}
