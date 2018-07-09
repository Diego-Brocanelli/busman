<?php

namespace Busman\Acl\Traits;

use Busman\Acl\Models\Permission;
use Busman\Acl\Models\Role;

trait HasPermissions
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function getAllPermissions()
    {
        $permissions = $this->permissions()->get();

        foreach ($this->roles()->get() as $role) {
            $permissions = $permissions->merge($role->permissions()->get());
        }

        return $permissions;
    }

    public function hasPermission(String $permission)
    {
        return in_array($permission, $this->getAllPermissions()->pluck('name')->toArray());
    }

    public function hasAnyPermission(Array $permissions)
    {
        foreach ($permissions as $permission) {
            if(in_array($permission, $this->getAllPermissions()->pluck('name')->toArray())){
                return true;
            }
        }

        return false;
    }

    public function hasAllPermissions(Array $permissions)
    {
        $userPermissions = $this->getAllPermissions()->pluck('name')->toArray();

        foreach ($permissions as $permission) {
            if (!in_array($permission, $userPermissions)) {
                return false;
            }
        }
        return true;
    }

    public function hasRole(String $role)
    {
        return $this->roles()->where('slug', $role)->get()->first() ? true : false;
    }

    public function hasAnyRole(Array $roles)
    {
        $userRoles = $this->roles()->get()->pluck('slug')->toArray();

        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return true;
            }
        }
        return false;
    }

    public function hasAllRoles(Array $roles)
    {
        $userRoles = $this->roles()->get()->pluck('slug')->toArray();

        foreach ($roles as $role) {
            if (!in_array($role, $userRoles)) {
                return false;
            }
        }
        return true;
    }

    public function assignRoles(Array $roles)
    {
        foreach ($roles as $role) {
            $role = Role::where('slug', $role)->get()->first();

            if ($role) {
                $this->roles()->attach($role->id);
            }
        }
    }

    public function assignRole(String $role)
    {
        $role = Role::where('slug', $role)->get()->first();

        if ($role) {
            $this->roles()->attach($role->id);
        }
    }

    public function assignPermissions(Array $permissions)
    {
        foreach ($permissions as $permission) {
            $permission = Permission::where('name', $permission)->get()->first();

            if ($permission) {
                $this->permissions()->attach($permission->id);
            }
        }
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
