<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion_P; use App\Models\Notificacion_I; 
use App\Models\Notificacion_D; use App\Models\Notificacion_H;


class NotificacionController extends Controller
{
    public function notificar_p($tipo, $descripcion, $productor_id){
    	$notificaciones_productor = new Notificacion_P();
        $notificaciones_productor->creador_id = session('perfilId');
        $notificaciones_productor->tipo_creador = session('perfilTipo');

        if ($tipo == 'DP'){
        	$notificaciones_productor->titulo = 'Estan solicitando tu producto '. $descripcion;
        	$notificaciones_productor->url='demanda-producto/demandas-productos-productores';
        }elseif ($tipo == 'AIM'){
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que importa tu marca '. $descripcion;
            $notificaciones_productor->url='productor/confirmar-importadores';
        }elseif($tipo =='ADM'){
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que distribuye tu marca '. $descripcion;
            $notificaciones_productor->url='productor/confirmar-distribuidores';
        }
        
        $notificaciones_productor->productor_id = $productor_id;
        $notificaciones_productor->save();

        if ($tipo == 'DP'){
        	return redirect('demanda-producto')->with('msj', 'Su demanda de producto ha sido creada exitosamente');
        }elseif ($tipo == 'AIM'){
            return redirect('marca')->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');
        }elseif($tipo == 'ADM'){
            return redirect('marca')->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');
        }
    }
}
