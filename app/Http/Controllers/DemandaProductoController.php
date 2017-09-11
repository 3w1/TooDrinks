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
    
    //Pestaña Horeca / Comercialización / Mis Búsquedas Activas
    public function index(Request $request){
        $cont = 0;

        $demandasProductos = Demanda_Producto::where('tipo_creador', '=', session('perfilTipo')) 
                                    ->where('creador_id', '=', session('perfilId'))
                                    ->where('status', '=', '1')
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(20);
        
        foreach ($demandasProductos as $d){
            $cont++;
        }

        return view('comercializacion.tabs.busquedasActivas')->with(compact('demandasProductos', 'cont'));
    }

    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Demanda_Producto::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("demanda-producto")->with('msj', 'El status de su demanda ha sido actualizado con éxito. Ahora puede visualizarla en su historial de búsquedas.');
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
                    if ($dp->tipo_creador == 'I'){
                    	$cont++;
                    }elseif ($dp->tipo_creador == 'D'){
                        $creador = DB::table('distribuidor')
                        			->select('pais_id')
                          			->where('id', '=', $dp->creador_id)
                           			->first();

                        if ($creador->pais_id == session('perfilPais')){
	                        $cont++;
	                    }
                    }elseif ($dp->tipo_creador == 'H'){
                  		$creador= DB::table('horeca')
                           			->select('pais_id')
                           			->where('id', '=', $dp->creador_id)
                           			->first();

                        if ($creador->pais_id == session('perfilPais')){
	                        $cont++;
	                    }
                    }	
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
                    if ($dp->tipo_creador == 'D'){
                        $creador = DB::table('distribuidor')
                        			->select('pais_id')
                          			->where('id', '=', $dp->creador_id)
                           			->first();
                    }else{
                  		$creador= DB::table('horeca')
                           			->select('pais_id')
                           			->where('id', '=', $dp->creador_id)
                           			->first();
                    }	
                    
                    if ($creador->pais_id == session('perfilPais')){
                        $cont++;
                    }
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
                	$horeca = DB::table('horeca')
                            ->select('pais_id')
                   			->where('id', '=', $dp->creador_id)
                            ->first();
                	if ($horeca->pais_id == session('perfilPais')){
                    	$cont++;
               		}
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
                	$creadorDemanda = DB::table('demanda_producto')
                						->select('creador_id', 'tipo_creador')
                						->where('id', '=', $db->id)
                						->first();

                    if ($creadorDemanda->tipo_creador == 'I'){
                    	$cont++;
                    }elseif ($creadorDemanda->tipo_creador == 'D'){
                        $creador = DB::table('distribuidor')
                        			->select('pais_id')
                          			->where('id', '=', $creadorDemanda->creador_id)
                           			->first();

                        if ($creador->pais_id == session('perfilPais')){
	                        $cont++;
	                    }
                    }elseif ($creadorDemanda->tipo_creador == 'H'){
                  		$creador= DB::table('horeca')
                           			->select('pais_id')
                           			->where('id', '=', $creadorDemanda->creador_id)
                           			->first();
                        if ($creador->pais_id == session('perfilPais')){
	                        $cont++;
	                    }
                    }	
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
                	$creadorDemanda = DB::table('demanda_producto')
                						->select('creador_id', 'tipo_creador')
                						->where('id', '=', $db->id)
                						->first();
                    if ($creadorDemanda->tipo_creador == 'D'){
                        $creador = DB::table('distribuidor')
                        			->select('pais_id')
                          			->where('id', '=', $creadorDemanda->creador_id)
                           			->first();
                    }else{
                  		$creador= DB::table('horeca')
                           			->select('pais_id')
                           			->where('id', '=', $creadorDemanda->creador_id)
                           			->first();
                    }	
                    
                    if ($creador->pais_id == session('perfilPais')){
                        $cont++;
                    }
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
                	$creadorDemanda = DB::table('demanda_producto')
                						->select('creador_id')
                						->where('id', '=', $db->id)
                						->first();

                	$horeca = DB::table('horeca')
                            ->select('pais_id')
                   			->where('id', '=', $creadorDemanda->creador_id)
                            ->first();
                	if ($horeca->pais_id == session('perfilPais')){
                    	$cont++;
               		}
                }
            }

            return view('solicitudes.tabsDistribuidor.bebida')->with(compact('demandasBebidas', 'cont'));               
        }
    }

    //Ver detalles de demanda para las entidaddes interesada
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

    //Pestaña Horeca / Comercialización / Buscar Producto
    public function create(Request $request){
        $productos = Producto::where('id', '<>', '0')
                    ->where('publicado', '=', '1')
                    ->nombre($request->get('busqueda'))
                    ->marca($request->get('marca'))
                    ->orderBy('nombre')
                    ->paginate(8);

        $cont=0;
        foreach ($productos as $p){
            $cont++;
        }

        $marcas = DB::table('marca')
                    ->where('id', '<>', '0')
                    ->where('publicada', '=', '1')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        return view('comercializacion.tabs.buscarProducto')->with(compact('productos', 'marcas', 'cont'));
    }

    //Almacena la búsqueda de productos de horecas
    public function store(Request $request){
        $fecha = new \DateTime();

        $demanda_producto  = new Demanda_Producto($request->all());
        $demanda_producto->fecha_creacion = $fecha;
        $demanda_producto ->save();

        $ult_demanda = DB::table('demanda_producto')
                        ->select('id')
                        ->orderBy('created_at', 'DESC')
                        ->first();

        $distribuidores = DB::table('distribuidor_producto')
                        ->select('distribuidor.id')
                        ->join('distribuidor', 'distribuidor_producto.distribuidor_id', '=', 'distribuidor.id')
                        ->where('distribuidor_producto.producto_id', '=', $request->producto_id)
                        ->where('distribuidor.pais_id', '=', session('perfilPais'))
                        ->get();

        $producto = DB::table('producto')
                    ->select('nombre')
                    ->where('id', '=', $request->producto_id)
                    ->first();

        $cont = 0;
        foreach ($distribuidores as $dist){
            $cont++;
        }

        if ($cont > 0){
            //Notifico a los distribuidores
            foreach ($distribuidores as $dist){
                $notificacion_distribuidor = new Notificacion_D();
                $notificacion_distribuidor->creador_id = session('perfilId');
                $notificacion_distribuidor->tipo_creador = session('perfilTipo');
                $notificacion_distribuidor->titulo = 'Estan demandando tu producto '. $producto->nombre;
                $notificacion_distribuidor->url='demanda-producto/'.$ult_demanda->id;
                $notificacion_distribuidor->descripcion = 'Demanda de Producto';
                $notificacion_distribuidor->color = 'bg-aqua';
                $notificacion_distribuidor->icono = 'fa fa-shopping-bag';
                $notificacion_distribuidor->tipo ='DP';
                $notificacion_distribuidor->distribuidor_id = $dist->id;
                $notificacion_distribuidor->fecha = $fecha;
                $notificacion_distribuidor->leida = '0';
                $notificacion_distribuidor->save();
            }
        }else{
            $importadores = DB::table('importador_producto')
                        ->select('importador.id')
                        ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                        ->where('importador_producto.producto_id', '=', $request->producto_id)
                        ->where('importador.pais_id', '=', session('perfilPais'))
                        ->get();

            $cont = 0;
            foreach ($importadores as $imp){
                $cont++;
            }

            if ($cont > 0){
                //Notifico a los importadores
                foreach ($importadores as $imp){
                    $notificacion_importador = new Notificacion_I();
                    $notificacion_importador->creador_id = session('perfilId');
                    $notificacion_importador->tipo_creador = session('perfilTipo');
                    $notificacion_importador->titulo = 'Estan demandando tu producto '. $producto->nombre;
                    $notificacion_importador->url='demanda-producto/'.$ult_demanda->id;
                    $notificacion_importador->descripcion = 'Demanda de Producto';
                    $notificacion_importador->color = 'bg-aqua';
                    $notificacion_importador->icono = 'fa fa-shopping-bag';
                    $notificacion_importador->tipo ='DP';
                    $notificacion_importador->importador_id = $imp->id;
                    $notificacion_importador->fecha = $fecha;
                    $notificacion_importador->leida = '0';
                    $notificacion_importador->save();
                }
            }else{
                $productor = DB::table('producto')
                    ->select('productor.id', 'productor.pais_id')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->where('producto.id', '=', $request->producto_id )
                    ->first();

                if ($productor->pais_id == session('perfilPais')){
                    //Notifico al Productor
                    $notificaciones_productor = new Notificacion_P();
                    $notificaciones_productor->creador_id = session('perfilId');
                    $notificaciones_productor->tipo_creador = session('perfilTipo');
                    $notificaciones_productor->titulo = 'Estan demandando tu producto '. $producto->nombre;
                    $notificaciones_productor->url='demanda-producto/'.$ult_demanda->id;
                    $notificaciones_productor->descripcion = 'Demanda de Producto';
                    $notificaciones_productor->color = 'bg-aqua';
                    $notificaciones_productor->icono = 'fa fa-shopping-bag';
                    $notificaciones_productor->tipo ='DP';
                    $notificaciones_productor->productor_id = $productor->id;
                    $notificaciones_productor->fecha = $fecha;
                    $notificaciones_productor->leida = '0';
                    $notificaciones_productor->save();
                }
            }
        }
        
        return redirect('demanda-producto')->with('msj', 'Se ha almacenado su solicitud de producto con éxito.');
    }

    //Pestaña Horeca / Comercializacion / Buscar Tipo de Bebida
    public function solicitar_bebida(Request $request){
        $pais_elegido = null;
        
        $bebidas = Bebida::nombre($request->get('busqueda'))
                    ->orderBy('nombre', 'ASC')
                    ->paginate(20);

        if ($request->get('bebida') != null){
            $bebidas = Bebida::where('id', '=', $request->get('bebida'))->paginate(1);
            
            $pais_elegido = DB::table('pais')
                        ->select('id', 'pais')
                        ->where('id', '=', $request->get('pais'))
                        ->first();
        }

        $tipos_bebidas = DB::table('bebida')
                        ->orderBy('nombre', 'ASC')
                        ->pluck('nombre', 'id');

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        $cont =0;
        foreach ($bebidas as $b){
            $cont++;
        }

        return view('comercializacion.tabs.buscarBebida')->with(compact('bebidas', 'cont', 'tipos_bebidas', 'paises', 'pais_elegido'));
    }

    //Almacena una demanda de bebida
    public function bebida_store(Request $request){
        $fecha = new \DateTime();

        $demanda_producto  = new Demanda_Producto($request->all());         
        $demanda_producto->fecha_creacion = $fecha;
        $demanda_producto ->save();

        $ult_demanda = DB::table('demanda_producto')
                        ->select('id')
                        ->orderBy('created_at', 'DESC')
                        ->first();

        if ($request->pais_id == null){
            $distribuidores = DB::table('bebida')
                        ->select('bebida.nombre', 'distribuidor.id')
                        ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                        ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                        ->join('distribuidor', 'distribuidor_producto.distribuidor_id', '=', 'distribuidor.id')
                        ->where('bebida.id', '=', $request->bebida_id)
                        ->where('distribuidor.pais_id', '=', session('perfilPais'))
                        ->groupBy('producto.bebida_id', 'bebida.nombre', 'distribuidor.id')
                        ->get();
            $cont=0;
            foreach ($distribuidores as $dist){
                $cont++;
            }

            if ($cont > 0){
                foreach ($distribuidores as $dist){
                    $notificacion_distribuidor = new Notificacion_D();
                    $notificacion_distribuidor->creador_id = session('perfilId');
                    $notificacion_distribuidor->tipo_creador = session('perfilTipo');
                    $notificacion_distribuidor->titulo = 'Estan demandando la bebida '. $dist->nombre. ' que tu posees.';
                    $notificacion_distribuidor->url='demanda-producto/'.$ult_demanda->id;
                    $notificacion_distribuidor->descripcion = 'Demanda de Producto';
                    $notificacion_distribuidor->color = 'bg-aqua';
                    $notificacion_distribuidor->icono = 'fa fa-shopping-bag';
                    $notificacion_distribuidor->tipo ='DP';
                    $notificacion_distribuidor->distribuidor_id = $dist->id;
                    $notificacion_distribuidor->fecha = $fecha;
                    $notificacion_distribuidor->leida = '0';
                    $notificacion_distribuidor->save();
                }
            }else{
                $importadores = DB::table('bebida')
                        ->select('bebida.nombre', 'importador.id')
                        ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                        ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                        ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                        ->where('bebida.id', '=', $request->bebida_id)
                        ->where('importador.pais_id', '=', session('perfilPais'))
                        ->groupBy('producto.bebida_id', 'bebida.nombre', 'importador.id')
                        ->get();
                $cont=0;
                foreach ($importadores as $imp){
                    $cont++;
                }

                if ($cont > 0){
                    foreach ($importadores as $imp){
                        $notificacion_importador = new Notificacion_I();
                        $notificacion_importador->creador_id = session('perfilId');
                        $notificacion_importador->tipo_creador = session('perfilTipo');
                        $notificacion_importador->titulo = 'Estan demandando la bebida '. $imp->nombre. ' que tu posees.';
                        $notificacion_importador->url='demanda-producto/'.$ult_demanda->id;
                        $notificacion_importador->descripcion = 'Demanda de Producto';
                        $notificacion_importador->color = 'bg-aqua';
                        $notificacion_importador->icono = 'fa fa-shopping-bag';
                        $notificacion_importador->tipo ='DP';
                        $notificacion_importador->importador_id = $imp->id;
                        $notificacion_importador->fecha = $fecha;
                        $notificacion_importador->leida = '0';
                        $notificacion_importador->save();
                    }
                }else{
                    $productores = DB::table('bebida')
                            ->select('bebida.nombre', 'productor.id')
                            ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->join('productor', 'marca.productor_id', '=', 'productor.id')
                            ->where('bebida.id', '=', $request->bebida_id)
                            ->where('productor.pais_id', '=', session('perfilPais'))
                            ->groupBy('producto.bebida_id', 'bebida.nombre', 'productor.id')
                            ->get();

                    $cont = 0;
                    foreach ($productores as $prod){
                        $notificacion_productor = new Notificacion_P();
                        $notificacion_productor->creador_id = session('perfilId');
                        $notificacion_productor->tipo_creador = session('perfilTipo');
                        $notificacion_productor->titulo = 'Estan demandando la bebida '. $prod->nombre. ' que tu posees.';
                        $notificacion_productor->url='demanda-producto/'.$ult_demanda->id;
                        $notificacion_productor->descripcion = 'Demanda de Producto';
                        $notificacion_productor->color = 'bg-aqua';
                        $notificacion_productor->icono = 'fa fa-shopping-bag';
                        $notificacion_productor->tipo ='DP';
                        $notificacion_productor->productor_id = $prod->id;
                        $notificacion_productor->fecha = $fecha;
                        $notificacion_productor->leida = '0';
                        $notificacion_productor->save();
                    }
                }
            }
        }else{
            $distribuidores = DB::table('bebida')
                        ->select('bebida.nombre', 'distribuidor.id')
                        ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                        ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                        ->join('distribuidor', 'distribuidor_producto.distribuidor_id', '=', 'distribuidor.id')
                        ->where('bebida.id', '=', $request->bebida_id)
                        ->where('producto.pais_id', '=', $request->pais_id)
                        ->where('distribuidor.pais_id', '=', session('perfilPais'))
                        ->groupBy('producto.bebida_id', 'bebida.nombre', 'distribuidor.id')
                        ->get();

            $cont=0;
            foreach ($distribuidores as $dist){
                $cont++;
            }

            if ($cont > 0){
                foreach ($distribuidores as $dist){
                    $notificacion_distribuidor = new Notificacion_D();
                    $notificacion_distribuidor->creador_id = session('perfilId');
                    $notificacion_distribuidor->tipo_creador = session('perfilTipo');
                    $notificacion_distribuidor->titulo = 'Estan demandando la bebida '. $dist->nombre. ' que tu posees.';
                    $notificacion_distribuidor->url='demanda-producto/'.$ult_demanda->id;
                    $notificacion_distribuidor->descripcion = 'Demanda de Producto';
                    $notificacion_distribuidor->color = 'bg-aqua';
                    $notificacion_distribuidor->icono = 'fa fa-shopping-bag';
                    $notificacion_distribuidor->tipo ='DP';
                    $notificacion_distribuidor->distribuidor_id = $dist->id;
                    $notificacion_distribuidor->fecha = $fecha;
                    $notificacion_distribuidor->leida = '0';
                    $notificacion_distribuidor->save();
                }
            }else{
                $importadores = DB::table('bebida')
                        ->select('bebida.nombre', 'importador.id')
                        ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                        ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                        ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                        ->where('bebida.id', '=', $request->bebida_id)
                        ->where('producto.pais_id', '=', $request->pais_id)
                        ->where('importador.pais_id', '=', session('perfilPais'))
                        ->groupBy('producto.bebida_id', 'bebida.nombre', 'importador.id')
                        ->get();
                $cont=0;
                foreach ($importadores as $imp){
                    $cont++;
                }

                if ($cont > 0){
                    foreach ($importadores as $imp){
                        $notificacion_importador = new Notificacion_I();
                        $notificacion_importador->creador_id = session('perfilId');
                        $notificacion_importador->tipo_creador = session('perfilTipo');
                        $notificacion_importador->titulo = 'Estan demandando la bebida '. $imp->nombre. ' que tu posees.';
                        $notificacion_importador->url='demanda-producto/'.$ult_demanda->id;
                        $notificacion_importador->descripcion = 'Demanda de Producto';
                        $notificacion_importador->color = 'bg-aqua';
                        $notificacion_importador->icono = 'fa fa-shopping-bag';
                        $notificacion_importador->tipo ='DP';
                        $notificacion_importador->importador_id = $imp->id;
                        $notificacion_importador->fecha = $fecha;
                        $notificacion_importador->leida = '0';
                        $notificacion_importador->save();
                    }
                }else{
                    $productores = DB::table('bebida')
                            ->select('bebida.nombre', 'productor.id')
                            ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->join('productor', 'marca.productor_id', '=', 'productor.id')
                            ->where('bebida.id', '=', $request->bebida_id)
                            ->where('producto.pais_id', '=', $request->pais_id)
                            ->where('productor.pais_id', '=', session('perfilPais'))
                            ->groupBy('producto.bebida_id', 'bebida.nombre', 'productor.id')
                            ->get();

                    $cont = 0;
                    foreach ($productores as $prod){
                        $notificacion_productor = new Notificacion_P();
                        $notificacion_productor->creador_id = session('perfilId');
                        $notificacion_productor->tipo_creador = session('perfilTipo');
                        $notificacion_productor->titulo = 'Estan demandando la bebida '. $prod->nombre. ' que tu posees.';
                        $notificacion_productor->url='demanda-producto/'.$ult_demanda->id;
                        $notificacion_productor->descripcion = 'Demanda de Producto';
                        $notificacion_productor->color = 'bg-aqua';
                        $notificacion_productor->icono = 'fa fa-shopping-bag';
                        $notificacion_productor->tipo ='DP';
                        $notificacion_productor->productor_id = $prod->id;
                        $notificacion_productor->fecha = $fecha;
                        $notificacion_productor->leida = '0';
                        $notificacion_productor->save();
                    }
                }
            }
        }

        return redirect('demanda-producto')->with('msj', 'Su solicitud de bebida ha sido almacenada con éxito.');
    }

    //Pestaña Horeca / Comercialización / Historial
    public function historial(){
        $cont = 0;

        $demandasProductos = Demanda_Producto::where('tipo_creador', '=', session('perfilTipo')) 
                                    ->where('creador_id', '=', session('perfilId'))
                                    ->where('status', '=', '0')
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(20);
        
        foreach ($demandasProductos as $d){
            $cont++;
        }

        return view('comercializacion.tabs.historial')->with(compact('demandasProductos', 'cont'));
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
    
    }
    
    public function destroy($id)
    {

    }
}
