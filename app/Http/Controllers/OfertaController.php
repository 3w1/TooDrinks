<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region; use App\Models\Destino_Oferta;
use App\Models\Notificacion_I; use App\Models\Notificacion_D; use App\Models\Notificacion_H;
use DB;


class OfertaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //Pestaña Mis Ofertas Activas
    public function index(Request $request)
    {
        $ofertas = Oferta::titulo($request->get('busqueda'))
                        ->producto($request->get('producto'))
                        ->where('tipo_creador', '=', session('perfilTipo'))
                        ->where('creador_id', '=', session('perfilId'))
                        ->where('status', '=', '1')
                        ->paginate(6);

        $cont=0;
        foreach ($ofertas as $o){
            $cont++;
        }

        if (session('perfilTipo') == 'P'){
            $productos = DB::table('producto')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->where('marca.productor_id', '=', session('perfilId'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }elseif (session('perfilTipo') == 'I'){
            $productos = DB::table('producto')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }elseif (session('perfilTipo') == 'D'){
            $productos = DB::table('producto')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }

        return view('mercado.tabs.misOfertasActivas')->with(compact('ofertas', 'cont', 'productos'));
    }

    //Muestra el detalle de una oferta creada por la entidad logueada
    public function show($id, $titulo){
        $oferta = Oferta::find($id);
        
        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('oferta.show')->with(compact('oferta', 'destinos'));   
    }

    public function update(Request $request, $id){   
        $oferta = Oferta::find($id);
        $oferta->fill($request->all());
        $oferta->save();

        return redirect("oferta/".$id."/".$oferta->titulo)->with('msj', 'Los datos de su oferta han sido actualizados con éxito.');
    }

    //Cambia el status de una oferta
    public function cambiar_status(Request $request){
        Oferta::find($request->id_oferta)
                ->update(['status' => $request->status]);

        return redirect("oferta/".$request->id_oferta."/".$request->titulo_oferta)->with('msj', 'El status de su oferta ha sido actualizado con éxito.');
    }

    //Pestaña Crear Oferta (Sin Producto)
    public function create(Request $request){   
        if ( session('perfilTipo') == 'P'){
            $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');

            $paises_posibles = DB::table('pais')
                    ->select(DB::raw('count(*) as cant'))
                    ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                    ->where('productor_pais.productor_id', '=', session('perfilId'))
                    ->first();

            if ($paises_posibles->cant > 0){
                $paises = DB::table('pais')
                        ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                        ->where('productor_pais.productor_id', '=', session('perfilId'))
                        ->orderBy('pais.pais')
                        ->pluck('pais.pais', 'pais.id');

            }else{
                $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');
            }
        }elseif ( session('perfilTipo') == 'I'){
            $marcas = DB::table('marca')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->where('importador_marca.status', '=', '1')
                    ->pluck('marca.nombre', 'marca.id');

            $paises = DB::table('pais')
                        ->where('id', '=', session('perfilPais'))
                        ->select('pais', 'id')
                        ->first();
        }elseif (session('perfilTipo') == 'D'){
            $marcas = DB::table('marca')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                    ->where('distribuidor_marca.status', '=', '1')
                    ->pluck('marca.nombre', 'marca.id');
            $paises = DB::table('pais')
                        ->where('id', '=', session('perfilPais'))
                        ->select('pais', 'id')
                        ->first();
        }

        $tipo = '0';

        return view('mercado.tabs.createOferta')->with(compact('paises', 'marcas', 'tipo'));
    }

    //Crear oferta a partir de un producto (Mis Productos)
    public function crear_oferta($id, $producto){ 
        if (session('perfilTipo') == 'P'){
            $paises_posibles = DB::table('pais')
                    ->select('pais.id')
                    ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                    ->where('productor_pais.productor_id', '=', session('perfilId'))
                    ->first();

            if ($paises_posibles != null){
                $paises = DB::table('pais')
                        ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                        ->where('productor_pais.productor_id', '=', session('perfilId'))
                        ->orderBy('pais.pais')
                        ->pluck('pais.pais', 'pais.id');

            }else{
                $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');
            }
        }else{
            $paises = DB::table('pais')
                        ->where('id', '=', session('perfilPais'))
                        ->select('pais', 'id')
                        ->first();
        }

        $tipo = '1';

        return view('oferta.create')->with(compact('id', 'producto', 'paises', 'tipo'));
    }

    public function store(Request $request){
        $fecha = new \DateTime();

        if ( session('perfilSuscripcion') != 'Oro' ){
            $creditos = 1;
        }else{
            $creditos = 0;
        }

        $oferta = new Oferta($request->all());
        $oferta->fecha = $fecha;
        $oferta->save();

        $ult_oferta = DB::table('oferta')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->first();

        if ( $request->opciones == "P"){
            for ($i=0; $i<count($request->provincias); $i++){
                $destino = new Destino_Oferta();
                $destino->oferta_id = $ult_oferta->id;
                $destino->pais_id = $request->pais_id;
                $destino->provincia_region_id = $request->provincias[$i];
                $destino->save();
            }
        }else{
            $provincias = DB::table('provincia_region')
                            ->select('id')
                            ->where('pais_id', '=', $request->pais_id)
                            ->get();

            foreach ($provincias as $provincia){
                $destino = new Destino_Oferta();
                $destino->oferta_id = $ult_oferta->id;
                $destino->pais_id = $request->pais_id;
                $destino->provincia_region_id = $provincia->id;
                $destino->save();
            }
        }

        $producto = DB::table('producto')
                    ->select('nombre')
                    ->where('id', '=', $request->producto_id)
                    ->first();

        //ENVÍO DE NOTIFICACIONES
        if ($request->visible_importadores == '1'){
            $importadores = DB::table('importador')
                                ->select('id')
                                ->where('pais_id', '=', $request->pais_id)
                                ->get();
            $cont=0;
            foreach ($importadores as $importador){
                $cont++;
            }

            if ($cont > 0){
                foreach ($importadores as $importador){
                    $notificaciones_importador = new Notificacion_I();
                    $notificaciones_importador->creador_id = session('perfilId');
                    $notificaciones_importador->tipo_creador = session('perfilTipo');
                    $notificaciones_importador->titulo = 'Hay una nueva oferta disponible de '.$producto->nombre.' para tu país.';
                    $notificaciones_importador->url= 'oferta/detalles-de-oferta?oferta_id='.$ult_oferta->id;
                    $notificaciones_importador->importador_id = $importador->id;
                    $notificaciones_importador->descripcion = 'Nueva Oferta';
                    $notificaciones_importador->color = 'bg-purple';
                    $notificaciones_importador->icono = 'fa fa-shopping-cart';
                    $notificaciones_importador->tipo ='NO';
                    $notificaciones_importador->fecha = $fecha;
                    $notificaciones_importador->leida = '0';
                    $notificaciones_importador->save();   
                }        
            }
        }

        if ($request->visible_distribuidores == '1'){
            $distribuidores = DB::table('distribuidor')
                        ->select('distribuidor.id')
                        ->join('destino_oferta', 'distribuidor.provincia_region_id', '=', 'destino_oferta.provincia_region_id')
                        ->where('destino_oferta.oferta_id', '=', $ult_oferta->id)
                        ->get();

            $cont=0;
            foreach ($distribuidores as $distribuidor){
                $cont++;
            }

            if ($cont > 0){
                foreach ($distribuidores as $distribuidor){
                    $notificaciones_distribuidor = new Notificacion_D();
                    $notificaciones_distribuidor->creador_id = session('perfilId');
                    $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                    $notificaciones_distribuidor->titulo = 'Hay una nueva oferta disponible de '.$producto->nombre.' para tu país.';
                    $notificaciones_distribuidor->url= 'oferta/detalles-de-oferta?oferta_id='.$ult_oferta->id;
                    $notificaciones_distribuidor->distribuidor_id = $distribuidor->id;
                    $notificaciones_distribuidor->descripcion = 'Nueva Oferta';
                    $notificaciones_distribuidor->color = 'bg-purple';
                    $notificaciones_distribuidor->icono = 'fa fa-shopping-cart';
                    $notificaciones_distribuidor->tipo ='NO';
                    $notificaciones_distribuidor->fecha = $fecha;
                    $notificaciones_distribuidor->leida = '0';
                    $notificaciones_distribuidor->save();   
                }        
            }
        }

        if ($request->visible_horecas == '1'){
            $horecas = DB::table('horeca')
                        ->select('horeca.id')
                        ->join('destino_oferta', 'horeca.provincia_region_id', '=', 'destino_oferta.provincia_region_id')
                        ->where('destino_oferta.oferta_id', '=', $ult_oferta->id)
                        ->get();

            $cont=0;
            foreach ($horecas as $horeca){
                $cont++;
            }

            if ($cont > 0){
                foreach ($horecas as $horeca){
                    $notificaciones_horeca = new Notificacion_H();
                    $notificaciones_horeca->creador_id = session('perfilId');
                    $notificaciones_horeca->tipo_creador = session('perfilTipo');
                    $notificaciones_horeca->titulo = 'Hay una nueva oferta disponible de '.$producto->nombre.' para tu país.';
                    $notificaciones_horeca->url= 'oferta/detalles-de-oferta?oferta_id='.$ult_oferta->id;
                    $notificaciones_horeca->horeca_id = $horeca->id;
                    $notificaciones_horeca->descripcion = 'Nueva Oferta';
                    $notificaciones_horeca->color = 'bg-purple';
                    $notificaciones_horeca->icono = 'fa fa-shopping-cart';
                    $notificaciones_horeca->tipo ='NO';
                    $notificaciones_horeca->fecha = $fecha;
                    $notificaciones_horeca->leida = '0';
                    $notificaciones_horeca->save();   
                }        
            }
        }

        if ($creditos == '1'){
            return redirect('credito/gastar-creditos-co/'.$ult_oferta->id); 
        }else{
            return redirect('oferta')->with('msj', 'Su oferta '.$oferta->titulo.' ha sido creada con éxito.');
        }    
    }

    //Pestaña Ofertas Disponibles
    public function ofertas_disponibles(Request $request){
        if (session('perfilTipo') == 'I'){
            $ofertas = Oferta::select('oferta.id')
                        ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                        ->where('destino_oferta.pais_id', '=', session('perfilPais'))
                        ->where('oferta.visible_importadores', '=', '1')
                        ->where('oferta.status', '=', '1')
                        ->titulo($request->get('busqueda'))
                        ->producto($request->get('producto'))
                        ->groupBy('oferta.id')
                        ->paginate(6);
        }elseif (session('perfilTipo') == 'D'){
            $ofertas = Oferta::select('oferta.id')
                        ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                        ->where('destino_oferta.provincia_region_id', '=', session('perfilProvincia'))
                        ->where('oferta.visible_distribuidores', '=', '1')
                        ->where('oferta.status', '=', '1')
                        ->titulo($request->get('busqueda'))
                        ->producto($request->get('producto'))
                        ->paginate(6);
        }elseif (session('perfilTipo') == 'H'){
            $ofertas = Oferta::select('oferta.id')
                        ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                        ->where('destino_oferta.provincia_region_id', '=', session('perfilProvincia'))
                        ->where('oferta.visible_horecas', '=', '1')
                        ->where('oferta.status', '=', '1')
                        ->titulo($request->get('busqueda'))
                        ->producto($request->get('producto'))
                        ->paginate(6);

            $cont = 0;
            foreach ($ofertas as $o){
                $cont++;
            }

            return view('mercado.tabsHoreca.ofertasDisponibles')->with(compact('ofertas', 'cont'));
        }

        $cont = 0;
        foreach ($ofertas as $o){
            $cont++;
        }

        if (session('perfilTipo') == 'P'){
            $productos = DB::table('producto')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->where('marca.productor_id', '=', session('perfilId'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }elseif (session('perfilTipo') == 'I'){
            $productos = DB::table('producto')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }elseif (session('perfilTipo') == 'D'){
            $productos = DB::table('producto')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }

        return view('mercado.tabs.ofertasDisponibles')->with(compact('ofertas', 'cont', 'productos'));
    }

    //Muestra el detalle de una oferta disponible (Desde la Pestaña Ofertas Disponibles)
    public function detalle_oferta(Request $request){
    	if (session('perfilTipo') == 'I'){
    		$ofertaMarcada = DB::table('importador_oferta')
    						->select('id')
    						->where('importador_id', '=', session('perfilId'))
    						->where('oferta_id', '=', $request->oferta_id)
    						->first();

    		if ($ofertaMarcada == null){
    			$restringido = 1;
    		}else{
    			$restringido = 0;
    		}
    	}elseif (session('perfilTipo') == 'D'){
    		$ofertaMarcada = DB::table('distribuidor_oferta')
    						->select('id')
    						->where('distribuidor_id', '=', session('perfilId'))
    						->where('oferta_id', '=', $request->oferta_id)
    						->first();

    		if ($ofertaMarcada == null){
    			$restringido = 1;
    		}else{
    			$restringido = 0;
    		}
    	}elseif (session('perfilTipo') == 'H'){
    		$ofertaMarcada = DB::table('horeca_oferta')
    						->select('id')
    						->where('horeca_id', '=', session('perfilId'))
    						->where('oferta_id', '=', $request->oferta_id)
    						->first();

    		if ($ofertaMarcada == null){
    			$restringido = 1;
    		}else{
    			$restringido = 0;
    		}
    	}
    	
    	$oferta = Oferta::find($request->oferta_id);


        $visitas = $oferta->cantidad_visitas + 1;

        $act = DB::table('oferta')
                ->where('id', '=', $request->oferta_id)
                ->update(['cantidad_visitas' => $visitas ]);

        $oferta->cantidad_visitas = $visitas;
        
        $destinos = Destino_Oferta::where('oferta_id', '=', $request->oferta_id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('oferta.detalleOfertaDisponible')->with(compact('oferta', 'destinos', 'restringido')); 
    }

    //Marca una oferta "de interes" para la entidad loggeada 
    public function marcar_oferta($id, $tipo){
    	$fecha = new \DateTime();
    	
        $oferta = Oferta::find($id);

    	//Asociar entidad a la oferta
    	if (session('perfilTipo') == 'I'){
    		$oferta->importadores()->attach(session('perfilId'), ['fecha' => $fecha, 'marcada' => $tipo ]);
    	}elseif (session('perfilTipo') == 'D'){
    		$oferta->distribuidores()->attach(session('perfilId'), ['fecha' => $fecha, 'marcada' => $tipo ]);
    	}elseif (session('perfilTipo') == 'H'){
    		$oferta->horecas()->attach(session('perfilId'), ['fecha' => $fecha, 'marcada' => $tipo ]);
    	}
        // ... //
        
        if ($tipo == '1'){
            DB::table('oferta')
                ->where('id', '=', $id)
            ->update(['cantidad_contactos' => ($oferta->cantidad_contactos + 1) ]); 

            return redirect('oferta/detalles-de-oferta?oferta_id='.$id)->with('msj', 'Se ha agregado la oferta a su historial de Ofertas.');
        }

        return redirect('oferta/ofertas-disponibles')->with('msj', 'Se ha eliminado la oferta del listado con éxito.');
    }

    public function historial(Request $request){
        $ofertas = Oferta::where('tipo_creador', '=', session('perfilTipo'))
                    ->where('creador_id', '=', session('perfilId'))
                    ->where('status', '=', '0')
                    ->titulo($request->get('busqueda'))
                    ->producto($request->get('producto'))
                    ->paginate(12);

        $cont = 0;
        foreach ($ofertas as $o){
            $cont++;
        }

        if (session('perfilTipo') == 'P'){
            $productos = DB::table('producto')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->where('marca.productor_id', '=', session('perfilId'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }elseif (session('perfilTipo') == 'I'){
            $productos = DB::table('producto')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }elseif (session('perfilTipo') == 'D'){
            $productos = DB::table('producto')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->orderBy('producto.nombre', 'ASC')
                            ->pluck('producto.nombre', 'producto.id');
        }

        return view('mercado.tabs.historialOfertas')->with(compact('ofertas', 'cont', 'productos'));
    }

    public function edit($id)
    {
       
    }

    public function destroy($id)
    {

    }
}
