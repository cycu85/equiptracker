<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_number',
        'category',
        'description',
        'status',
        'purchase_date',
        'purchase_price',
        'next_inspection_date',
        'inspection_interval_months',
        'location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'next_inspection_date' => 'date',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'item_id')->where('item_type', 'tool');
    }

    public function getCurrentTransferAttribute()
    {
        return $this->transfers()->where('status', 'active')->first();
    }
}
