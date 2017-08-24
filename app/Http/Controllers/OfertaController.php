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
    
    public function index()
    {
        $ofertas = Oferta::where([
                            ['tipo_creador', '=', session('perfilTipo')],
                            ['creador_id', '=', session('perfilId')],
                           ])
                    ->paginate(6);

        return view('oferta.index')->with(compact('ofertas'));
    }

    public function ofertas_disponibles(){
    	if (session('perfilTipo') == 'I'){
    		$notificaciones_pendientes_NO = DB::table('notificacion_i')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'NO')
                                        ->get();

        	foreach ($notificaciones_pendientes_NO as $notificacion){
            	$act = DB::table('notificacion_i')
                    ->where('id', '=', $notificacion->id)
                    ->update(['leida' => '1']);
        	}

	        $importador = DB::table('importador')
	                            ->where('id', '=', session('perfilId') )
	                            ->select('pais_id')
	                            ->first();

	        $ofertas = Oferta::select('oferta.*')
	                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
	                    ->where('oferta.visible_importadores', '=', '1')
	                    ->where('destino_oferta.pais_id', '=', $importador->pais_id)
	                    ->groupBy('oferta.id')
	                    ->paginate(6);

	        return view('oferta.ofertasDisponibles')->with(compact('ofertas'));
    	}

    	if (session('perfilTipo') == 'D'){
    		 $notificaciones_pendientes_NO = DB::table('notificacion_d')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'NO')
                                        ->get();

	        foreach ($notificaciones_pendientes_NO as $notificacion){
	            $act = DB::table('notificacion_d')
	                    ->where('id', '=', $notificacion->id)
	                    ->update(['leida' => '1']);
	        }
	        
	        $distribuidor = DB::table('distribuidor')
	                            ->where('id', '=', session('perfilId') )
	                            ->select('pais_id', 'provincia_region_id')
	                            ->first();

	        $ofertas = Oferta::select('oferta.*')
	                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
	                    ->where('oferta.visible_distribuidores', '=', '1')
	                    ->where('destino_oferta.provincia_region_id', '=', $distribuidor->provincia_region_id)
	                    ->paginate(6);

	        return view('oferta.ofertasDisponibles')->with(compact('ofertas'));
    	}

    	if (session('perfilTipo') == 'H'){
    		$notificaciones_pendientes_NO = DB::table('notificacion_h')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'NO')
                                        ->get();

	        foreach ($notificaciones_pendientes_NO as $notificacion){
	            $act = DB::table('notificacion_h')
	                    ->where('id', '=', $notificacion->id)
	                    ->update(['leida' => '1']);
	        }
	        
	        $horeca = DB::table('horeca')
	                            ->where('id', '=', session('perfilId') )
	                            ->select('provincia_region_id')
	                            ->get()
	                            ->first();

	        $ofertas = Oferta::select('oferta.*')
	                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
	                    ->where('oferta.visible_horecas', '=', '1')
	                    ->where('destino_oferta.provincia_region_id', '=', $horeca->provincia_region_id)
	                    ->paginate(6);

	        return view('oferta.ofertasDisponibles')->with(compact('ofertas'));
    	}
    }

    public function create()
    {   

    }

    public function crear_oferta($id, $producto){ 
        if ($id != '0'){
            $tipo = '1';
        }else{
            $tipo = '2';
        }

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
                        ->orderBy('pais')
                        ->pluck('pais', 'id');
        }
        
        if ( session('perfilTipo') == 'P'){
            $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
        }elseif ( session('perfilTipo') == 'I'){
             $marcas = DB::table('marca')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->pluck('marca.nombre', 'marca.id');
        }elseif (session('perfilTipo') == 'D'){
            $marcas = DB::table('marca')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                    ->pluck('marca.nombre', 'marca.id');
        }elseif (session('perfilTipo') == 'M'){
            $marcas = DB::table('marca')
                        ->orderBy('nombre', 'ASC')
                        ->where('productor_id', '=', session('perfilPadre'))
                        ->pluck('nombre', 'id');
        }

        return view('oferta.create')->with(compact('id', 'producto', 'paises', 'marcas', 'tipo'));
    }

    public function store(Request $request)
    {
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
                    $notificaciones_importador->url='oferta/'.$ult_oferta->id;
                    $notificaciones_importador->importador_id = $importador->id;
                    $notificaciones_importador->descripcion = 'Nueva Oferta';
                    $notificaciones_importador->color = 'bg-purple';
                    $notificaciones_importador->icono = 'fa fa-asterisk';
                    $notificaciones_importador->tipo ='NO';
                    $notificaciones_importador->fecha = $fecha;
                    $notificaciones_importador->leida = '0';
                    $notificaciones_importador->save();   
                }        
            }
        }

        if ($request->visible_distribuidores == '1'){
            $distribuidores = DB::table('distribuidor')
                                ->select('id')
                                ->where('pais_id', '=', $request->pais_id)
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
                    $notificaciones_distribuidor->url='oferta/'.$ult_oferta->id;
                    $notificaciones_distribuidor->distribuidor_id = $distribuidor->id;
                    $notificaciones_distribuidor->descripcion = 'Nueva Oferta';
                    $notificaciones_distribuidor->color = 'bg-purple';
                    $notificaciones_distribuidor->icono = 'fa fa-asterisk';
                    $notificaciones_distribuidor->tipo ='NO';
                    $notificaciones_distribuidor->fecha = $fecha;
                    $notificaciones_distribuidor->leida = '0';
                    $notificaciones_distribuidor->save();   
                }        
            }
        }

        if ($request->visible_horecas == '1'){
            $horecas = DB::table('horeca')
                                ->select('id')
                                ->where('pais_id', '=', $request->pais_id)
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
                    $notificaciones_horeca->url='oferta/'.$ult_oferta->id;
                    $notificaciones_horeca->horeca_id = $horeca->id;
                    $notificaciones_horeca->descripcion = 'Nueva Oferta';
                    $notificaciones_horeca->color = 'bg-purple';
                    $notificaciones_horeca->icono = 'fa fa-asterisk';
                    $notificaciones_horeca->tipo ='NO';
                    $notificaciones_horeca->fecha = $fecha;
                    $notificaciones_horeca->leida = '0';
                    $notificaciones_horeca->save();   
                }        
            }
        }

        if ($creditos == '1'){
            $url = ('credito/gastar-creditos-co/'.$ult_oferta->id);
            return redirect($url); 
        }else{
             return redirect('oferta')->with('msj', 'Su oferta ha sido creada con éxito.');
        }    
    }

    //Muestra el detalle de una oferta creada por la entidad logueada
    public function show($id)
    {
        $oferta = Oferta::find($id);
        
        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('oferta.show')->with(compact('oferta', 'destinos'));   
    }

    //Muestra el detalle de una oferta disponible
    public function detalle_oferta($id){
    	if (session('perfilTipo') == 'I'){
    		$ofertaMarcada = DB::table('importador_oferta')
    						->select('id')
    						->where('importador_id', '=', session('perfilId'))
    						->where('oferta_id', '=', $id)
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
    						->where('oferta_id', '=', $id)
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
    						->where('oferta_id', '=', $id)
    						->first();

    		if ($ofertaMarcada == null){
    			$restringido = 1;
    		}else{
    			$restringido = 0;
    		}
    	}
    	
    	$oferta = Oferta::find($id);

        $visitas = $oferta->cantidad_visitas + 1;

        $act = DB::table('oferta')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $oferta->cantidad_visitas = $visitas;
        
        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('oferta.detalleOferta')->with(compact('oferta', 'destinos', 'restringido')); 
    }

    //Marca una oferta "de interes" para la entidad loggeada 
    public function marcar_oferta($id){
    	$fecha = new \DateTime();

    	$oferta = Oferta::find($id);

    	//Asociar entidad a la oferta
    	if (session('perfilTipo') == 'I'){
    		$oferta->importadores()->attach(session('perfilId'), ['fecha' => $fecha ]);
    	}elseif (session('perfilTipo') == 'D'){
    		$oferta->distribuidores()->attach(session('perfilId'), ['fecha' => $fecha ]);
    	}elseif (session('perfilTipo') == 'H'){
    		$oferta->horecas()->attach(session('perfilId'), ['fecha' => $fecha ]);
    	}
        // ... //
        
        DB::table('oferta')
        ->where('id', '=', $id)
        ->update(['cantidad_contactos' => ($oferta->cantidad_contactos + 1) ]); 

        return redirect('oferta/ver-detalle-oferta/'.$id)->with('msj', 'Se ha agregado la oferta a su lista de Ofertas De Interés');
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {   
        $oferta = Oferta::find($id);
        $oferta->fill($request->all());
        $oferta->save();

        $url = 'oferta/'.$id;
        return redirect($url)->with('msj', 'Los datos de su oferta han sido actualizados con éxito.');
    }

    //Cambia el status de una oferta
    public function cambiar_status(Request $request, $id){
        Oferta::find($id)
            ->update(['status' => $request->status]);

        return redirect("oferta/".$id)->with('msj', 'El status de su oferta ha sido actualizado con éxito.');
    }

    public function destroy($id)
    {

    }
}
