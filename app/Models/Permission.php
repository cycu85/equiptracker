<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'action'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public static function getModules()
    {
        return [
            'tools' => 'Narzędzia',
            'height-equipment' => 'Sprzęt wysokościowy',
            'it-equipment' => 'Sprzęt IT',
            'employees' => 'Pracownicy',
            'admin' => 'Panel administracyjny'
        ];
    }

    public static function getActions()
    {
        return [
            'view' => 'Przeglądanie',
            'create' => 'Tworzenie',
            'edit' => 'Edycja',
            'delete' => 'Usuwanie',
            'manage' => 'Zarządzanie'
        ];
    }
}