<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use App\Models\Employee;
use App\Models\Tool;
use App\Models\HeightEquipment;
use App\Models\ITEquipment;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'employees' => Employee::count(),
            'tools' => Tool::count(),
            'height_equipment' => HeightEquipment::count(),
            'it_equipment' => ITEquipment::count(),
            'transfers' => Transfer::count(),
            'active_transfers' => Transfer::where('status', 'active')->count(),
        ];

        $modules = Module::orderBy('sort_order')->get();
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'modules', 'recentUsers'));
    }

    public function modules()
    {
        $modules = Module::orderBy('sort_order')->get();
        return view('admin.modules', compact('modules'));
    }

    public function updateModule(Request $request, Module $module)
    {
        $request->validate([
            'is_enabled' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $module->update([
            'is_enabled' => $request->boolean('is_enabled'),
            'sort_order' => $request->sort_order ?? $module->sort_order,
        ]);

        return response()->json(['success' => true, 'message' => 'Moduł został zaktualizowany']);
    }

    public function dataManagement()
    {
        $stats = [
            'users' => User::count(),
            'employees' => Employee::count(),
            'tools' => Tool::count(),
            'height_equipment' => HeightEquipment::count(),
            'it_equipment' => ITEquipment::count(),
            'transfers' => Transfer::count(),
        ];

        return view('admin.data-management', compact('stats'));
    }

    public function clearData(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'clear_type' => 'required|in:all,tools,height_equipment,it_equipment,employees,transfers',
        ]);

        if (!auth()->attempt(['email' => auth()->user()->email, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'Nieprawidłowe hasło']);
        }

        try {
            DB::beginTransaction();

            switch ($request->clear_type) {
                case 'all':
                    Transfer::truncate();
                    Tool::truncate();
                    HeightEquipment::truncate();
                    ITEquipment::truncate();
                    Employee::truncate();
                    User::where('role', '!=', 'admin')->delete();
                    break;
                case 'tools':
                    Transfer::where('item_type', 'tool')->delete();
                    Tool::truncate();
                    break;
                case 'height_equipment':
                    Transfer::where('item_type', 'height_equipment')->delete();
                    HeightEquipment::truncate();
                    break;
                case 'it_equipment':
                    Transfer::where('item_type', 'it_equipment')->delete();
                    ITEquipment::truncate();
                    break;
                case 'employees':
                    Transfer::truncate(); // Employees are referenced in transfers
                    Employee::truncate();
                    break;
                case 'transfers':
                    Transfer::truncate();
                    // Reset all equipment status to available
                    Tool::update(['status' => 'available']);
                    HeightEquipment::update(['status' => 'available']);
                    ITEquipment::update(['status' => 'available']);
                    break;
            }

            DB::commit();

            $message = match($request->clear_type) {
                'all' => 'Wszystkie dane zostały wyczyszczone',
                'tools' => 'Dane narzędzi zostały wyczyszczone',
                'height_equipment' => 'Dane sprzętu wysokościowego zostały wyczyszczone',
                'it_equipment' => 'Dane sprzętu IT zostały wyczyszczone',
                'employees' => 'Dane pracowników zostały wyczyszczone',
                'transfers' => 'Dane transferów zostały wyczyszczone',
            };

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Wystąpił błąd podczas czyszczenia danych: ' . $e->getMessage());
        }
    }

    public function systemInfo()
    {
        $info = [
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'database' => config('database.default'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ];

        return view('admin.system-info', compact('info'));
    }
}
