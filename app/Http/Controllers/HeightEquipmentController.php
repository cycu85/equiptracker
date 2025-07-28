<?php

namespace App\Http\Controllers;

use App\Models\HeightEquipment;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class HeightEquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = HeightEquipment::query()->with(['heightEquipmentSets']);

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
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
        $allowedSorts = ['id', 'name', 'brand', 'model', 'type', 'status', 'location', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        $query->orderBy($sortBy, $sortDirection);

        $heightEquipment = $query->paginate(15)->appends($request->query());
        
        // Get dictionary options for filters
        $types = Dictionary::getOptions('height_equipment_types');
        $statuses = Dictionary::getOptions('height_equipment_statuses');
        
        return view('height-equipment.index', compact('heightEquipment', 'types', 'statuses'));
    }

    public function create()
    {
        $types = Dictionary::getOptions('height_equipment_types');
        $statuses = Dictionary::getOptions('height_equipment_statuses');
        
        return view('height-equipment.create', compact('types', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:height_equipment,serial_number',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,in_use,maintenance,damaged,retired',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'last_inspection_date' => 'nullable|date',
            'next_inspection_date' => 'nullable|date|after:last_inspection_date',
            'inspection_interval_months' => 'nullable|integer|min:1|max:60',
            'certification_number' => 'nullable|string|max:255',
            'certification_expiry' => 'nullable|date',
            'max_load_kg' => 'nullable|numeric|min:0',
            'working_height_m' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $equipment = HeightEquipment::create($validatedData);
        return redirect()->route('height-equipment.show', $equipment)->with('success', 'Sprzęt wysokościowy został dodany.');
    }

    public function show(HeightEquipment $heightEquipment)
    {
        $heightEquipment->load(['heightEquipmentSets']);
        return view('height-equipment.show', compact('heightEquipment'));
    }

    public function edit(HeightEquipment $heightEquipment)
    {
        $types = Dictionary::getOptions('height_equipment_types');
        $statuses = Dictionary::getOptions('height_equipment_statuses');
        
        return view('height-equipment.edit', compact('heightEquipment', 'types', 'statuses'));
    }

    public function update(Request $request, HeightEquipment $heightEquipment)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:height_equipment,serial_number,' . $heightEquipment->id,
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,in_use,maintenance,damaged,retired',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'last_inspection_date' => 'nullable|date',
            'next_inspection_date' => 'nullable|date|after:last_inspection_date',
            'inspection_interval_months' => 'nullable|integer|min:1|max:60',
            'certification_number' => 'nullable|string|max:255',
            'certification_expiry' => 'nullable|date',
            'max_load_kg' => 'nullable|numeric|min:0',
            'working_height_m' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $heightEquipment->update($validatedData);
        return redirect()->route('height-equipment.show', $heightEquipment)->with('success', 'Sprzęt wysokościowy został zaktualizowany.');
    }

    public function destroy(HeightEquipment $heightEquipment)
    {
        $heightEquipment->delete();
        return redirect()->route('height-equipment.index')->with('success', 'Sprzęt wysokościowy został usunięty.');
    }

    public function inspections(Request $request)
    {
        $query = HeightEquipment::query();

        // Filter by inspection status
        if ($request->filled('filter')) {
            $filter = $request->filter;
            switch ($filter) {
                case 'overdue':
                    $query->where('next_inspection_date', '<', now());
                    break;
                case 'due_soon':
                    $query->whereBetween('next_inspection_date', [now(), now()->addDays(30)]);
                    break;
                case 'upcoming':
                    $query->whereBetween('next_inspection_date', [now()->addDays(30), now()->addDays(90)]);
                    break;
                case 'no_date':
                    $query->whereNull('next_inspection_date');
                    break;
            }
        }

        $heightEquipment = $query->orderBy('next_inspection_date', 'asc')->paginate(20);

        // Statistics
        $stats = [
            'overdue' => HeightEquipment::where('next_inspection_date', '<', now())->count(),
            'due_soon' => HeightEquipment::whereBetween('next_inspection_date', [now(), now()->addDays(30)])->count(),
            'upcoming' => HeightEquipment::whereBetween('next_inspection_date', [now()->addDays(30), now()->addDays(90)])->count(),
            'no_date' => HeightEquipment::whereNull('next_inspection_date')->count(),
        ];

        return view('height-equipment.inspections', compact('heightEquipment', 'stats'));
    }

    public function updateInspection(Request $request, HeightEquipment $heightEquipment)
    {
        $validatedData = $request->validate([
            'last_inspection_date' => 'required|date',
            'next_inspection_date' => 'required|date|after:last_inspection_date',
            'inspection_notes' => 'nullable|string',
        ]);

        $heightEquipment->update([
            'last_inspection_date' => $validatedData['last_inspection_date'],
            'next_inspection_date' => $validatedData['next_inspection_date'],
            'notes' => $heightEquipment->notes . "\n\n" . now()->format('Y-m-d') . " - Przegląd: " . ($validatedData['inspection_notes'] ?? 'Wykonano przegląd'),
        ]);

        return redirect()->back()->with('success', 'Przegląd został zarejestrowany.');
    }
}
