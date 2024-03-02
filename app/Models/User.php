<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'name',
        'email',
        'password',
        'mobile',
        'is_super',
        'dob',
        'permanent_address',
        'temporary_address',
        'nationality',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->whereHas('role', function ($query) use ($role) {
            return $query->where('key', $role);
        })->first() ? true : false;
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function assignRole($role)
    {
        $role = Role::where('key', $role)->first();

        return UserRole::create([
            'user_id' => $this->id,
            'role_id' => $role->id
        ]);
    }

    public function givePermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $permission = Permission::where('key', $permission)->first();

            UserPermission::create([
                'user_id' => $this->id,
                'permission_id' => $permission->id
            ]);
        }

        return true;
    }
    
    public function hasPermissionTo($permission)
    {
        return self::where('id', $this->id)->whereHas('permissions', function ($q) use ($permission) {
            $q->whereHas('permission', function ($q) use ($permission) {
                $q->where('key', $permission);
            });
        })->first() ? true : false;
    }

    public function detach($permissions, $roles)
    {
        foreach ($permissions as $permission) {
            UserPermission::where('id', $permission->id)->delete();
        }

        foreach ($roles as $role) {
            UserRole::where('id', $role->id)->delete();
        }

        return true;
    }

    public function givePermissionTo($permissions)
    {
        foreach ($permissions as $permission) {
            UserPermission::create([
                'user_id' => $this->id,
                'permission_id' => $permission->id
            ]);
        }

        return true;
    }

    public function getPermissionIdsByType($type) {
        return Permission::where('type', $type)->whereHas('userPermissions', function ($query) {
            return $query->where('user_id', $this->id);
        })->get()->pluck('id')->toArray();
    }

    public function hasProgram($id) {
        return self::whereHas('programs', function ($query) use ($id) {
            return $query->where('user_id', $this->id)->where('program_id', $id);
        })->first() ? true : false;
    }
}
