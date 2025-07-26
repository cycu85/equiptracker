<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'position',
        'hire_date',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    public function transfersFrom()
    {
        return $this->hasMany(Transfer::class, 'from_employee_id');
    }

    public function transfersTo()
    {
        return $this->hasMany(Transfer::class, 'to_employee_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
