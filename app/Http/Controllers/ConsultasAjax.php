<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor; use App\Models\Producto;
use DB; use Carbon\Carbon;

class ConsultasAjax extends Controller
{   
    //*** CONSULTA PARA CARGAR LAS PROVINCIAS DE UN PAÍS *** //
    public function cargar_provincias($pais){
        $estados= DB::table('provincia_region')
                    ->orderBy('provincia', 'ASC')
                    ->select('id', 'provincia')
                    ->where('pais_id', '=', $pais)
                    ->get();

        return response()->json(
            $estados->toArray()
        );
    }
    //*** FIN DE CONSULTA PARA CARGAR LAS PROVINCIAS DE UN PAÍS *** //

    // *** CONSULTAS PARA MARCAS  ***//
    //Verificar el nombre de una marca para que no se repita (Editar y Crear Marca)
    public function verificar_nombre_marca($nombre, $id_marca){
        $existe = DB::table('marca')
            ->select(DB::raw('count(*) as cant'))
            ->where('id', '<>', $id_marca)
            ->where('nombre', 'ILIKE', $nombre)
            ->first();

        return response()->json(
            $existe
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
    // *** FIN DE CONSULTAS PARA MARCAS  ***//

    // *** CONSULTAS PARA IMPORTADORES  ***//
    //Cargar los datos de un importador (Pestaña Productor / Confirmaciones / Importadores)
    public function datos_importador($id){
        $importador = DB::table('importador')
                        ->select('nombre', 'nombre_seo', 'descripcion', 'direccion', 'persona_contacto')
                        ->where('id', '=', $id)
                        ->first();

        return response()->json(
            $importador
        );
    }
    // *** FIN DE CONSULTAS PARA IMPORTADORES  ***//
    
     // *** CONSULTAS PARA DISTRIBUIDORES  ***//
    //Cargar los datos de un distribuidor (Pestaña Productor / Confirmaciones / Distribuidores)
    public function datos_distribuidor($id){
        $distribuidor = DB::table('distribuidor')
                        ->select('nombre', 'nombre_seo', 'descripcion', 'direccion', 'persona_contacto')
                        ->where('id', '=', $id)
                        ->first();

        return response()->json(
            $distribuidor
        );
    }
    // *** FIN DE CONSULTAS PARA IMPORTADORES  ***//
    
    // *** CONSULTAS PARA PRODUCTOS ***//
    //Verificar el nombre de una marca para que no se repita (Editar y Crear Marca)
    public function verificar_nombre_producto($nombre, $id_producto){
        $existe = DB::table('producto')
            ->select(DB::raw('count(*) as cant'))
            ->where('id', '<>', $id_producto)
            ->where('nombre', 'ILIKE', $nombre)
            ->first();

        return response()->json(
            $existe
        );
    }

    //Cargar productos de una marca específica (Pestaña Crear Oferta)
    public function cargar_productos($marca){
        if (session('perfilTipo') == 'P'){
            $productos = DB::table('producto')
                    ->select('id', 'nombre')
                    ->orderBy('nombre')
                    ->where('marca_id', '=', $marca)
                    ->get();
        }elseif (session('perfilTipo') == 'I'){
            $productos = DB::table('marca')
                    ->select('producto.id', 'producto.nombre')
                    ->join('producto', 'marca.id', '=', 'producto.marca_id')
                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                    ->where('importador_producto.importador_id', '=', session('perfilId'))
                    ->where('marca.id', '=', $marca)
                    ->orderBy('nombre')
                    ->get();   
        }elseif (session('perfilTipo') == 'D'){
            $productos = DB::table('marca')
                    ->select('producto.id', 'producto.nombre')
                    ->join('producto', 'marca.id', '=', 'producto.marca_id')
                    ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                    ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                    ->where('marca.id', '=', $marca)
                    ->orderBy('nombre')
                    ->get();   
        }
       
        return response()->json(
            $productos->toArray()
        );
    }

    //Cargar categorías de una bebida específica 
    //(Crear Productos, Editar Producto)
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
    // *** FIN DE CONSULTAS PARA PRODUCTOS  ***//

    // *** CONSULTAS PARA PUBLICIDADES  ***//
    // Consultar fechas disponibles para la publicación de un banner
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
    // *** FIN DE CONSULTAS PARA PUBLICIDADES  ***//

    // *** CONSULTAS PARA CRÉDITOS¨*** //
    public function refrescar_creditos(){
        if (session('perfilTipo') == 'P'){
            $creditos = DB::table('productor')
                    ->select('saldo')
                    ->where('id', '=', session('perfilId'))
                    ->first();
        }elseif (session('perfilTipo') == 'I'){
            $creditos = DB::table('importador')
                    ->select('saldo')
                    ->where('id', '=', session('perfilId'))
                    ->first();
        }elseif (session('perfilTipo') == 'D'){
            $creditos = DB::table('distribuidor')
                    ->select('saldo')
                    ->where('id', '=', session('perfilId'))
                    ->first();
        }

        session(['perfilSaldo' => $creditos->saldo]);
        
        return response()->json(
            $creditos
        );
    }
    // *** FIN DE CONSULTAS PARA CRÉDITOS
    
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
   
}