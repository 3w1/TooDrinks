<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion_P; use App\Models\Notificacion_I; 
use App\Models\Notificacion_D; use App\Models\Notificacion_H;
use DB;


class NotificacionController extends Controller
{

    public function index(){
        if (session('perfilTipo') == 'P'){
            $notificaciones = DB::table('notificacion_p')
                               ->where('productor_id', '=', session('perfilId'))
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif (session('perfilTipo') == 'I'){
            $notificaciones = DB::table('notificacion_i')
                               ->where('importador_id', '=', session('perfilId'))
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif (session('perfilTipo') == 'M'){
            $notificaciones = DB::table('notificacion_m')
                               ->where('multinacional_id', '=', session('perfilId'))
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif ( session('perfilTipo') == 'D'){
            $notificaciones = DB::table('notificacion_d')
                               ->where('distribuidor_id', '=', session('perfilId'))
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif (session('perfilTipo') == 'H'){
            $notificaciones = DB::table('notificacion_h')
                               ->where('horeca_id', '=', session('perfilId'))
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }

        return view('notificaciones.index')->with(compact('notificaciones'));
    }

    public function marcar_leida($id){
        if (session('perfilTipo') == 'P'){
            $notificacion = DB::table('notificacion_p')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

            $act = DB::table('notificacion_p')
                    ->where('id', '=', $id)
                    ->update(['leida' => '1']);

            return redirect($notificacion->url);
        }

        if (session('perfilTipo') == 'I'){
            $notificacion = DB::table('notificacion_i')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

            $act = DB::table('notificacion_i')
                    ->where('id', '=', $id)
                    ->update(['leida' => '1']);

            return redirect($notificacion->url);
        }

        if (session('perfilTipo') == 'D'){
            $notificacion = DB::table('notificacion_d')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

            $act = DB::table('notificacion_d')
                    ->where('id', '=', $id)
                    ->update(['leida' => '1']);

            return redirect($notificacion->url);
        }

        if (session('perfilTipo') == 'H'){
            $notificacion = DB::table('notificacion_h')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

            $act = DB::table('notificacion_h')
                    ->where('id', '=', $id)
                    ->update(['leida' => '1']);

            return redirect($notificacion->url);
        }
    }
}
