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
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif (session('perfilTipo') == 'I'){
            $notificaciones = DB::table('notificacion_i')
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif ( session('perfilTipo') == 'D'){
            $notificaciones = DB::table('notificacion_d')
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);
        }elseif (session('perfilTipo') == 'H'){
            $notificaciones = DB::table('notificacion_h')
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

        if (session('perfilTipo') == 'US'){
            $notificacion = DB::table('notificacion_u')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

            $act = DB::table('notificacion_u')
                    ->where('id', '=', $id)
                    ->update(['leida' => '1']);

            return redirect($notificacion->url);
        }

        if (session('perfilTipo') == 'AD'){
            $notificacion = DB::table('notificacion_admin')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

            $act = DB::table('notificacion_admin')
                    ->where('id', '=', $id)
                    ->update(['leida' => '1']);

            return redirect($notificacion->url);
        }
    }

    public function notificar_p($tipo, $descripcion, $productor_id){
        $fecha = new \DateTime();

    	$notificaciones_productor = new Notificacion_P();
        $notificaciones_productor->creador_id = session('perfilId');
        $notificaciones_productor->tipo_creador = session('perfilTipo');

        if ($tipo == 'AI'){
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que importa tu marca '. $descripcion;
            $notificaciones_productor->url='productor/confirmar-importadores';
            $notificaciones_productor->descripcion = 'Nuevo Importador';
            $notificaciones_productor->color = 'bg-blue';
            $notificaciones_productor->icono = 'fa fa-hand-pointer-o';
            $notificaciones_productor->tipo ='AI';
        }elseif($tipo =='AD'){
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que distribuye tu marca '. $descripcion;
            $notificaciones_productor->url='productor/confirmar-distribuidores';
            $notificaciones_productor->descripcion = 'Nuevo Distribuidor';
            $notificaciones_productor->color = 'bg-red';
            $notificaciones_productor->icono = 'fa fa-hand-pointer-o';
            $notificaciones_productor->tipo ='AD';
        }
        
        $notificaciones_productor->productor_id = $productor_id;
        $notificaciones_productor->fecha = $fecha;
        $notificaciones_productor->leida = '0';
        $notificaciones_productor->save();

        if ($tipo == 'DP'){
        	return redirect('demanda-producto')->with('msj', 'Su demanda de producto ha sido creada exitosamente');
        }elseif ($tipo == 'AI'){
            return redirect('marca')->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');
        }elseif($tipo == 'AD'){
            return redirect('marca')->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');
        }elseif($tipo == 'SI'){
            return redirect('solicitar-importacion')->with('msj', 'Su solicitud ha sido creada exitosamente. Debe esperar que lo contacte el productor.');
        }elseif ($tipo == 'SD'){
            return redirect('solicitar-distribucion')->with('msj', 'Su solicitud ha sido creada exitosamente. Debe esperar que lo contacte el Productor / Importador');
        }
    }
}
