<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $users = User::where('is_super', 0)->whereHas('roles', function ($query) {
            return $query->whereHas('role', function ($query) {
                return $query->where('key', '!=', 'student');
            });
        });

        if ($request->name) {
            $users = $users->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->role) {
            $users = $users->whereHas('roles', function ($query) use ($request) {
                return $query->whereHas('role', function ($query) use ($request) {
                    return $query->where('key', $request->role);
                });
            });
        }

        $totalRecords = $this->count($users);
        $users = $users->latest()->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'users' => $users,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($users)
    {
        return $users->count();
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function getByKey($key)
    {
        return User::where('key', $key)->firstOrFail();
    }

    public function getByIds($ids)
    {
        return User::findOrFail($ids);
    }

    public function create($request)
    {
        if ($request->hasFile('file')) {
            $filename = 'image_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/users', $filename);
        }

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make('123456789'),
            'dob' => $request->date_of_birth,
            'permanent_address' => $request->permanent_address,
            'temporary_address' => $request->temporary_address,
            'nationality' => $request->nationality,
            'image' => $filename ?? ''
        ]);
    }

    public function update($request, $key)
    {
        if ($request->hasFile('file')) {
            $filename = 'image_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->storeAs('public/users', $filename);
        }
        
        $user = $this->getByKey($key);

        $user->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'dob' => $request->date_of_birth,
            'permanent_address' => $request->permanent_address,
            'temporary_address' => $request->temporary_address,
            'nationality' => $request->nationality,
            'image' => $filename ?? ''
        ]);

        return $user;
    }

    public function model()
    {
        return new User();
    }
}
