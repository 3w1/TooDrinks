<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Distribucion; use App\Models\Marca; use App\Models\Bebida;
use App\Models\Notificacion_P; use App\Models\Notificacion_I;
use DB;

class SolicitudDistribucionController extends Controller
{
    //Pestaña Distribuidor / Distribucón / Mis Búsquedas Activas
    public function index(Request $request){
        $solicitudesDistribucion = Solicitud_Distribucion::where('distribuidor_id', '=', session('perfilId'))
                                    ->where('status', '=', '1')
                                    ->tipo($request->get('tipo'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(20);
        $cont = 0;
        foreach ($solicitudesDistribucion as $s){
            $cont++;
        }

        return view('distribucion.tabsDistribuidor.busquedasActivas')->with(compact('solicitudesDistribucion', 'cont'));
    }

    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Solicitud_Distribucion::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("solicitud-distribucion")->with('msj', 'El status de su demanda ha sido actualizado con éxito. Ahora puede visualizarla en su historial.');
    }

    //Pestaña Distribuidor / Distribución / Nueva Búsqueda
     public function create(Request $request){
        $marcas = Marca::select('marca.*')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '!=', session('perfilId'))
                    ->orwhere('distribuidor_marca.marca_id', '=', null)
                    ->where('marca.id', '<>', '0')
                    ->where('publicada', '=', '1')
                    ->nombre($request->get('busqueda'))
                    ->orderBy('nombre', 'ASC')
                    ->paginate(9);

        $cont =0;
        foreach ($marcas as $m){
            $cont++;
        }

        return view('distribucion.tabsDistribuidor.solicitarMarca')->with(compact('marcas', 'cont'));
    }

    //Pestaña Distribuidor / Distribución / Solicitar Bebida
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

        return view('distribucion.tabsDistribuidor.solicitarBebida')->with(compact('bebidas', 'cont', 'tipos_bebidas', 'paises', 'pais_elegido'));
    }

    public function store(Request $request){
        $fecha = new \DateTime();
        
        $solicitudDistribucion =new Solicitud_Distribucion($request->all());
        $solicitudDistribucion->fecha = $fecha;
        $solicitudDistribucion->save();

        $ult_solicitud = DB::table('solicitud_distribucion')
                            ->select('id')
                            ->orderBy('created_at', 'DESC')
                            ->first();

        if ($request->marca_id != null){
            $marca = Marca::select('id', 'nombre', 'productor_id')
                ->where('id', '=', $request->marca_id)
                ->first();

            $importadores = DB::table('importador')
                    ->select('importador.id')
                    ->join('importador_marca', 'importador.id', '=', 'importador_marca.importador_id')
                    ->where('importador_marca.marca_id', '=', $request->marca_id)
                    ->where('importador_marca.status', '=', '1')
                    ->where('importador.pais_id', '=', session('perfilPais'))
                    ->get();

            $cont=0;
            foreach ($importadores as $i){
                $cont++;
            }

            if ($cont > 0){
                foreach ($importadores as $imp){
                    //NOTIFICAR A LOS IMPORTADORES QUE TENGAN LA MARCA EN EL PAÍS DEL DISTRIBUIDOR
                    $notificacion_importador = new Notificacion_I();
                    $notificacion_importador->creador_id = session('perfilId');
                    $notificacion_importador->tipo_creador = session('perfilTipo');
                    $notificacion_importador->titulo = 'Estan solicitando la importación de la marca '.$marca->nombre.' que tu posees.';
                    $notificacion_importador->url= 'solicitud-distribucion/'.$ult_solicitud->id;
                    $notificacion_importador->descripcion = 'Nueva Solicitud de Distribución';
                    $notificacion_importador->color = 'bg-yellow';
                    $notificacion_importador->icono = 'fa fa-user-plus';
                    $notificacion_importador->tipo ='SD';
                    $notificacion_importador->importador_id = $imp->id;
                    $notificacion_importador->fecha = new \DateTime();
                    $notificacion_importador->leida = '0';
                    $notificacion_importador->save();
                    // *** //
                }
            }else{
                if ( ($marca->productor_id != '0') && ($marca->productor->pais_id == session('perfilPais')) ){
                    //NOTIFICAR AL PRODUCTOR SI SE ENCUENTRA EN EL MISMO PAÍS
                    $notificacion_productor = new Notificacion_P();
                    $notificacion_productor->creador_id = session('perfilId');
                    $notificacion_productor->tipo_creador = session('perfilTipo');
                    $notificacion_productor->titulo = 'Estan solicitando la importación de tu marca '.$marca->nombre.' que tu posees.';
                    $notificacion_productor->url= 'solicitud-distribucion/'.$ult_solicitud->id;
                    $notificacion_productor->descripcion = 'Nueva Solicitud de Distribución';
                    $notificacion_productor->color = 'bg-yellow';
                    $notificacion_productor->icono = 'fa fa-user-plus';
                    $notificacion_productor->tipo ='SD';
                    $notificacion_productor->importador_id = $marca->productor_id;
                    $notificacion_productor->fecha = new \DateTime();
                    $notificacion_productor->leida = '0';
                    $notificacion_productor->save();
                    // *** //
                }
            }
        }else{
            if ($request->pais_id == null){
                $importadores = DB::table('bebida')
                    ->select('bebida.nombre', 'importador.id')
                    ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                    ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                    ->where('bebida.id', '=', $request->bebida_id)
                    ->where('importador.pais_id', '=', session('perfilPais'))
                    ->groupBy('producto.bebida_id', 'bebida.nombre', 'importador.id')
                    ->get();

                $cont = 0;
                foreach ($importadores as $imp){
                    $cont++;
                }

                if ($cont > 0){
                    foreach ($importadores as $imp){
                        //NOTIFICAR A LOS IMPORTADORES QUE TENGAN LA MARCA EN EL PAÍS DEL DISTRIBUIDOR
                        $notificacion_importador = new Notificacion_I();
                        $notificacion_importador->creador_id = session('perfilId');
                        $notificacion_importador->tipo_creador = session('perfilTipo');
                        $notificacion_importador->titulo = 'Estan solicitando la importación del tipo de bebida '.$imp->nombre.' que tu posees.';
                        $notificacion_importador->url= 'solicitud-distribucion/'.$ult_solicitud->id;
                        $notificacion_importador->descripcion = 'Nueva Solicitud de Distribución';
                        $notificacion_importador->color = 'bg-yellow';
                        $notificacion_importador->icono = 'fa fa-user-plus';
                        $notificacion_importador->tipo ='SD';
                        $notificacion_importador->importador_id = $imp->id;
                        $notificacion_importador->fecha = new \DateTime();
                        $notificacion_importador->leida = '0';
                        $notificacion_importador->save();
                        // *** //
                    }
                }else{
                    $productores = DB::table('bebida')
                        ->select('bebida.nombre', 'productor.id')
                        ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'producto.id')
                        ->where('bebida.id', '=', $request->bebida_id)
                        ->where('productor.id', '<>', '0')
                        ->groupBy('producto.bebida_id', 'bebida.nombre', 'productor.id')
                        ->get();

                    $cont = 0;
                    foreach ($productores as $prod){
                        $cont++;
                    }

                    if ($cont > 0){
                        //NOTIFICAR A LOS IMPORTADORES QUE TENGAN LA MARCA EN EL PAÍS DEL DISTRIBUIDOR
                        $notificacion_productor = new Notificacion_P();
                        $notificacion_productor->creador_id = session('perfilId');
                        $notificacion_productor->tipo_creador = session('perfilTipo');
                        $notificacion_productor->titulo = 'Estan solicitando la importación del tipo de bebida '.$prod->nombre.' que tu posees.';
                        $notificacion_productor->url= 'solicitud-distribucion/'.$ult_solicitud->id;
                        $notificacion_productor->descripcion = 'Nueva Solicitud de Distribución';
                        $notificacion_productor->color = 'bg-yellow';
                        $notificacion_productor->icono = 'fa fa-user-plus';
                        $notificacion_productor->tipo ='SD';
                        $notificacion_productor->productor_id = $prod->id;
                        $notificacion_productor->fecha = new \DateTime();
                        $notificacion_productor->leida = '0';
                        $notificacion_productor->save();
                        // *** //
                    }

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

                $cont = 0;
                foreach ($importadores as $imp){
                    $cont++;
                }

                if ($cont > 0){
                    //NOTIFICAR A LOS IMPORTADORES QUE TENGAN EL TIPO DE BEBIDA 
                    //Y PERTENEZCAN AL PAÍS DEL DISTRIBUIDOR
                    foreach($importadores as $imp){
                        $notificacion_importador = new Notificacion_I();
                        $notificacion_importador->creador_id = session('perfilId');
                        $notificacion_importador->tipo_creador = session('perfilTipo');
                        $notificacion_importador->titulo = 'Estan solicitando la importación del tipo de bebida '.$imp->nombre.' que tu posees.';
                        $notificacion_importador->url= 'solicitud-distribucion/'.$ult_solicitud->id;
                        $notificacion_importador->descripcion = 'Nueva Solicitud de Distribución';
                        $notificacion_importador->color = 'bg-yellow';
                        $notificacion_importador->icono = 'fa fa-user-plus';
                        $notificacion_importador->tipo ='SD';
                        $notificacion_importador->importador_id = $imp->id;
                        $notificacion_importador->fecha = new \DateTime();
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
                        $cont++;
                    }

                    if ($cont > 0){
                        foreach ($productores as $prod){
                            //Notificar a los productores con ese tipo de bebida
                            //En el mismo país del distribuidor
                            $notificacion_productor = new Notificacion_P();
                            $notificacion_productor->creador_id = session('perfilId');
                            $notificacion_productor->tipo_creador = session('perfilTipo');
                            $notificacion_productor->titulo = 'Estan solicitando la importación del tipo de bebida '.$prod->nombre.' que tu posees.';
                            $notificacion_productor->url= 'solicitud-distribucion/'.$ult_solicitud->id;
                            $notificacion_productor->descripcion = 'Nueva Solicitud de Distribución';
                            $notificacion_productor->color = 'bg-yellow';
                            $notificacion_productor->icono = 'fa fa-user-plus';
                            $notificacion_productor->tipo ='SD';
                            $notificacion_productor->productor_id = $prod->id;
                            $notificacion_productor->fecha = new \DateTime();
                            $notificacion_productor->leida = '0';
                            $notificacion_productor->save();
                        }
                    }
                }
            }
        }
        
        return redirect('solicitud-distribucion')->with('msj', 'Su solicitud ha sido almacenada con éxito.');
    }

    //Pestaña Distribuidor / Distribuciónn / Historial de Búsquedas
    public function historial_solicitudes(Request $request){
        $solicitudesDistribucion = Solicitud_Distribucion::where('distribuidor_id', '=', session('perfilId'))
                                    ->where('status', '=', '0')
                                    ->tipo($request->get('tipo'))
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(20);
        $cont = 0;
        foreach ($solicitudesDistribucion as $s){
            $cont++;
        }

        return view('distribucion.tabsDistribuidor.historial')->with(compact('solicitudesDistribucion', 'cont'));
    }

    //Pestaña Productor - Importador / Solicitudes / Distribución
    public function solicitudes_distribucion(Request $request){
        if (session('perfilTipo') == 'P'){
            $demandasDistribucion = Solicitud_Distribucion::select('solicitud_distribucion.id')
                                ->join('marca', 'solicitud_distribucion.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_distribucion.status', '=', '1')
                                ->orderBy('solicitud_distribucion.created_at', 'DESC')
                                ->paginate(8);

            if ($request->get('tipo') == 'B'){
                $demandasDistribucion = Solicitud_Distribucion::select('solicitud_distribucion.id')
                                ->join('bebida', 'solicitud_distribucion.bebida_id', '=', 'bebida.id')
                                ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_distribucion.status', '=', '1')
                                ->groupBy('solicitud_distribucion.id', 'producto.bebida_id')
                                ->orderBy('solicitud_distribucion.created_at', 'DESC')
                                ->paginate(8);
            }

            $cont = 0;
            foreach ($demandasDistribucion as $dd){
                $relacion = DB::table('productor_solicitud_distribucion')
                        ->select('id')
                        ->where('solicitud_distribucion_id', '=', $dd->id)
                        ->where('productor_id', '=', session('perfilId'))
                        ->first();

                if ($relacion == null){
                    $demanda = Solicitud_Distribucion::find($dd->id);

                    if ($demanda->distribuidor->pais_id == session('perfilPais')){
                   		$cont++;
                    }
                }
            }

            return view('solicitudes.tabs.distribucion')->with(compact('demandasDistribucion', 'cont')); 

        }elseif (session('perfilTipo') == 'I'){
            $demandasDistribucion = Solicitud_Distribucion::select('solicitud_distribucion.*')
                                    ->join('marca', 'solicitud_distribucion.marca_id', '=', 'marca.id')
                                    ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                                    ->where('solicitud_distribucion.status', '=', '1')
                                    ->orderBy('solicitud_distribucion.created_at', 'DESC')
                                    ->paginate(7);

            if ($request->get('tipo') == 'B'){
                $demandasDistribucion = Solicitud_Distribucion::select('solicitud_distribucion.id')
                                ->join('bebida', 'solicitud_distribucion.bebida_id', '=', 'bebida.id')
                                ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                                ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                                ->where('importador_producto.importador_id', '=', session('perfilId'))
                                ->where('solicitud_distribucion.status', '=', '1')
                                ->groupBy('solicitud_distribucion.id', 'producto.bebida_id')
                                ->orderBy('solicitud_distribucion.created_at', 'DESC')
                                ->paginate(8);
            }

            $cont = 0;
            foreach ($demandasDistribucion as $dd){
                $relacion = DB::table('importador_solicitud_distribucion')
                        ->select('id')
                        ->where('solicitud_distribucion_id', '=', $dd->id)
                        ->where('importador_id', '=', session('perfilId'))
                        ->first();

                if ($relacion == null){
                    $demanda = Solicitud_Distribucion::find($dd->id);

                    if ($demanda->distribuidor->pais_id == session('perfilPais')){
                   		$cont++;
                    }
                }
            }

            return view('solicitudes.tabsImportador.distribucion')->with(compact('demandasDistribucion', 'cont')); 
        }
    }

    //Productor - Importador / Solicitudes / Distribución / Ver detalles de Solicitud
    public function show($id){
        if (session('perfilTipo') == 'P'){
            $demandaMarcada = DB::table('productor_solicitud_distribucion')
                            ->where('productor_id', '=', session('perfilId'))
                            ->where('solicitud_distribucion_id', '=', $id)
                            ->first();
        }else{
            $demandaMarcada = DB::table('importador_solicitud_distribucion')
                            ->where('importador_id', '=', session('perfilId'))
                            ->where('solicitud_distribucion_id', '=', $id)
                            ->first();
        }
            
        if ($demandaMarcada == null){
            $restringido = '1';
        }else{
            $restringido = '0';
        }
        
        $demandaDistribucion = Solicitud_Distribucion::find($id);

        $visitas = $demandaDistribucion->cantidad_visitas + 1;

        $act = DB::table('solicitud_distribucion')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $demandaDistribucion->cantidad_visitas = $visitas;

        return view('solicitudDistribucion.show')->with(compact('demandaDistribucion', 'restringido'));
    }

    //Marca una solicitud de distribución "de interes" o "no me interesa" para el productor o importador loggeado
    public function marcar_solicitud($id, $check){
        $fecha = new \DateTime();

        $demanda = Solicitud_Distribucion::find($id);
      
        //Asociar productor a la solicitud
        if (session('perfilTipo') == 'P'){
             DB::table('productor_solicitud_distribucion')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'solicitud_distribucion_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        }else{
             DB::table('importador_solicitud_distribucion')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'solicitud_distribucion_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        }
        // ... //
        
        if ($check == '1'){
            //Aumentar el contador de contactos de la demanda
            DB::table('solicitud_distribucion')
            ->where('id', '=', $id)
            ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
            // ... //
            
            return redirect('solicitud-distribucion/'.$id)->with('msj', 'Se ha agregado la solicitud de distribución a su historial de solicitudes."');
        }
        
        return redirect('solicitud-distribucion/solicitudes-distribucion')->with('msj', 'Se ha eliminado la solicitud de distribución de los listados.');
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
    
    }

    public function destroy($id)
    {
        //
    }
}
