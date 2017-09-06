<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor; use App\Models\Producto;
use DB; use Carbon\Carbon;

class ConsultasAjax extends Controller
{   
    //Buscar un productor específico (Asociar Productor a Marca ADMIN)
	public function buscar_productor($nombre){
        $productor = DB::table('productor')
                    ->select('id', 'nombre')
                    ->orderBy('nombre')
                    ->where('nombre', 'ILIKE', '%'.$nombre.'%')
                    ->get();

        return response()->json(
            $productor->toArray()
        );
    }

    //Buscar una marca específica (Asociar Producto a Marca ADMIN)
    public function buscar_marca($nombre){
        $marca = DB::table('marca')
                    ->select('id', 'nombre')
                    ->orderBy('nombre')
                    ->where('nombre', 'ILIKE', '%'.$nombre.'%')
                    ->get();

        return response()->json(
            $marca->toArray()
        );
    }

    //Cargar categorías de una bebida específica (Crear Productos)
    public function cargar_clases_bebidas($bebida){
        $clases = DB::table('clase_bebida')
                    ->orderBy('clase', 'ASC')
                    ->select('id', 'clase')
                    ->where('bebida_id', '=', $bebida)
                    ->get();

        return response()->json(
            $clases->toArray()
        );
    }

    //Cargar la descripción de una marca específica (Confirmar Marcas ADMIN)
    public function cargar_descripcion_marca($id){
        $marca = DB::table('marca')
                    ->select('descripcion', 'website')
                    ->where('id', '=', $id)
                    ->first();

        return response()->json(
            $marca
        );
    }

    //Cargar los detalles de un producto específico (Confirmar Productos ADMIN)
    public function cargar_detalles_producto($id){
        $producto = Producto::where('id', '=', $id)->with('pais', 'marca', 'bebida', 'clase_bebida')
                        ->first();

        return response()->json(
            $producto->toArray()
        );
    }

    //Cargar los registros de un tipo de entidad (Crear Banner ADMIN)
    public function cargar_entidades($tipo){
        if ($tipo == 'P'){
            $entidades = DB::table('productor')
                        ->select('id', 'nombre')
                        ->where('id', '<>', '0')
                        ->orderBy('nombre', 'ASC')
                        ->get()->toArray();
        }elseif ($tipo == 'I'){
            $entidades = DB::table('importador')
                        ->select('id', 'nombre')
                        ->orderBy('nombre', 'ASC')
                        ->get()->toArray();
        }elseif ($tipo == 'D'){
            $entidades = DB::table('distribuidor')
                        ->select('id', 'nombre')
                        ->orderBy('nombre', 'ASC')
                        ->get()->toArray();
        }

        return response()->json(
            $entidades
        );
    }

    //Cargar los detalles de un banner específico (Editar Banners ADMIN)
    public function cargar_detalles_banner($id){
        $banner = DB::table('banner')
                    ->select('id', 'titulo', 'descripcion', 'url_banner', 'correcciones')
                    ->where('id', '=', $id)
                    ->first();

        return response()->json(
            $banner
        );
    }

    //Cargar los datos de un banner específico (Publicar Banners ADMIN)
    public function cargar_datos_banner($id){
        $banner = DB::table('banner')
                    ->select('id', 'titulo', 'tipo_creador', 'creador_id')
                    ->where('id', '=', $id)
                    ->first();

        return response()->json(
            $banner
        );
    }

    //Consultar las fechas disponibles para la publicación de un banner (Publicar Banner ADMIN)
    public function consultar_fechas_banner($pais, $semanas){
        $fecha_actual = Carbon::now();
        $fecha_actual = $fecha_actual->format('Y-m-d');

        $ultima_fecha = DB::table('banner_diario')
                        ->select('fecha')
                        ->where('pais_id', '=', $pais)
                        ->orderBy('fecha', 'DESC')
                        ->first();

        if ($ultima_fecha != null){
            if ( $ultima_fecha->fecha > $fecha_actual ) {
                $fa = Carbon::createFromFormat('Y-m-d', $ultima_fecha->fecha);
            }else{
                $fa = Carbon::createFromFormat('Y-m-d', $fecha_actual);
            }
        }else{
            $fa = Carbon::createFromFormat('Y-m-d', $fecha_actual);
        }

        $fecha1 = $fa->next(Carbon::MONDAY);
        $datos[0] = $fecha1->format('d-m-Y');
            
        $fecha2 = $fa->addWeek($semanas);
        $fecha2 = $fecha2->subDay(1);
        $datos[1] = $fecha2->format('d-m-Y');

        return response()->json(
            $datos
        );
    }

    //Cargar las marcas de un productor (Agregar Producto)
    public function cargar_marcas($productor){
        $marcas = DB::table('marca')
                    ->select('id', 'nombre')
                    ->where('productor_id', '=', $productor)
                    ->get();

        return response()->json(
            $marcas->toArray()
        );
    }
}