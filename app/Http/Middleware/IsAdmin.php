<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->global_role === 'admin') {
            return $next($request);
        }

        abort(403, 'Acceso solo para administradores.');
    }
}