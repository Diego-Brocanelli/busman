<?php

namespace Busman\Acl\Http\Controllers;

use Busman\Acl\Models\Permission;
use Busman\Acl\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $roles = $roles->map(function($role){
            $role->users = $role->users()->get()->toArray();
            $role->permissions = $role->permissions()->get()->toArray();

            return $role;
        });

        return response()->json($roles->toArray(), 200);
    }
    public function permissionGroups()
    {
        $groups = Permission::all()->groupBy('group');

        $newPermissions = [];

        foreach ($groups as $groupKey => $group) {
            foreach ($group as $permission) {
                $permission->roles = $permission->roles()->get()->toArray();
                $newPermissions[$groupKey][] = $permission;
            }
        }

        return response()->json($newPermissions, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => ['required','max:255', 'not_in:admin', Rule::unique('roles', 'slug')->where(function($query) {
                $query->where('team_id', auth()->user()->current_team_id);
            })],
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'team_id' => auth()->user()->current_team_id
        ]);

        $role->assignPermissions($request->permissions);

        return response()->json($role->toArray(), 200);
    }

    public function show(Role $role)
    {
        $role->permissions = $role->permissions()->get()->toArray();

        return response()->json($role->toArray(), 200);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => ['required','max:255', 'not_in:admin', Rule::unique('roles', 'slug')->ignore($role->id)->where(function($query) {
                $query->where('company_id', auth()->user()->company_id);
            })],
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        $permissions = Permission::whereIn('name', $request->permissions)->get()->pluck('id')->toArray();

        $role->permissions()->sync($permissions);

        return response()->json('success', 200);
    }

    public function destroy(Request $request, Role $role)
    {
        $request->validate([
            'slug' => 'required|in:'.$role->slug
        ]);

        if($role->slug == 'admin'){
            return response()->json([
                'errors' => ['general_error' => ['The Admin role cannot be updated or deleted']]
            ], 403);
        }

        $role->permissions()->detach();
        $role->delete();

        return response()->json('deleted', 200);
    }
}
