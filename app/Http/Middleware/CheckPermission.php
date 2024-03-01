<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\URL;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->hasRole('superadmin')) {
            return $next($request);
        }

        $urls = URL::get();

        foreach($urls as $url) {
            if(!$request->is($url->name)) {
                continue;
            }
            
            $permissions = Permission::where('url_id', $url->id)->get();
            $permissionKeys = $permissions->pluck('key')->toArray();

            if(count($permissionKeys) == 0 || $this->hasPermissions($permissionKeys)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }

    public function hasPermissions($permissionKeys)
    {
        $count = Permission::whereIn('key', $permissionKeys)->whereHas('userPermissions', function ($q) {
            return $q->where('user_id', auth()->user()->id);
        })->count();

        return $count >= count($permissionKeys) && $count > 0 ? true : false;
    }
}
