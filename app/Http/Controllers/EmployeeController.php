<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        // Filtering
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('position')) {
            $query->where('position', 'like', "%{$request->position}%");
        }

        // Sorting
        $sortBy = $request->get('sort', 'last_name');
        $sortDirection = $request->get('direction', 'asc');
        
        // Validate sort column
        $allowedSorts = ['id', 'first_name', 'last_name', 'email', 'department', 'position', 'status', 'hire_date', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'last_name';
        }

        $query->orderBy($sortBy, $sortDirection);

        $employees = $query->paginate(15)->appends($request->query());
        
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        return redirect()->route('employees.show', $employee)->with('success', 'Pracownik został dodany.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());
        return redirect()->route('employees.show', $employee)->with('success', 'Pracownik został zaktualizowany.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Pracownik został usunięty.');
    }
}
