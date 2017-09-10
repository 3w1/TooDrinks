<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Importacion; use App\Models\Notificacion_P;
use App\Models\Marca; use App\Models\Bebida;
use DB;

class SolicitudImportacionController extends Controller{
   
    //Pestaña Importador / Importación / Mis Búsquedas Activas
    public function index(Request $request){
        $solicitudesImportacion = Solicitud_Importacion::where('importador_id', '=', session('perfilId'))
                                    ->where('status', '=', '1')
                                    ->tipo($request->get('tipo'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(20);
        $cont = 0;
        foreach ($solicitudesImportacion as $s){
            $cont++;
        }

        return view('importacion.tabs.busquedasActivas')->with(compact('solicitudesImportacion', 'cont'));
    }

    //Cambia el status de una demanda (Entidad Creadora)
    public function cambiar_status(Request $request){
        Solicitud_Importacion::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("solicitud-importacion")->with('msj', 'El status de su solicitud ha sido actualizado con éxito. Ahora puede visualizarla en su historial de solicitudes.');
    }

    //Pestaña Importador / Importación / Solicitar Marca
    public function create(Request $request){
        $marcas = Marca::select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('perfilId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->where('marca.id', '<>', '0')
                    ->where('publicada', '=', '1')
                    ->nombre($request->get('busqueda'))
                    ->orderBy('nombre', 'ASC')
                    ->paginate(9);

        $cont =0;
        foreach ($marcas as $m){
            $cont++;
        }

        return view('importacion.tabs.solicitarMarca')->with(compact('marcas', 'cont'));
    }

    public function store(Request $request){
        $fecha = new \DateTime();

        $solicitudImportacion =new Solicitud_Importacion($request->all());
        $solicitudImportacion->fecha = $fecha;
        $solicitudImportacion->save();

        $ult_solicitud = DB::table('solicitud_importacion')
                            ->select('id')
                            ->orderBy('created_at', 'DESC')
                            ->first();
        
        $productor = DB::table('marca')
                    ->select('marca.nombre', 'productor.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->where('marca.id', '=', $request->marca_id)
                    ->first();

        //NOTIFICAR AL PRODUCTOR
        $notificacion_productor = new Notificacion_P();
        $notificacion_productor->creador_id = session('perfilId');
        $notificacion_productor->tipo_creador = session('perfilTipo');
        $notificacion_productor->titulo = 'Estan solicitando la importación de tu marca '. $productor->nombre;
        $notificacion_productor->url='solicitud-importacion/'.$ult_solicitud->id;
        $notificacion_productor->descripcion = 'Nueva Solicitud de Importación';
        $notificacion_productor->color = 'bg-orange';
        $notificacion_productor->icono = 'fa fa-user-plus';
        $notificacion_productor->tipo ='SI';
        $notificacion_productor->productor_id = $productor->id;
        $notificacion_productor->fecha = $fecha;
        $notificacion_productor->leida = '0';
        $notificacion_productor->save();
        // *** //*/
        
        return redirect('solicitud-importacion')->with('msj', 'Su solicitud ha sido almacenada con éxito.');
    }

    //Pestaña Importador / Importación / Solicitar Bebida
    public function solicitar_bebida(Request $request){
        $bebidas = Bebida::select('bebida.*')
                    ->nombre($request->get('busqueda'))
                    ->orderBy('nombre', 'ASC')
                    ->paginate(20);

        $cont =0;
        foreach ($bebidas as $b){
            $cont++;
        }

        return view('importacion.tabs.solicitarBebida')->with(compact('bebidas', 'cont'));
    }

    public function guardar_solicitud_bebida($id){
        $fecha = new \DateTime();

        $solicitudImportacion =new Solicitud_Importacion();
        $solicitudImportacion->importador_id = session('perfilId');
        $solicitudImportacion->bebida_id = $id;
        $solicitudImportacion->pais_id = session('perfilPais');
        $solicitudImportacion->status = '1';
        $solicitudImportacion->fecha = $fecha;
        $solicitudImportacion->cantidad_visitas = 0;
        $solicitudImportacion->cantidad_contactos = 0;
        $solicitudImportacion->save();

        //Enviar notificaciones
        /*$productor = DB::table('bebida')
                        ->select('productor.id', 'bebida.nombre')
                        ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('bebida.id', '=', $request->bebida_id)
                        ->groupBy('producto.bebida_id')
                        ->get();*/

        return redirect('solicitud-importacion')->with('msj', 'Su solicitud ha sido almacenada con éxito.');
    }

    //Pestaña Importador / Importación / Historial de Búsquedas
    public function historial_solicitudes(Request $request){
        $solicitudesImportacion = Solicitud_Importacion::where('importador_id', '=', session('perfilId'))
                                    ->where('status', '=', '0')
                                    ->tipo($request->get('tipo'))
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(20);
        $cont = 0;
        foreach ($solicitudesImportacion as $s){
            $cont++;
        }

        return view('importacion.tabs.historial')->with(compact('solicitudesImportacion', 'cont'));
    }

    //Pestaña Importación (Solicitudes / Productor)
    public function solicitudes_importacion(Request $request){
        $demandasImportacion = Solicitud_Importacion::select('solicitud_importacion.id')
                                ->join('marca', 'solicitud_importacion.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_importacion.status', '=', '1')
                                ->orderBy('solicitud_importacion.created_at', 'DESC')
                                ->paginate(8);

        if ($request->get('tipo') == 'B'){
            $demandasImportacion = Solicitud_Importacion::select('solicitud_importacion.id')
                                ->join('bebida', 'solicitud_importacion.bebida_id', '=', 'bebida.id')
                                ->join('producto', 'bebida.id', '=', 'producto.bebida_id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_importacion.status', '=', '1')
                                ->groupBy('solicitud_importacion.id', 'producto.bebida_id')
                                ->orderBy('solicitud_importacion.created_at', 'DESC')
                                ->paginate(8);
        }

        $cont = 0;
        foreach ($demandasImportacion as $di){
            $relacion = DB::table('productor_solicitud_importacion')
                        ->select('id')
                        ->where('solicitud_importacion_id', '=', $di->id)
                        ->where('productor_id', '=', session('perfilId'))
                        ->first();

            if ($relacion == null){
                $cont++;
            }
        }

        return view('solicitudes.tabs.importacion')->with(compact('demandasImportacion', 'cont'));
    }

    //Detalles de una solicitud de importación (Entidad que visita)
    public function show($id){
        $demandaMarcada = DB::table('productor_solicitud_importacion')
                            ->where('solicitud_importacion_id', '=', $id)
                            ->where('productor_id', '=', session('perfilId'))
                            ->first();

        if ($demandaMarcada == null){
            $restringido = '1';
        }else{
            $restringido = '0';
        }
        
        $demandaImportacion = Solicitud_Importacion::find($id);

        $visitas = $demandaImportacion->cantidad_visitas + 1;

        $act = DB::table('solicitud_importacion')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $demandaImportacion->cantidad_visitas = $visitas;

        return view('solicitudImportacion.show')->with(compact('demandaImportacion', 'restringido'));
    }

    //Marca una solicitud de importación "de interes" o "no me interesa" para entidades con Suscripción
    public function marcar_solicitud($id, $check){
        $fecha = new \DateTime();

        $demanda = Solicitud_Importacion::find($id);
      
        //Asociar productor a la solicitud
        DB::table('productor_solicitud_importacion')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'solicitud_importacion_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        // ... //
        
        if ($check == '1'){
            //Aumentar el contador de contactos de la demanda
            DB::table('solicitud_importacion')
            ->where('id', '=', $id)
            ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
            // ... //
            
            return redirect('solicitud-importacion/'.$id)->with('msj', 'Se ha agregado la solicitude de importación a su historial de solicitudes."');
        }

        return redirect('solicitud-importacion/solicitudes-importacion')->with('msj', 'Se ha eliminado la solicitud de importación de los listados.');
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
