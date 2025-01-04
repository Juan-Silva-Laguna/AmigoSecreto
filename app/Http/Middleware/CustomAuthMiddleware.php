<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CustomAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Session::has('usuario')) {
            return $next($request);
        }

        // Si no hay sesión de usuario, redirige a la página de inicio de sesión
        return redirect('/ingreso');
    }
}
