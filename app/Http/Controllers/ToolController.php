<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::paginate(15);
        return view('modules.tools.index', compact('tools'));
    }

    public function show(Tool $tool)
    {
        return view('modules.tools.show', compact('tool'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function edit(Tool $tool)
    {
        return view('modules.tools.edit', compact('tool'));
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
