<?php

namespace App\Http\Controllers;

use App\Models\ITEquipment;
use Illuminate\Http\Request;

class ITEquipmentController extends Controller
{
    public function index()
    {
        $itEquipment = ITEquipment::paginate(15);
        return view('it-equipment.index', compact('itEquipment'));
    }

    public function create()
    {
        return view('it-equipment.create');
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
        return view('it-equipment.edit', compact('itEquipment'));
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
