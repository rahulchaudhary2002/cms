<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['key', 'name', 'type', 'primary', 'url_id'];

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'permission_id', 'id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class, 'permission_id', 'id');
    }

    public function url()
    {
        return $this->belongsTo(URL::class);
    }

    public function syncRoles($roles) {
        foreach($roles as $role) {
            RolePermission::create([
                'permission_id' => $this->id,
                'role_id' => $role->id
            ]);
        }
        
        return true;
    }

    public function detach($roles) {
        foreach ($roles as $role) {
            $role->delete();
        }
        
        return true;
    }
}
