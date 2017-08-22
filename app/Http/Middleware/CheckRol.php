<?php

namespace App\Http\Middleware;

use Closure;

class CheckRol
{
    public function handle($request, Closure $next)
    {
        if ( Auth::user()->activado == "0"){
            return redirect('usuario');
        }
        return $next($request);
    }
}
