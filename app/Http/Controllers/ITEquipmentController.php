<?php

namespace App\Http\Controllers;

use App\Models\ITEquipment;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class ITEquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = ITEquipment::query();

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('asset_tag', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Sorting
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validate sort column
        $allowedSorts = ['id', 'name', 'brand', 'model', 'type', 'status', 'location', 'operating_system', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        $query->orderBy($sortBy, $sortDirection);

        $itEquipment = $query->paginate(15)->appends($request->query());
        
        // Get dictionary options for filters
        $types = Dictionary::getOptions('it_equipment_types');
        $statuses = Dictionary::getOptions('it_equipment_statuses');
        $operatingSystems = Dictionary::getOptions('it_operating_systems');
        
        return view('it-equipment.index', compact('itEquipment', 'types', 'statuses', 'operatingSystems'));
    }

    public function create()
    {
        $types = Dictionary::getOptions('it_equipment_types');
        $statuses = Dictionary::getOptions('it_equipment_statuses');
        $operatingSystems = Dictionary::getOptions('it_operating_systems');
        
        return view('it-equipment.create', compact('types', 'statuses', 'operatingSystems'));
    }

    public function store(Request $request)
    {
        $equipment = ITEquipment::create($request->all());
        return redirect()->route('it-equipment.show', $equipment)->with('success', 'Sprzęt IT został dodany.');
    }

    public function show(ITEquipment $itEquipment)
    {
        return view('it-equipment.show', compact('itEquipment'));
    }

    public function edit(ITEquipment $itEquipment)
    {
        $types = Dictionary::getOptions('it_equipment_types');
        $statuses = Dictionary::getOptions('it_equipment_statuses');
        $operatingSystems = Dictionary::getOptions('it_operating_systems');
        
        return view('it-equipment.edit', compact('itEquipment', 'types', 'statuses', 'operatingSystems'));
    }

    public function update(Request $request, ITEquipment $itEquipment)
    {
        $itEquipment->update($request->all());
        return redirect()->route('it-equipment.show', $itEquipment)->with('success', 'Sprzęt IT został zaktualizowany.');
    }

    public function destroy(ITEquipment $itEquipment)
    {
        $itEquipment->delete();
        return redirect()->route('it-equipment.index')->with('success', 'Sprzęt IT został usunięty.');
    }
}
