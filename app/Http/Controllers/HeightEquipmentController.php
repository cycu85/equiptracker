<?php

namespace App\Http\Controllers;

use App\Models\HeightEquipment;
use Illuminate\Http\Request;

class HeightEquipmentController extends Controller
{
    public function index()
    {
        $heightEquipment = HeightEquipment::paginate(15);
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
