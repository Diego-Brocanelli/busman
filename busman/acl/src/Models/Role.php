<?php

namespace Busman\Acl\Models;

use Busman\People\Models\User;
use Busman\Utils\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasScope;

    protected $fillable = ['name', 'slug', 'editable', 'team_id'];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function hasPermission($permission){
        return $this->permissions()->where('name', $permission)->get()->first() ? true : false;
    }

    public function hasAnyPermission(Array $permissions){
        foreach ($permissions as $permission) {
            if($this->permissions()->where('name', $permission)->get()->first()){
                return true;
            }
        }
        return false;
    }

    public function hasAllPermissions(Array $permissions){
        foreach ($permissions as $permission) {
            if($this->permissions()->where('name', $permission)->get()->first() == null){
                return false;
            }
        }
        return true;
    }

    public function assignPermissions(Array $permissions){
        foreach ($permissions as $permission) {
            $permission = Permission::where('name', $permission)->get()->first();

            if($permission){
                $this->permissions()->attach($permission->id);
            }
        }
    }
}
