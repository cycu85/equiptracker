<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('module');
        $modules = Permission::getModules();
        $actions = Permission::getActions();
        
        return view('admin.roles.create', compact('permissions', 'modules', 'actions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'is_system' => false
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rola została utworzona pomyślnie.');
    }

    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        $modules = Permission::getModules();
        $actions = Permission::getActions();
        
        return view('admin.roles.show', compact('role', 'modules', 'actions'));
    }

    public function edit(Role $role)
    {
        if ($role->is_system) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Nie można edytować roli systemowej.');
        }

        $permissions = Permission::all()->groupBy('module');
        $modules = Permission::getModules();
        $actions = Permission::getActions();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'modules', 'actions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->is_system) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Nie można edytować roli systemowej.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.roles.show', $role)
            ->with('success', 'Rola została zaktualizowana pomyślnie.');
    }

    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Nie można usunąć roli systemowej.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Nie można usunąć roli przypisanej do użytkowników.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rola została usunięta pomyślnie.');
    }
}