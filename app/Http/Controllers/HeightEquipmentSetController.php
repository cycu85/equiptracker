<?php

namespace App\Http\Controllers;

use App\Models\HeightEquipmentSet;
use App\Models\HeightEquipment;
use Illuminate\Http\Request;

class HeightEquipmentSetController extends Controller
{
    public function index(Request $request)
    {
        $query = HeightEquipmentSet::query()->with(['heightEquipment']);

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
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
        
        $allowedSorts = ['id', 'name', 'code', 'status', 'location', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        $query->orderBy($sortBy, $sortDirection);

        $heightEquipmentSets = $query->paginate(15)->appends($request->query());
        
        return view('height-equipment-sets.index', compact('heightEquipmentSets'));
    }

    public function create()
    {
        $availableEquipment = HeightEquipment::orderBy('name')->get();
        return view('height-equipment-sets.create', compact('availableEquipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:height_equipment_sets',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'equipment' => 'array',
            'equipment.*.height_equipment_id' => 'required|exists:height_equipment,id',
            'equipment.*.quantity' => 'required|integer|min:1',
            'equipment.*.is_required' => 'boolean',
            'equipment.*.notes' => 'nullable|string',
        ]);

        $heightEquipmentSet = HeightEquipmentSet::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->status,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        // Attach equipment to set
        if ($request->has('equipment')) {
            foreach ($request->equipment as $equipmentData) {
                if (!empty($equipmentData['height_equipment_id'])) {
                    $heightEquipmentSet->heightEquipment()->attach($equipmentData['height_equipment_id'], [
                        'quantity' => $equipmentData['quantity'] ?? 1,
                        'is_required' => isset($equipmentData['is_required']) ? (bool)$equipmentData['is_required'] : true,
                        'notes' => $equipmentData['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('height-equipment-sets.show', $heightEquipmentSet)
                         ->with('success', 'Zestaw sprzętu wysokościowego został utworzony pomyślnie.');
    }

    public function show(HeightEquipmentSet $heightEquipmentSet)
    {
        $heightEquipmentSet->load(['heightEquipment']);
        return view('height-equipment-sets.show', compact('heightEquipmentSet'));
    }

    public function edit(HeightEquipmentSet $heightEquipmentSet)
    {
        $heightEquipmentSet->load(['heightEquipment']);
        $availableEquipment = HeightEquipment::orderBy('name')->get();
        
        return view('height-equipment-sets.edit', compact('heightEquipmentSet', 'availableEquipment'));
    }

    public function update(Request $request, HeightEquipmentSet $heightEquipmentSet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:height_equipment_sets,code,' . $heightEquipmentSet->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'equipment' => 'array',
            'equipment.*.height_equipment_id' => 'required|exists:height_equipment,id',
            'equipment.*.quantity' => 'required|integer|min:1',
            'equipment.*.is_required' => 'boolean',
            'equipment.*.notes' => 'nullable|string',
        ]);

        $heightEquipmentSet->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->status,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        // Sync equipment
        $equipmentData = [];
        if ($request->has('equipment')) {
            foreach ($request->equipment as $equipmentItem) {
                if (!empty($equipmentItem['height_equipment_id'])) {
                    $equipmentData[$equipmentItem['height_equipment_id']] = [
                        'quantity' => $equipmentItem['quantity'] ?? 1,
                        'is_required' => isset($equipmentItem['is_required']) ? (bool)$equipmentItem['is_required'] : true,
                        'notes' => $equipmentItem['notes'] ?? null,
                    ];
                }
            }
        }
        
        $heightEquipmentSet->heightEquipment()->sync($equipmentData);

        return redirect()->route('height-equipment-sets.show', $heightEquipmentSet)
                         ->with('success', 'Zestaw sprzętu wysokościowego został zaktualizowany pomyślnie.');
    }

    public function destroy(HeightEquipmentSet $heightEquipmentSet)
    {
        $heightEquipmentSet->heightEquipment()->detach(); // Remove all equipment relationships
        $heightEquipmentSet->delete();

        return redirect()->route('height-equipment-sets.index')
                         ->with('success', 'Zestaw sprzętu wysokościowego został usunięty pomyślnie.');
    }
}