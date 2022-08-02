<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasActiveSetores
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $count_setores = auth()->user()->setores()->where('status', 1)->count();

        if (!auth()->user()->hasRole('admin') && $count_setores === 0) return redirect('/');

        return $next($request);
    }
}
