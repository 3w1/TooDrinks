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

    //Pestaña Solicitudes / Producto
    public function demandas_productos_disponibles(Request $request){
        if (session('perfilTipo') == 'P'){
            $demandasProductos = Demanda_Producto::select('demanda_producto.*', 'producto.nombre', 'producto.marca_id', 'marca.productor_id')
                                ->producto($request->get('producto'))
                                ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('marca.productor_id', '=', session('perfilId'))
                                ->where('demanda_producto.status', '=', '1')
                                ->paginate(6);

            $cont = 0;
            foreach ($demandasProductos as $dp){
                $relacion = DB::table('productor_demanda_producto')
                                    ->select('demanda_producto_id')
                                    ->where('demanda_producto_id', '=', $dp->id)
                                    ->where('productor_id', '=', session('perfilId'))
                                    ->first();

                if ($relacion == null){
                    $cont++;
                }
            }

            $productos = DB::table('producto')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->where('marca.productor_id', '=', session('perfilId'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');

            return view('solicitudes.tabs.producto')->with(compact('demandasProductos', 'productos', 'cont'));

        }elseif (session('perfilTipo') == 'I'){
            $demandasProductos = Demanda_Producto::select('demanda_producto.*', 'producto.nombre', 'producto.marca_id')
                                    ->producto($request->get('producto'))
                                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                                    ->where('importador_producto.importador_id', '=', session('perfilId'))
                                    ->where('demanda_producto.status', '=', '1')
                                    ->where('demanda_producto.tipo_creador', '<>', 'I')
                                    ->paginate(10);
            $cont = 0;
            foreach ($demandasProductos as $dp){
                $relacion = DB::table('importador_demanda_producto')
                                    ->select('demanda_producto_id')
                                    ->where('demanda_producto_id', '=', $dp->id)
                                    ->where('importador_id', '=', session('perfilId'))
                                    ->first();

                if ($relacion == null){
                    $cont++;
                }
            }

            $productos = DB::table('producto')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');

            return view('solicitudes.tabsImportador.producto')->with(compact('demandasProductos', 'productos', 'cont'));

        }elseif (session('perfilTipo') == 'D'){
            $demandasProductos =  Demanda_Producto::select('demanda_producto.*')
                                    ->producto($request->get('producto'))
                                    ->select('demanda_producto.*', 'producto.nombre', 'producto.marca_id')
                                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                                    ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                                    ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                                    ->where('demanda_producto.status', '=', '1')
                                    ->where('demanda_producto.tipo_creador', '=', 'H')
                                    ->paginate(10);

            $cont = 0;
            foreach ($demandasProductos as $dp){
                $relacion = DB::table('distribuidor_demanda_producto')
                                    ->select('demanda_producto_id')
                                    ->where('demanda_producto_id', '=', $dp->id)
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->first();

                if ($relacion == null){
                    $cont++;
                }
            }

            $productos = DB::table('producto')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');

            return view('solicitudes.tabsDistribuidor.producto')->with(compact('demandasProductos', 'productos', 'cont'));
        }
    }

    //Pestaña Bebida (Solicitudes)
    public function demandas_bebidas_disponibles(Request $request){
        if (session('perfilTipo') == 'P'){
            $demandasBebidas = DB::table('demanda_producto')
                                ->select('demanda_producto.id')
                                ->join('producto', 'demanda_producto.bebida_id', '=', 'producto.bebida_id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('marca.productor_id', '=', session('perfilId'))
                                ->where('demanda_producto.producto_id', '=', '0')
                                ->where('demanda_producto.status', '=', '1')
                                ->groupBy('demanda_producto.id', 'producto.bebida_id')
                                ->paginate(10);

            $cont = 0;
            foreach ($demandasBebidas as $db){
                $relacion = DB::table('productor_demanda_producto')
                            ->select('demanda_producto_id')
                            ->where('demanda_producto_id', '=', $db->id)
                            ->where('productor_id', '=', session('perfilId'))
                            ->first();

                if ($relacion == null){
                    $cont++;
                }
            }

            return view('solicitudes.tabs.bebida')->with(compact('demandasBebidas', 'cont'));

        }elseif (session('perfilTipo') == 'I'){
            $demandasBebidas = DB::table('demanda_producto')
                                ->select('demanda_producto.id')
                                ->join('producto', 'demanda_producto.bebida_id', '=', 'producto.bebida_id')
                                ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                                ->where('importador_producto.importador_id', '=', session('perfilId'))
                                ->where('demanda_producto.producto_id', '=', '0')
                                ->where('demanda_producto.status', '=', '1')
                                ->where('demanda_producto.tipo_creador', '<>', 'I')
                                ->groupBy('demanda_producto.id', 'producto.bebida_id')
                                ->paginate(10);

            $cont = 0;
            foreach ($demandasBebidas as $db){
                $relacion = DB::table('importador_demanda_producto')
                            ->select('demanda_producto_id')
                            ->where('demanda_producto_id', '=', $db->id)
                            ->where('importador_id', '=', session('perfilId'))
                            ->first();

                if ($relacion == null){
                    $cont++;
                }
            }

            return view('solicitudes.tabsImportador.bebida')->with(compact('demandasBebidas', 'cont'));

        }elseif (session('perfilTipo') == 'D'){
            $demandasBebidas = DB::table('demanda_producto')
                                ->select('demanda_producto.id')
                                ->join('producto', 'demanda_producto.bebida_id', '=', 'producto.bebida_id')
                                ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                                ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                                ->where('demanda_producto.producto_id', '=', '0')
                                ->where('demanda_producto.status', '=', '1')
                                ->where('demanda_producto.tipo_creador', '=', 'H')
                                ->groupBy('demanda_producto.id', 'producto.bebida_id')
                                ->paginate(10);

            $cont = 0;
            foreach ($demandasBebidas as $db){
                $relacion = DB::table('distribuidor_demanda_producto')
                            ->select('demanda_producto_id')
                            ->where('demanda_producto_id', '=', $db->id)
                            ->where('distribuidor_id', '=', session('perfilId'))
                            ->first();

                if ($relacion == null){
                    $cont++;
                }
            }

            return view('solicitudes.tabsDistribuidor.bebida')->with(compact('demandasBebidas', 'cont'));               
        }
    }

    public function show($id){
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

        $demandaProducto = Demanda_Producto::find($id);

        $visitas = $demandaProducto->cantidad_visitas + 1;

        $act = DB::table('demanda_producto')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $demandaProducto->cantidad_visitas = $visitas;

        return view('demandaProducto.show')->with(compact('demandaProducto', 'restringido'));
    }

    //Marca una demanda de producto "de interes" o "no me interesa" para las entidades con Suscripción 
    public function marcar_demanda($id, $check){
        $fecha = new \DateTime();

        $demanda = Demanda_Producto::find($id);
        
        //Asociar entidad a la demanda 
        if (session('perfilTipo') == 'P'){
            DB::table('productor_demanda_producto')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        }elseif (session('perfilTipo') == 'I'){
            DB::table('importador_demanda_producto')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        }elseif (session('perfilTipo') == 'D'){
            DB::table('distribuidor_demanda_producto')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        }
        // ... //
        
        if ($check == '1'){
            //Aumentar el contador de contactos de la demanda
            DB::table('demanda_producto')
            ->where('id', '=', $id)
            ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
            // ... //
            
            if ($demanda->producto_id == '0'){
                return redirect('demanda-producto/'.$id)->with('msj', 'Se ha agregado la demanda de bebida a su historial de demandas.');
            }
            return redirect('demanda-producto/'.$id)->with('msj', 'Se ha agregado la demanda de producto a su sección de "Demandas De Interés"');
        }

        if ($demanda->producto_id == '0'){
            return redirect('demanda-producto/demandas-bebidas-disponibles')->with('msj', 'Se ha eliminado la demanda de bebida de los listados.');
        }
        return redirect('demanda-producto/demandas-productos-disponibles')->with('msj', 'Se ha eliminado la demanda de producto de los listados.'); 
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
                    ->select('id', 'pais_id', 'bebida_id', 'marca_id', 'nombre')
                    ->where('id', '=', $request->producto_id)
                    ->get()
                    ->first();

            $demanda_producto->pais_id = $producto->pais_id;
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
        
        return redirect('demanda-producto')->with('msj', 'Se ha creado su demanda de producto con éxito.');
    }

    public function demandas_interes(){
        if (session('perfilTipo') == 'P'){
            $demandas = Demanda_Producto::select('demanda_producto.*')
                        ->join('productor_demanda_producto', 'demanda_producto.id', '=', 'productor_demanda_producto.demanda_producto_id')
                        ->where('productor_demanda_producto.productor_id', '=', session('perfilId'))
                        ->where('productor_demanda_producto.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);    
        }elseif (session('perfilTipo') == 'I'){
            $demandas = Demanda_Producto::select('demanda_producto.*')
                        ->join('importador_demanda_producto', 'demanda_producto.id', '=', 'importador_demanda_producto.demanda_producto_id')
                        ->where('importador_demanda_producto.importador_id', '=', session('perfilId'))
                        ->where('importador_demanda_producto.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10); 
        }elseif (session('perfilTipo') == 'D'){
            $demandas = Demanda_Producto::select('demanda_producto.*')
                        ->join('distribuidor_demanda_producto', 'demanda_producto.id', '=', 'distribuidor_demanda_producto.demanda_producto_id')
                        ->where('distribuidor_demanda_producto.distribuidor_id', '=', session('perfilId'))
                        ->where('distribuidor_demanda_producto.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10); 
        }

        return view('demandaProducto.demandasDeInteres')->with(compact('demandas'));
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

        return redirect('demanda-producto')->with('msj', 'Se han actualizado los datos de tu solicitud con éxito.');
    }
    
    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Demanda_Producto::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("demanda-producto")->with('msj', 'El status de su demanda ha sido actualizado con éxito.');
    } 
    
    public function destroy($id)
    {

    }
}
