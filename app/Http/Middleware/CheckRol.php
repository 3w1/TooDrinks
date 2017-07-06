<?php

namespace App\Http\Middleware;

use Closure;

class CheckRol
{
    public function handle($request, Closure $next)
    {
        if ( Auth::user()->rol == "MB"){
            return redirect('usuario');
        }
        return $next($request);
    }
}
