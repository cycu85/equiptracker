<?php

namespace App\Modules\Tools\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::orderBy('name')->paginate(15);
        return view('modules.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        return view('modules.tools.show', compact('tool'));
    }

    public function create()
    {
        return view('modules.tools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:tools',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,in_use,maintenance,damaged,retired',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'next_inspection_date' => 'nullable|date',
            'inspection_interval_months' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Tool::create($validated);

        return redirect()->route('tools.index')->with('success', 'Tool created successfully.');
    }

    public function edit(Tool $tool)
    {
        return view('modules.tools.edit', compact('tool'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:tools,serial_number,' . $tool->id,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,in_use,maintenance,damaged,retired',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'next_inspection_date' => 'nullable|date',
            'inspection_interval_months' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $tool->update($validated);

        return redirect()->route('tools.show', $tool)->with('success', 'Tool updated successfully.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Tool deleted successfully.');
    }
}