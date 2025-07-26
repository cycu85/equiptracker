<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ITEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_number',
        'asset_tag',
        'type',
        'description',
        'status',
        'purchase_date',
        'purchase_price',
        'warranty_expiry',
        'operating_system',
        'specifications',
        'mac_address',
        'ip_address',
        'location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'item_id')->where('item_type', 'it_equipment');
    }

    public function getCurrentTransferAttribute()
    {
        return $this->transfers()->where('status', 'active')->first();
    }
}
