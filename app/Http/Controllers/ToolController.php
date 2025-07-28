<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $query = Tool::query()->with(['toolsets']);

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

        if ($request->filled('category')) {
            $query->where('category', $request->category);
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
        $allowedSorts = ['id', 'name', 'brand', 'model', 'category', 'status', 'location', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        $query->orderBy($sortBy, $sortDirection);

        $tools = $query->paginate(15)->appends($request->query());
        
        // Get dictionary options for filters
        $categories = Dictionary::getOptions('tool_categories');
        $statuses = Dictionary::getOptions('tool_statuses');
        
        return view('modules.tools.index', compact('tools', 'categories', 'statuses'));
    }

    public function show(Tool $tool)
    {
        $tool->load(['toolsets']);
        return view('modules.tools.show', compact('tool'));
    }

    public function create()
    {
        $categories = Dictionary::getOptions('tool_categories');
        $statuses = Dictionary::getOptions('tool_statuses');
        
        return view('modules.tools.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $tool = Tool::create($request->all());
        return redirect()->route('tools.show', $tool)->with('success', 'Narzędzie zostało dodane.');
    }


    public function edit(Tool $tool)
    {
        $categories = Dictionary::getOptions('tool_categories');
        $statuses = Dictionary::getOptions('tool_statuses');
        
        return view('modules.tools.edit', compact('tool', 'categories', 'statuses'));
    }

    public function update(Request $request, Tool $tool)
    {
        $tool->update($request->all());
        return redirect()->route('tools.show', $tool)->with('success', 'Narzędzie zostało zaktualizowane.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('tools.index')->with('success', 'Narzędzie zostało usunięte.');
    }
}
