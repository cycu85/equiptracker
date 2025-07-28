<?php

namespace App\Http\Controllers;

use App\Models\Toolset;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolsetController extends Controller
{
    public function index(Request $request)
    {
        $query = Toolset::query()->with(['tools']);

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

        $toolsets = $query->paginate(15)->appends($request->query());
        
        return view('toolsets.index', compact('toolsets'));
    }

    public function create()
    {
        $availableTools = Tool::orderBy('name')->get();
        return view('toolsets.create', compact('availableTools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:toolsets',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'tools' => 'array',
            'tools.*.tool_id' => 'required|exists:tools,id',
            'tools.*.quantity' => 'required|integer|min:1',
            'tools.*.is_required' => 'boolean',
            'tools.*.notes' => 'nullable|string',
        ]);

        $toolset = Toolset::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->status,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        // Attach tools to toolset
        if ($request->has('tools')) {
            foreach ($request->tools as $toolData) {
                if (!empty($toolData['tool_id'])) {
                    $toolset->tools()->attach($toolData['tool_id'], [
                        'quantity' => $toolData['quantity'] ?? 1,
                        'is_required' => isset($toolData['is_required']) ? (bool)$toolData['is_required'] : true,
                        'notes' => $toolData['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('toolsets.show', $toolset)
                         ->with('success', 'Zestaw narzędzi został utworzony pomyślnie.');
    }

    public function show(Toolset $toolset)
    {
        $toolset->load(['tools']);
        return view('toolsets.show', compact('toolset'));
    }

    public function edit(Toolset $toolset)
    {
        $toolset->load(['tools']);
        $availableTools = Tool::orderBy('name')->get();
        
        return view('toolsets.edit', compact('toolset', 'availableTools'));
    }

    public function update(Request $request, Toolset $toolset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:toolsets,code,' . $toolset->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'tools' => 'array',
            'tools.*.tool_id' => 'required|exists:tools,id',
            'tools.*.quantity' => 'required|integer|min:1',
            'tools.*.is_required' => 'boolean',
            'tools.*.notes' => 'nullable|string',
        ]);

        $toolset->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->status,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        // Sync tools
        $toolsData = [];
        if ($request->has('tools')) {
            foreach ($request->tools as $toolData) {
                if (!empty($toolData['tool_id'])) {
                    $toolsData[$toolData['tool_id']] = [
                        'quantity' => $toolData['quantity'] ?? 1,
                        'is_required' => isset($toolData['is_required']) ? (bool)$toolData['is_required'] : true,
                        'notes' => $toolData['notes'] ?? null,
                    ];
                }
            }
        }
        
        $toolset->tools()->sync($toolsData);

        return redirect()->route('toolsets.show', $toolset)
                         ->with('success', 'Zestaw narzędzi został zaktualizowany pomyślnie.');
    }

    public function destroy(Toolset $toolset)
    {
        $toolset->tools()->detach(); // Remove all tool relationships
        $toolset->delete();

        return redirect()->route('toolsets.index')
                         ->with('success', 'Zestaw narzędzi został usunięty pomyślnie.');
    }
}