<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor; use App\Models\Producto;
use DB;

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
}