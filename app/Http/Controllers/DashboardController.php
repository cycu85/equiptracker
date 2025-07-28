<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\HeightEquipment;
use App\Models\ITEquipment;
use App\Models\Employee;
use App\Models\Transfer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $stats = [
            'tools' => Tool::count(),
            'height_equipment' => HeightEquipment::count(),
            'it_equipment' => ITEquipment::count(),
            'employees' => Employee::count(),
            'active_transfers' => Transfer::where('status', 'active')->count(),
        ];

        $recentTransfers = Transfer::with(['toEmployee', 'fromEmployee'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $upcomingInspections = collect();
        
        try {
            $upcomingInspections = Tool::whereNotNull('next_inspection_date')
                ->where('next_inspection_date', '<=', now()->addDays(30))
                ->orderBy('next_inspection_date')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Tabele mogą nie istnieć jeszcze
        }

        return view('dashboard', compact('stats', 'recentTransfers', 'upcomingInspections'));
    }
}
