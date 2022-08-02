<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;


class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission = null, $guard = null)
    {
//        return $next($request);
        $authGuard = app('auth')->guard($guard);

        if ($authGuard->user()->hasRole('admin')) return $next($request);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (! is_null($permission)) {
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
        }

        if ( is_null($permission) ) {
            $permission = $request->route()->getName();

            $permissions = array($permission);
        }


        foreach ($permissions as $permission) {
            foreach ($authGuard->user()->setor_user as $setor_user) {
                if ($setor_user->hasPermissionTo($permission)) {
                    return $next($request);
                }
            }
//            if ($authGuard->user()->can($permission)) {
//                return $next($request);
//            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
