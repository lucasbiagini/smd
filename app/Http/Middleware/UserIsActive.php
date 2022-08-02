<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsActive
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!auth()->user()->hasRole('admin') && !auth()->user()->status) return redirect('/');
        return $next($request);
    }
}
