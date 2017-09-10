<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Distribucion;
use App\Models\Notificacion_P; use App\Models\Notificacion_I;
use DB;

class SolicitudDistribucionController extends Controller
{
    public function index()
    {
        $cont = 0;

        $solicitudesDistribucion = Solicitud_Distribucion::where('distribuidor_id', '=', session('perfilId'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('solicitudDistribucion.index')->with(compact('solicitudesDistribucion', 'cont'));
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
                    $cont++;
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
                    $cont++;
                }
            }

            return view('solicitudes.tabsImportador.distribucion')->with(compact('demandasDistribucion', 'cont')); 
        }
    }

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

    public function create(){
        $bebidas = DB::table('bebida')
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id'); 

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        return view('solicitudDistribucion.create')->with(compact('bebidas', 'paises'));
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

        if ($request->producto_id == '0'){
            $productor = DB::table('marca')
                            ->select('marca.nombre', 'productor.id', 'productor.pais_id')
                            ->join('productor', 'marca.productor_id', '=', 'productor.id')
                            ->where('marca.id', '=', $request->marca_id)
                            ->first();
        }else{
            $productor = DB::table('producto')
                        ->select('productor.id', 'productor.pais_id', 'producto.nombre')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('producto.id', '=', $request->producto_id )
                        ->first();
        }

        if ($productor->pais_id == session('perfilPais')){
            //NOTIFICAR AL PRODUCTOR
            $notificaciones_productor = new Notificacion_P();
            $notificaciones_productor->creador_id = session('perfilId');
            $notificaciones_productor->tipo_creador = session('perfilTipo');
            if ($request->producto_id != '0'){
                $notificaciones_productor->titulo = 'Estan solicitando la distribucion de tu producto '. $productor->nombre;
            }else{
                $notificaciones_productor->titulo = 'Estan solicitando la distribucion de tu marca '. $productor->nombre;
            }
            $notificaciones_productor->url='solicitud-distribucion/'.$ult_solicitud->id;
            $notificaciones_productor->descripcion = 'Nueva Solicitud de Distribucion';
            $notificaciones_productor->color = 'bg-green';
            $notificaciones_productor->icono = 'fa fa-user-plus';
            $notificaciones_productor->tipo ='SD';
            $notificaciones_productor->productor_id = $productor->id;
            $notificaciones_productor->fecha = $fecha;
            $notificaciones_productor->leida = '0';
            $notificaciones_productor->save();
            // *** //
        }else{
            if ($request->producto_id == '0'){
                $importadores = DB::table('importador_marca')
                                ->select('importador_marca.importador_id')
                                ->join('importador', 'importador_marca.importador_id', '=', 'importador.id')
                                ->where('importador_marca.marca_id', '=', $request->marca_id)
                                ->where('importador.pais_id', '=', session('perfilPais'))
                                ->get();
            }else{
                $importadores = DB::table('importador_producto')
                                ->select('importador_producto.importador_id')
                                ->join('importador', 'importador_producto.importador_id', '=', 'importador.id')
                                ->where('importador_producto.producto_id', '=', $request->producto_id)
                                ->where('importador.pais_id', '=', session('perfilPais'))
                                ->get();
            }
           
            $cont = 0;
            foreach ($importadores as $importador){
                $cont++;
            }

            if ($cont > 0){
                foreach ($importadores as $importador){
                    $notificaciones_importador = new Notificacion_I();
                    $notificaciones_importador->creador_id = session('perfilId');
                    $notificaciones_importador->tipo_creador = session('perfilTipo');
                    if ($request->producto_id != '0'){
                        $notificaciones_productor->titulo = 'Estan solicitando la distribucion de tu producto '. $productor->nombre;
                    }else{
                        $notificaciones_productor->titulo = 'Estan solicitando la distribucion de tu marca '. $productor->nombre;
                    }
                    $notificaciones_importador->url='solicitud-distribucion/'.$ult_solicitud->id;
                    $notificaciones_importador->importador_id = $importador->importador_id;
                    $notificaciones_importador->descripcion = 'Solicitud de Distribución';
                    $notificaciones_importador->color = 'bg-green';
                    $notificaciones_importador->icono = 'fa fa-user-plus';
                    $notificaciones_importador->fecha = $fecha;
                    $notificaciones_importador->tipo = 'SD';
                    $notificaciones_importador->leida = '0';
                    $notificaciones_importador->save();
                }
            }
        }
        return redirect('solicitud-distribucion')->with('msj', 'Su solicitud ha sido creada con éxito. Debe esperar la aprobación del Productor / Importador');
    }

    public function demandas_interes(){
        if (session('perfilTipo') == 'P'){
            $demandas = Solicitud_Distribucion::select('solicitud_distribucion.*')
                        ->join('productor_solicitud_distribucion', 'solicitud_distribucion.id', '=', 'productor_solicitud_distribucion.solicitud_distribucion_id')
                        ->where('productor_solicitud_distribucion.productor_id', '=', session('perfilId'))
                        ->where('productor_solicitud_distribucion.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10); 
        }elseif (session('perfilTipo') == 'I'){
            $demandas = Solicitud_Distribucion::select('solicitud_distribucion.*')
                        ->join('importador_solicitud_distribucion', 'solicitud_distribucion.id', '=', 'importador_solicitud_distribucion.solicitud_distribucion_id')
                        ->where('importador_solicitud_distribucion.importador_id', '=', session('perfilId'))
                        ->where('importador_solicitud_distribucion.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);  
        }
        return view('solicitudDistribucion.demandasDeInteres')->with(compact('demandas'));
    }


    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
    
    }

    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Solicitud_Distribucion::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("solicitud-distribucion")->with('msj', 'El status de su demanda ha sido actualizado con éxito.');
    }

    public function destroy($id)
    {
        //
    }
}
