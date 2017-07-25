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

    public function create()
    {
        return view('solicitudDistribucion.create');
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();
        $solicitudDistribucion =new Solicitud_Distribucion($request->all());
        $solicitudDistribucion->fecha = $fecha;
        $solicitudDistribucion->save();

        $ult_solicitud = DB::table('solicitud_distribucion')
                            ->select('id')
                            ->orderBy('created_at', 'DESC')
                            ->first();

        $productor = DB::table('producto')
                        ->select('productor.id', 'productor.pais_id', 'producto.nombre', 'producto.marca_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('producto.id', '=', $request->producto_id )
                        ->first();

        if ($productor->pais_id == session('perfilPais')){
            //NOTIFICAR AL PRODUCTOR
            $notificaciones_productor = new Notificacion_P();
            $notificaciones_productor->creador_id = session('perfilId');
            $notificaciones_productor->tipo_creador = session('perfilTipo');
            $notificaciones_productor->titulo = 'Estan solicitando la distribucion de tu producto '. $productor->nombre;
            $notificaciones_productor->url='solicitar-distribucion/'.$ult_solicitud->id;
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
            $importadores = DB::table('importador_marca')
                                ->select('importador_marca.importador_id')
                                ->join('importador', 'importador_marca.importador_id', '=', 'importador.id')
                                ->where('importador_marca.marca_id', '=', $productor->marca_id)
                                ->where('importador.pais_id', '=', session('perfilPais'))
                                ->get();

            $cont = 0;
            foreach ($importadores as $importador){
                $cont++;
            }

            if ($cont > 0){
                foreach ($importadores as $importador){
                    $notificaciones_importador = new Notificacion_I();
                    $notificaciones_importador->creador_id = session('perfilId');
                    $notificaciones_importador->tipo_creador = session('perfilTipo');
                    $notificaciones_importador->titulo = 'Estan demandando la distribución de un producto que tu importas: '. $productor->nombre;
                    $notificaciones_importador->url='solicitar-distribucion/'.$ult_solicitud->id;
                    $notificaciones_importador->importador_id = $importador->importador_id;
                    $notificaciones_importador->descripcion = 'Solicitud de Distribución';
                    $notificaciones_importador->color = 'bg-green';
                    $notificaciones_importador->icono = 'fa fa-user-plus';
                    $notificaciones_importador->fecha = $fecha;
                    $notificaciones_importador->tipo = 'SD';
                    $notificaciones_importador->leida = '0';
                    $notificaciones_importador->save();
                }
            }else{
               //NOTIFICAR AL PRODUCTOR
                $notificaciones_productor = new Notificacion_P();
                $notificaciones_productor->creador_id = session('perfilId');
                $notificaciones_productor->tipo_creador = session('perfilTipo');
                $notificaciones_productor->titulo = 'Estan solicitando la distribucion de tu producto '. $productor->nombre;
                $notificaciones_productor->url='solicitar-distribucion/'.$ult_solicitud->id;
                $notificaciones_productor->descripcion = 'Nueva Solicitud de Distribucion';
                $notificaciones_productor->color = 'bg-green';
                $notificaciones_productor->icono = 'fa fa-user-plus';
                $notificaciones_productor->tipo ='SD';
                $notificaciones_productor->productor_id = $productor->id;
                $notificaciones_productor->fecha = $fecha;
                $notificaciones_productor->leida = '0';
                $notificaciones_productor->save();
                // *** //
            }
        }
        return redirect('solicitar-distribucion')->with('msj', 'Su solicitud ha sido creada exitosamente. Debe esperar la aprobación del Productor / Importador');
    }

    public function show($id)
    {
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

    //Marca una solicitud de distribución "de interes" para el productor o importador loggeado
    public function marcar_solicitud($id){
        $fecha = new \DateTime();

        $demanda = Solicitud_Distribucion::find($id);
      
        //Asociar productor a la solicitud
        if (session('perfilTipo') == 'P'){
             DB::table('productor_solicitud_distribucion')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'solicitud_distribucion_id' => $id, 'fecha' => $fecha]);    
        }else{
             DB::table('importador_solicitud_distribucion')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'solicitud_distribucion_id' => $id, 'fecha' => $fecha]);    
        }
        // ... //
        
        //Aumentar el contador de contactos de la demanda
        DB::table('solicitud_distribucion')
        ->where('id', '=', $id)
        ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
        // ... //

        return redirect('solicitar-distribucion/'.$id)->with('msj', 'Se ha agregado la Demanda de Distribución a su sección de "Demandas De Interés"');
    }

    public function demandas_interes(){
        if (session('perfilTipo') == 'P'){
            $demandas = Solicitud_Distribucion::select('solicitud_distribucion.*')
                        ->join('productor_solicitud_distribucion', 'solicitud_distribucion.id', '=', 'productor_solicitud_distribucion.solicitud_distribucion_id')
                        ->where('productor_solicitud_distribucion.productor_id', '=', session('perfilId'))
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10); 
        }elseif (session('perfilTipo') == 'I'){
            $demandas = Solicitud_Distribucion::select('solicitud_distribucion.*')
                        ->join('importador_solicitud_distribucion', 'solicitud_distribucion.id', '=', 'importador_solicitud_distribucion.solicitud_distribucion_id')
                        ->where('importador_solicitud_distribucion.importador_id', '=', session('perfilId'))
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);  
        }
        return view('solicitudDistribucion.demandasDeInteres')->with(compact('demandas'));
    }


    public function edit($id)
    {
        $solicitudDistribucion = Solicitud_Distribucion::find($id);

        return view('solicitudDistribucion.edit')->with(compact('solicitudDistribucion'));
    }

    public function update(Request $request, $id)
    {
        $solicitudDistribucion = Solicitud_Distribucion::find($id);
        $solicitudDistribucion->fill($request->all());
        $solicitudDistribucion->save();

        return redirect('solicitar-distribucion')->with('msj', 'El status de su solicitud se ha actualizado exitosamente');
    }

    public function destroy($id)
    {
        //
    }

    public function demandas_distribucion(){
        if (session('perfilTipo') == 'P'){
            $notificaciones_pendientes_SD = DB::table('notificacion_p')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'SD')
                                        ->get();

            foreach ($notificaciones_pendientes_SD as $notificacion){
                $act = DB::table('notificacion_p')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }

            $demandasDistribucion = DB::table('solicitud_distribucion')
                                ->select('solicitud_distribucion.*', 'producto.nombre')
                                ->join('producto', 'solicitud_distribucion.producto_id', '=', 'producto.id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_distribucion.status', '=', '1')
                                ->paginate(8);
        }elseif (session('perfilTipo') == 'I'){
            $notificaciones_pendientes_SD = DB::table('notificacion_i')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'SD')
                                        ->get();

            foreach ($notificaciones_pendientes_SD as $notificacion){
                $act = DB::table('notificacion_i')
                        ->where('id', '=', $notificacion->id)
                        ->update(['leida' => '1']);
            }
            $demandasDistribucion = DB::table('solicitud_distribucion')
                                ->select('solicitud_distribucion.*', 'producto.nombre')
                                ->join('producto', 'solicitud_distribucion.producto_id', '=', 'producto.id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                                ->where('importador_marca.importador_id', '=', session('perfilId'))
                                ->where('solicitud_distribucion.status', '=', '1')
                                ->paginate(8);
        }
        
        return view('solicitudDistribucion.solicitudesDisponibles')->with(compact('demandasDistribucion'));
    }
}
