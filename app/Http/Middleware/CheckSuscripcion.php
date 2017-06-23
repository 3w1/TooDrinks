<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuscripcion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $suscripcion)
    {
        if ( session('perfilSuscripcion') == $suscripcion){
            return redirect('productor/listado-importadores-lock');
        }
        return $next($request);
    }
}
