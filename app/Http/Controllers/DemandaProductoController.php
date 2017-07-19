<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Producto;
use App\Models\Producto; use App\Models\Productor;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Clase_Bedida; use App\Models\Bebida;
use App\Models\Notificacion_P; use App\Models\Notificacion_I; use App\Models\Notificacion_D;
use DB;

class DemandaProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cont = 0;

        $demandasProductos = Demanda_Producto::where([
                                        ['tipo_creador', '=', session('perfilTipo')], 
                                        ['creador_id', '=', session('perfilId')]
                                    ])->orderBy('created_at', 'ASC')
                                    ->paginate(10);

        return view('demandaProducto.index')->with(compact('demandasProductos', 'cont'));
    }

    public function demandas_productos_disponibles(){
        if (session('perfilTipo') == 'P'){
            $notificaciones_pendientes_DP = DB::table('notificacion_p')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DP')
                                        ->get();

            foreach ($notificaciones_pendientes_DP as $notificacion){
                $act = DB::table('notificacion_p')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }

            $demandasProductos = DB::table('demanda_producto')
                                    ->select('demanda_producto.*', 'producto.nombre', 'producto.marca_id', 'marca.productor_id')
                                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                    ->where('marca.productor_id', '=', session('perfilId'))
                                    ->where('demanda_producto.status', '=', '1')
                                    ->paginate(10);
        }elseif (session('perfilTipo') == 'I'){
            $notificaciones_pendientes_DP = DB::table('notificacion_i')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DP')
                                        ->get();

            foreach ($notificaciones_pendientes_DP as $notificacion){
                $act = DB::table('notificacion_i')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }
               
            $demandasProductos = DB::table('demanda_producto')
                                    ->select('demanda_producto.*', 'producto.nombre', 'producto.marca_id')
                                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                                    ->where('importador_producto.importador_id', '=', session('perfilId'))
                                    ->where('demanda_producto.status', '=', '1')
                                    ->where('demanda_producto.tipo_creador', '<>', 'I')
                                    ->paginate(10);
        }elseif (session('perfilTipo') == 'D'){
            $notificaciones_pendientes_DP = DB::table('notificacion_d')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DP')
                                        ->get();

            foreach ($notificaciones_pendientes_DP as $notificacion){
                $act = DB::table('notificacion_d')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }

            $demandasProductos = DB::table('demanda_producto')
                                    ->select('demanda_producto.*', 'producto.nombre', 'producto.marca_id')
                                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                                    ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                                    ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                                    ->where('demanda_producto.status', '=', '1')
                                    ->where('demanda_producto.tipo_creador', '=', 'H')
                                    ->paginate(10);
        }

        return view('demandaProducto.demandasProductos')->with(compact('demandasProductos'));
    }

    public function demandas_bebidas_disponibles(){
        if (session('perfilTipo') == 'P'){
             $notificaciones_pendientes_DB = DB::table('notificacion_p')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DB')
                                        ->get();

            foreach ($notificaciones_pendientes_DB as $notificacion){
                $act = DB::table('notificacion_p')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }

            $demandasBebidas = DB::table('demanda_producto')
                                    ->select('demanda_producto.*')
                                    ->join('producto', 'demanda_producto.bebida_id', '=', 'producto.bebida_id')
                                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                    ->where('marca.productor_id', '=', session('perfilId'))
                                    ->where('demanda_producto.producto_id', '=', '0')
                                    ->where('demanda_producto.status', '=', '1')
                                    ->groupBy('demanda_producto.id', 'producto.bebida_id')
                                    ->paginate(10);
        }elseif (session('perfilTipo') == 'I'){
            $notificaciones_pendientes_DB = DB::table('notificacion_i')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DB')
                                        ->get();

            foreach ($notificaciones_pendientes_DB as $notificacion){
                $act = DB::table('notificacion_i')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }

            $demandasBebidas = DB::table('demanda_producto')
                                    ->select('demanda_producto.*')
                                    ->join('producto', 'demanda_producto.bebida_id', '=', 'producto.bebida_id')
                                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                                    ->where('importador_producto.importador_id', '=', session('perfilId'))
                                    ->where('demanda_producto.producto_id', '=', '0')
                                    ->where('demanda_producto.status', '=', '1')
                                    ->where('demanda_producto.tipo_creador', '<>', 'I')
                                    ->groupBy('demanda_producto.id', 'producto.bebida_id')
                                    ->paginate(10);
        }elseif (session('perfilTipo') == 'D'){
            $notificaciones_pendientes_DB = DB::table('notificacion_d')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DP')
                                        ->get();

            foreach ($notificaciones_pendientes_DB as $notificacion){
                $act = DB::table('notificacion_d')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }

            $demandasBebidas = DB::table('demanda_producto')
                                    ->select('demanda_producto.*')
                                    ->join('producto', 'demanda_producto.bebida_id', '=', 'producto.bebida_id')
                                    ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                                    ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                                    ->where('demanda_producto.producto_id', '=', '0')
                                    ->where('demanda_producto.status', '=', '1')
                                    ->where('demanda_producto.tipo_creador', '=', 'H')
                                    ->groupBy('demanda_producto.id', 'producto.bebida_id')
                                    ->paginate(10);
        }
       
        return view('demandaProducto.demandasBebidas')->with(compact('demandasBebidas'));
    }

    public function create()
    {
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        $bebidas = DB::table('bebida')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('demandaProducto.create')->with(compact('productos', 'bebidas', 'paises'));
    }


    public function store(Request $request)
    {
        $fecha = new \DateTime();

        $demanda_producto  = new Demanda_Producto($request->all());

        if ($request->tipo_producto == 'P'){
            $producto = DB::table('producto')
                    ->select('id', 'pais_id', 'provincia_region_id', 'bebida_id', 'marca_id', 'nombre')
                    ->where('id', '=', $request->producto_id)
                    ->get()
                    ->first();

            $demanda_producto->pais_id = $producto->pais_id;
            $demanda_producto->provincia_region_id = $producto->provincia_region_id;
            $demanda_producto->bebida_id = $producto->bebida_id;
        }else{
            $demanda_producto->producto_id = '0';
        }
               
        $demanda_producto->status = '1';
        $demanda_producto->fecha_creacion = $fecha;
        $demanda_producto ->save();

        $ult_demanda = DB::table('demanda_producto')
                        ->select('id')
                        ->orderBy('created_at', 'DESC')
                        ->first();

        if ($request->tipo_producto == 'P'){
            $productor = DB::table('producto')
                        ->select('productor.id', 'productor.pais_id', 'productor.provincia_region_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('producto.id', '=', $request->producto_id )
                        ->first();

            $importadores = DB::table('importador_producto')
                                    ->select('importador_producto.importador_id')
                                    ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                                    ->where('importador_producto.producto_id', '=', $request->producto_id)
                                    ->where('importador.pais_id', '=', session('perfilPais'))
                                    ->get();

            $distribuidores = DB::table('distribuidor_producto')
                                    ->select('distribuidor_producto.distribuidor_id')
                                    ->join('distribuidor', 'distribuidor_producto.distribuidor_id', '=', 'distribuidor.id')
                                    ->where('distribuidor_producto.producto_id', '=', $request->producto_id)
                                    ->where('distribuidor.pais_id', '=', session('perfilPais'))
                                    ->get();

            if (session('perfilTipo') == 'I'){
                //NOTIFICAR AL PRODUCTOR
                    $notificaciones_productor = new Notificacion_P();
                    $notificaciones_productor->creador_id = session('perfilId');
                    $notificaciones_productor->tipo_creador = session('perfilTipo');
                    $notificaciones_productor->titulo = 'Estan demandando tu producto '. $producto->nombre;
                    $notificaciones_productor->url='demanda-producto/'.$ult_demanda->id;
                    $notificaciones_productor->descripcion = 'Demanda de Producto';
                    $notificaciones_productor->color = 'bg-aqua';
                    $notificaciones_productor->icono = 'fa fa-clipboard';
                    $notificaciones_productor->tipo ='DP';
                    $notificaciones_productor->productor_id = $productor->id;
                    $notificaciones_productor->fecha = $fecha;
                    $notificaciones_productor->leida = '0';
                    $notificaciones_productor->save();
                // *** //
            }elseif (session('perfilTipo') == 'D'){
                $cont = 0;
                foreach ($importadores as $importador){
                    $cont++;
                }

                if ($cont > 0){
                    //NOTIFICAR A LOS IMPORTADORES
                    foreach ($importadores as $importador){
                        $notificaciones_importador = new Notificacion_I();
                        $notificaciones_importador->creador_id = session('perfilId');
                        $notificaciones_importador->tipo_creador = session('perfilTipo');
                        $notificaciones_importador->titulo = 'Estan solicitando tu producto '. $producto->nombre;
                        $notificaciones_importador->url='demanda-producto/'.$ult_demanda->id;
                        $notificaciones_importador->importador_id = $importador->importador_id;
                        $notificaciones_importador->descripcion = 'Demanda de Producto';
                        $notificaciones_importador->color = 'bg-aqua';
                        $notificaciones_importador->icono = 'fa fa-clipboard';
                        $notificaciones_importador->tipo ='DP';
                        $notificaciones_importador->fecha = $fecha;
                        $notificaciones_importador->leida = '0';
                        $notificaciones_importador->save();
                    }
                    // *** //
                }else{
                    //NOTIFICAR AL PRODUCTOR
                        $notificaciones_productor = new Notificacion_P();
                        $notificaciones_productor->creador_id = session('perfilId');
                        $notificaciones_productor->tipo_creador = session('perfilTipo');
                        $notificaciones_productor->titulo = 'Estan demandando tu producto '. $producto->nombre;
                        $notificaciones_productor->url='demanda-producto/'.$ult_demanda->id;
                        $notificaciones_productor->descripcion = 'Demanda de Producto';
                        $notificaciones_productor->color = 'bg-aqua';
                        $notificaciones_productor->icono = 'fa fa-clipboard';
                        $notificaciones_productor->tipo ='DP';
                        $notificaciones_productor->productor_id = $productor->id;
                        $notificaciones_productor->fecha = $fecha;
                        $notificaciones_productor->leida = '0';
                        $notificaciones_productor->save();
                    // *** //
                }
            }else{
                $cont = 0;
                foreach ($distribuidores as $distribuidor){
                    $cont++;
                }

                if ($cont > 0 ){
                    // NOTIFICAR A LOS DISTRIBUIDORES
                    foreach ($distribuidores as $distribuidor){
                        $notificaciones_distribuidor = new Notificacion_D();
                        $notificaciones_distribuidor->creador_id = session('perfilId');
                        $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                        $notificaciones_distribuidor->titulo = 'Estan solicitando tu producto '. $producto->nombre;
                        $notificaciones_distribuidor->url='demanda-producto/'.$ult_demanda->id;
                        $notificaciones_distribuidor->distribuidor_id = $distribuidor->distribuidor_id;
                        $notificaciones_distribuidor->descripcion = 'Demanda de Producto';
                        $notificaciones_distribuidor->color = 'bg-aqua';
                        $notificaciones_distribuidor->icono = 'fa fa-clipboard';
                        $notificaciones_distribuidor->tipo ='DP';
                        $notificaciones_distribuidor->fecha = $fecha;
                        $notificaciones_distribuidor->leida = '0';
                        $notificaciones_distribuidor->save();
                    }
                    // *** //
                }else{
                    $cont2 = 0;
                    foreach ($importadores as $importador){
                        $cont2++;
                    }

                    if ($cont2 > 0 ){
                        //NOTIFICAR A LOS IMPORTADORES SI NO EXISTEN DISTRIBUIDORES
                        foreach ($importadores as $importador){
                            $notificaciones_importador = new Notificacion_I();
                            $notificaciones_importador->creador_id = session('perfilId');
                            $notificaciones_importador->tipo_creador = session('perfilTipo');
                            $notificaciones_importador->titulo = 'Estan solicitando tu producto '. $producto->nombre;
                            $notificaciones_importador->url='demanda-producto/'.$ult_demanda->id;
                            $notificaciones_importador->importador_id = $importador->importador_id;
                            $notificaciones_importador->descripcion = 'Demanda de Producto';
                            $notificaciones_importador->color = 'bg-aqua';
                            $notificaciones_importador->icono = 'fa fa-clipboard';
                            $notificaciones_importador->tipo ='DP';
                            $notificaciones_importador->fecha = $fecha;
                            $notificaciones_importador->leida = '0';
                            $notificaciones_importador->save();
                        }
                        // *** //
                    }else{
                        //NOTIFICAR AL PRODUCTOR COMO ÚLTIMO RECURSO
                            $notificaciones_productor = new Notificacion_P();
                            $notificaciones_productor->creador_id = session('perfilId');
                            $notificaciones_productor->tipo_creador = session('perfilTipo');
                            $notificaciones_productor->titulo = 'Estan demandando tu producto '. $producto->nombre;
                            $notificaciones_productor->url='demanda-producto/'.$ult_demanda->id;
                            $notificaciones_productor->descripcion = 'Demanda de Producto';
                            $notificaciones_productor->color = 'bg-aqua';
                            $notificaciones_productor->icono = 'fa fa-clipboard';
                            $notificaciones_productor->tipo ='DP';
                            $notificaciones_productor->productor_id = $productor->id;
                            $notificaciones_productor->fecha = $fecha;
                            $notificaciones_productor->leida = '0';
                            $notificaciones_productor->save();
                        // *** //
                    }
                }
            }
        }else{
            if (session('perfilTipo') == 'I'){
                //SELECCIONAR PRODUCTORES QUE TENGAN ESE TIPO DE BEBIDA
                $productores = DB::table('productor')
                                ->select('productor.id')
                                ->join('marca', 'productor.id', '=', 'marca.productor_id')
                                ->join('producto', 'marca.id', '=', 'producto.marca_id')
                                ->where('producto.bebida_id', '=', $request->bebida_id)
                                ->where('productor.pais_id', '=', session('perfilPais'))
                                ->groupBy('productor.id', 'producto.bebida_id')
                                ->get();

                $cont = 0;
                foreach ($productores as $productor){
                    $cont++;
                }

                if ($cont > 0 ){
                    //NOTIFICAR A LOS PRODUCTORES
                    foreach ($productores as $productor){
                        $notificaciones_productor = new Notificacion_P();
                        $notificaciones_productor->creador_id = session('perfilId');
                        $notificaciones_productor->tipo_creador = session('perfilTipo');
                        $notificaciones_productor->titulo = 'Estan solicitando un tipo bebida que tu posees.';
                        $notificaciones_productor->url='demanda-bebida/'.$ult_demanda->id;
                        $notificaciones_productor->productor_id = $productor->id;
                        $notificaciones_productor->descripcion = 'Demanda de Bebida';
                        $notificaciones_productor->color = 'bg-aqua';
                        $notificaciones_productor->icono = 'fa fa-clipboard';
                        $notificaciones_productor->tipo ='DB';
                        $notificaciones_productor->fecha = new \DateTime();
                        $notificaciones_productor->leida = '0';
                        $notificaciones_productor->save();
                    }
                    // *** //
                }
            }elseif ( session('perfilTipo') == 'D'){
                $importadores = DB::table('importador_producto')
                                ->select('importador_producto.importador_id')
                                ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                                ->join('producto', 'importador_producto.producto_id', '=', 'producto.id')
                                ->where('producto.bebida_id', '=', $request->bebida_id)
                                ->where('importador.pais_id', '=', session('perfilPais'))
                                ->groupBy('importador_producto.importador_id', 'producto.bebida_id')
                                ->get();

                $cont = 0;
                foreach ($importadores as $importador){
                    $cont++;
                }

                if ($cont > 0 ){
                    //NOTIFICAR A LOS IMPORTADORES QUE TENGAN ESE TIPO DE BEBIDA
                    foreach ($importadores as $importador){
                        $notificaciones_importador = new Notificacion_I();
                        $notificaciones_importador->creador_id = session('perfilId');
                        $notificaciones_importador->tipo_creador = session('perfilTipo');
                        $notificaciones_importador->titulo = 'Estan solicitando un tipo bebida que tu posees.';
                        $notificaciones_importador->url='demanda-bebida/'.$ult_demanda->id;
                        $notificaciones_importador->importador_id = $importador->importador_id;
                        $notificaciones_importador->descripcion = 'Demanda de Bebida';
                        $notificaciones_importador->color = 'bg-aqua';
                        $notificaciones_importador->icono = 'fa fa-clipboard';
                        $notificaciones_importador->tipo ='DB';
                        $notificaciones_importador->fecha = new \DateTime();
                        $notificaciones_importador->leida = '0';
                        $notificaciones_importador->save();
                    }
                    // *** //
                }else{
                    //SELECCIONAR PRODUCTORES QUE TENGAN ESE TIPO DE BEBIDA
                    $productores = DB::table('productor')
                                    ->select('productor.id')
                                    ->join('marca', 'productor.id', '=', 'marca.productor_id')
                                    ->join('producto', 'marca.id', '=', 'producto.marca_id')
                                    ->where('producto.bebida_id', '=', $request->bebida_id)
                                    ->where('productor.pais_id', '=', session('perfilPais'))
                                    ->groupBy('productor.id', 'producto.bebida_id')
                                    ->get();

                    $cont2 = 0;
                    foreach ($productores as $productor){
                        $cont2++;
                    }

                    if ($cont2 > 0 ){
                        //NOTIFICAR A LOS PRODUCTORES
                        foreach ($productores as $productor){
                            $notificaciones_productor = new Notificacion_P();
                            $notificaciones_productor->creador_id = session('perfilId');
                            $notificaciones_productor->tipo_creador = session('perfilTipo');
                            $notificaciones_productor->titulo = 'Estan solicitando un tipo bebida que tu posees.';
                            $notificaciones_productor->url='demanda-bebida/'.$ult_demanda->id;
                            $notificaciones_productor->productor_id = $productor->id;
                            $notificaciones_productor->descripcion = 'Demanda de Bebida';
                            $notificaciones_productor->color = 'bg-aqua';
                            $notificaciones_productor->icono = 'fa fa-clipboard';
                            $notificaciones_productor->tipo ='DB';
                            $notificaciones_productor->fecha = new \DateTime();
                            $notificaciones_productor->leida = '0';
                            $notificaciones_productor->save();
                        }
                        // *** //
                    }
                }
            }elseif (session('perfilTipo') == 'H'){
                $distribuidores = DB::table('distribuidor_producto')
                                ->select('distribuidor_producto.distribuidor_id')
                                ->join('distribuidor', 'distribuidor_producto.distribuidor_id', '=', 'distribuidor.id')
                                ->join('producto', 'distribuidor_producto.producto_id', '=', 'producto.id')
                                ->where('producto.bebida_id', '=', $request->bebida_id)
                                ->where('distribuidor.pais_id', '=', session('perfilPais'))
                                ->groupBy('distribuidor_producto.distribuidor_id', 'producto.bebida_id')
                                ->get(); 

                $cont = 0;
                foreach ($distribuidores as $distribuidor){
                    $cont++;
                }

                if ($cont > 0 ){
                    // NOTIFICAR A LOS DISTRIBUIDORES
                    foreach ($distribuidores as $distribuidor){
                        $notificaciones_distribuidor = new Notificacion_D();
                        $notificaciones_distribuidor->creador_id = session('perfilId');
                        $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                        $notificaciones_distribuidor->titulo = 'Estan solicitando un tipo de bebida que tu posees.';
                        $notificaciones_distribuidor->url='demanda-bebida/'.$ult_demanda->id;
                        $notificaciones_distribuidor->distribuidor_id = $distribuidor->distribuidor_id;
                        $notificaciones_distribuidor->descripcion = 'Demanda de Bebida';
                        $notificaciones_distribuidor->color = 'bg-aqua';
                        $notificaciones_distribuidor->icono = 'fa fa-clipboard';
                        $notificaciones_distribuidor->tipo ='DB';
                        $notificaciones_distribuidor->fecha = new \DateTime();
                        $notificaciones_distribuidor->leida = '0';
                        $notificaciones_distribuidor->save();
                    }
                    // *** //
                }else{
                    $importadores = DB::table('importador_producto')
                                ->select('importador_producto.importador_id')
                                ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                                ->join('producto', 'importador_producto.producto_id', '=', 'producto.id')
                                ->where('producto.bebida_id', '=', $request->bebida_id)
                                ->where('importador.pais_id', '=', session('perfilPais'))
                                ->groupBy('importador_producto.importador_id', 'producto.bebida_id')
                                ->get();

                    $cont2 = 0;
                    foreach ($importadores as $importador){
                        $cont2++;
                    }

                    if ($cont2 > 0 ){
                        // NOTIFICAR A LOS IMPORTADORES
                        foreach ($distribuidores as $distribuidor){
                            $notificaciones_importador = new Notificacion_I();
                            $notificaciones_importador->creador_id = session('perfilId');
                            $notificaciones_importador->tipo_creador = session('perfilTipo');
                            $notificaciones_importador->titulo = 'Estan solicitando un tipo bebida que tu posees.';
                            $notificaciones_importador->url='demanda-bebida/'.$ult_demanda->id;
                            $notificaciones_importador->importador_id = $importador->importador_id;
                            $notificaciones_importador->descripcion = 'Demanda de Bebida';
                            $notificaciones_importador->color = 'bg-aqua';
                            $notificaciones_importador->icono = 'fa fa-clipboard';
                            $notificaciones_importador->tipo ='DB';
                            $notificaciones_importador->fecha = new \DateTime();
                            $notificaciones_importador->leida = '0';
                            $notificaciones_importador->save();
                        }
                    }else{
                        //SELECCIONAR PRODUCTORES QUE TENGAN ESE TIPO DE BEBIDA
                        $productores = DB::table('productor')
                                        ->select('productor.id')
                                        ->join('marca', 'productor.id', '=', 'marca.productor_id')
                                        ->join('producto', 'marca.id', '=', 'producto.marca_id')
                                        ->where('producto.bebida_id', '=', $request->bebida_id)
                                        ->where('productor.pais_id', '=', session('perfilPais'))
                                        ->groupBy('productor.id', 'producto.bebida_id')
                                        ->get();

                        $cont3 = 0;
                        foreach ($productores as $productor){
                            $cont3++;
                        }

                        if ($cont3 > 0 ){
                            //NOTIFICAR A LOS PRODUCTORES
                            foreach ($productores as $productor){
                                $notificaciones_productor = new Notificacion_P();
                                $notificaciones_productor->creador_id = session('perfilId');
                                $notificaciones_productor->tipo_creador = session('perfilTipo');
                                $notificaciones_productor->titulo = 'Estan solicitando un tipo bebida que tu posees.';
                                $notificaciones_productor->url='demanda-bebida/'.$ult_demanda->id;
                                $notificaciones_productor->productor_id = $productor->id;
                                $notificaciones_productor->descripcion = 'Demanda de Bebida';
                                $notificaciones_productor->color = 'bg-aqua';
                                $notificaciones_productor->icono = 'fa fa-clipboard';
                                $notificaciones_productor->tipo ='DB';
                                $notificaciones_productor->fecha = new \DateTime();
                                $notificaciones_productor->leida = '0';
                                $notificaciones_productor->save();
                            }
                            // *** //
                        }
                    } 
                } 
            }
        }
        
        return redirect('demanda-producto')->with('msj', 'Se ha creado su solicitud exitosamente.');
    }

    public function show($id)
    {
        if (session('perfilSuscripcion') != 'Premium'){
            if (session('perfilTipo') == 'P'){
                $deduccion = DB::table('deduccion_credito_productor')
                            ->where('productor_id', '=', session('perfilId'))
                            ->where('tipo_deduccion', '=', 'DP')
                            ->orwhere('tipo_deduccion', '=', 'DB')
                            ->where('accion_id', '=', $id)
                            ->first();
            }elseif (session('perfilTipo') == 'I'){
                $deduccion = DB::table('deduccion_credito_importador')
                            ->where('importador_id', '=', session('perfilId'))
                            ->where('tipo_deduccion', '=', 'DP')
                            ->orwhere('tipo_deduccion', '=', 'DB')
                            ->where('accion_id', '=', $id)
                            ->first();
            }elseif (session('perfilTipo') == 'D'){
                $deduccion = DB::table('deduccion_credito_distribuidor')
                            ->where('distribuidor_id', '=', session('perfilId'))
                            ->where('tipo_deduccion', '=', 'DP')
                            ->orwhere('tipo_deduccion', '=', 'DB')
                            ->where('accion_id', '=', $id)
                            ->first();
            }

            if ($deduccion == null){
                $restringido = '1';
            }else{
                $restringido = '0';
            }
        }else{
           if (session('perfilTipo') == 'P'){
                $demandaMarcada = DB::table('productor_demanda_producto')
                                ->where('productor_id', '=', session('perfilId'))
                                ->where('demanda_producto_id', '=', $id)
                                ->first();
            }elseif (session('perfilTipo') == 'I'){
                $demandaMarcada = DB::table('importador_demanda_producto')
                                ->where('importador_id', '=', session('perfilId'))
                                ->where('demanda_producto_id', '=', $id)
                                ->first();
            }elseif (session('perfilTipo') == 'D'){
               $demandaMarcada = DB::table('distribuidor_demanda_producto')
                                ->where('distribuidor_id', '=', session('perfilId'))
                                ->where('demanda_producto_id', '=', $id)
                                ->first();
            }

            if ($demandaMarcada == null){
                $restringido = '1';
            }else{
                $restringido = '0';
            }
        }

        $demandaProducto = Demanda_Producto::find($id);

        $visitas = $demandaProducto->cantidad_visitas + 1;

        $act = DB::table('demanda_producto')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $demandaProducto->cantidad_visitas = $visitas;

        return view('demandaProducto.show')->with(compact('demandaProducto', 'restringido'));
    }

    //Marca una demanda de producto "de interes" para la entidad loggeada 
    public function marcar_demanda($id){
        $fecha = new \DateTime();

        $demanda = Demanda_Producto::find($id);

        $productor = Productor::find(session('perfilId'));

        //Asociar entidad a la demanda
        if (session('perfilTipo') == 'P'){
            DB::table('productor_demanda_producto')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha]);    
        }elseif (session('perfilTipo') == 'I'){
            DB::table('importador_demanda_producto')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha]);    
        }elseif (session('perfilTipo') == 'D'){
            DB::table('distribuidor_demanda_producto')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha]);    
        }
        // ... //
        
        //Aumentar el contador de contactos de la demanda
        DB::table('demanda_producto')
        ->where('id', '=', $id)
        ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
        // ... //

        return redirect('demanda-producto/'.$id)->with('msj', 'Se ha agregado la demanda de producto a su sección de "Demandas De Interés"');
    }

    public function edit($id)
    {
       $solicitudProducto = Demanda_Producto::find($id);

        return view('demandaProducto.edit')->with(compact('solicitudProducto')); 
    }

    public function update(Request $request, $id)
    {
        $demanda_producto  = Demanda_Producto::find($id);
        $demanda_producto ->fill($request->all());
        $demanda_producto ->save();

        return redirect('demanda-producto')->with('msj', 'Se han actualizado los datos de tu solicitud exitosamente.');
    }

    public function solicitudes_producto(){

    }
        
    public function destroy($id)
    {

    }
}
