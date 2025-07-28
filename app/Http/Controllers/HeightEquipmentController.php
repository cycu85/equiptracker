<?php

namespace App\Http\Controllers;

use App\Models\HeightEquipment;
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
        
        return view('height-equipment.index', compact('heightEquipment'));
    }

    public function create()
    {
        return view('height-equipment.create');
    }

    public function store(Request $request)
    {
        $equipment = HeightEquipment::create($request->all());
        return redirect()->route('height-equipment.show', $equipment)->with('success', 'Sprzęt wysokościowy został dodany.');
    }

    public function show(HeightEquipment $heightEquipment)
    {
        $heightEquipment->load(['heightEquipmentSets']);
        return view('height-equipment.show', compact('heightEquipment'));
    }

    public function edit(HeightEquipment $heightEquipment)
    {
        return view('height-equipment.edit', compact('heightEquipment'));
    }

    public function update(Request $request, HeightEquipment $heightEquipment)
    {
        $heightEquipment->update($request->all());
        return redirect()->route('height-equipment.show', $heightEquipment)->with('success', 'Sprzęt wysokościowy został zaktualizowany.');
    }

    public function destroy(HeightEquipment $heightEquipment)
    {
        $heightEquipment->delete();
        return redirect()->route('height-equipment.index')->with('success', 'Sprzęt wysokościowy został usunięty.');
    }
}
