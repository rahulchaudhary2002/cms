<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['key', 'name'];

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'role_id', 'id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function syncPermissions($permissions) {
        foreach($permissions as $permission) {
            RolePermission::create([
                'role_id' => $this->id,
                'permission_id' => $permission->id
            ]);
        }
        
        return true;
    }

    public function hasPermissionTo($permission) {
        return Role::where('id', $this->id)->whereHas('rolePermissions', function ($q) use ($permission) {
            $q->whereHas('permission', function ($q) use ($permission) {
                $q->where('key', $permission);
            });
        })->first() ? true : false;
    }

    public function detach($permissions) {
        foreach ($permissions as $permission) {
            $permission->delete();
        }
        
        return true;
    }

    public function getPermissionIdsByType($type) {
        return Permission::where('type', $type)->whereHas('rolePermissions', function ($query) {
            return $query->where('role_id', $this->id);
        })->get()->pluck('id')->toArray();
    }
}
