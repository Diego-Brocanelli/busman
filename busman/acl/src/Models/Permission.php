<?php

namespace Busman\Acl\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'group'
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'permission_roles');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_permissions');
    }
}
