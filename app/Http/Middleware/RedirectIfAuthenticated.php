<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        $response = $next($request);
        
        if (Auth::check() == '1'){
            if (Auth::user()->rol == 'MB'){
                if (Auth::user()->entidad_predefinida == 'P'){
                    $entidad = DB::table('productor')
                                ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                                ->where('id', '=', Auth::user()->id_entidad_predefinida)
                                ->first();

                    session(['perfilTipo' => 'P']);
                }elseif (Auth::user()->entidad_predefinida == 'I'){
                    $entidad = DB::table('importador')
                                ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                                ->where('id', '=', Auth::user()->id_entidad_predefinida)
                                ->first();

                    session(['perfilTipo' => 'I']);
                }elseif (Auth::user()->entidad_predefinida == 'M'){
                    $entidad = DB::table('multinacional')
                                ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                                ->where('id', '=', Auth::user()->id_entidad_predefinida)
                                ->first();

                    session(['perfilTipo' => 'M']);
                }elseif (Auth::user()->entidad_predefinida == 'D'){
                    $entidad = DB::table('distribuidor')
                                ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                                ->where('id', '=', Auth::user()->id_entidad_predefinida)
                                ->first();

                    session(['perfilTipo' => 'D']);
                }elseif (Auth::user()->entidad_predefinida == 'H'){
                    $entidad = DB::table('horeca')
                                ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                                ->where('id', '=', Auth::user()->id_entidad_predefinida)
                                ->first();

                    session(['perfilTipo' => 'H']);
                }
                                            
                session(['perfilId' => $entidad->id]);
                session(['perfilNombre' => $entidad->nombre]);
                session(['perfilLogo' => $entidad->logo]);
                session(['perfilSaldo' => $entidad->saldo]);
                session(['perfilPais' => $entidad->pais_id]);
                session(['perfilProvincia' => $entidad->provincia_region_id]);
                session(['perfilSuscripcion' => $entidad->suscripcion_id]);
            }
        }else{
            return $response;
        }
        
        return $response; 
    }
}
