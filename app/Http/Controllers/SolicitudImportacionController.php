<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Importacion;
use App\Models\Notificacion_P;
use DB;

class SolicitudImportacionController extends Controller
{
    public function index()
    {
        $cont = 0;

        $solicitudesImportacion = Solicitud_Importacion::where('importador_id', '=', session('perfilId'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('solicitudImportacion.index')->with(compact('solicitudesImportacion', 'cont'));
    }

    public function create()
    {
    	$bebidas = DB::table('bebida')
    				->orderBy('nombre', 'ASC')
    				->pluck('nombre', 'id'); 

    	$paises = DB::table('pais')
    				->orderBy('pais', 'ASC')
    				->pluck('pais', 'id'); 

        return view('solicitudImportacion.create')->with(compact('bebidas', 'paises'));
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();
        $solicitudImportacion =new Solicitud_Importacion($request->all());
        $solicitudImportacion->fecha = $fecha;
        $solicitudImportacion->save();

        $ult_solicitud = DB::table('solicitud_importacion')
                            ->select('id')
                            ->orderBy('created_at', 'DESC')
                            ->first();

        $notificaciones_productor = new Notificacion_P();
        $notificaciones_productor->creador_id = session('perfilId');
        $notificaciones_productor->tipo_creador = session('perfilTipo');

        if ($request->producto_id == '0'){
            $productor = DB::table('marca')
                    ->select('marca.nombre', 'productor.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->where('marca.id', '=', $request->marca_id)
                    ->first();

            $notificaciones_productor->titulo = 'Estan solicitando la importación de tu marca '. $productor->nombre;
        }else{
            $productor = DB::table('producto')
                        ->select('productor.id', 'producto.nombre')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('producto.id', '=', $request->producto_id )
                        ->first();

            $notificaciones_productor->titulo = 'Estan solicitando la importación de tu producto '. $productor->nombre;
        }

        //NOTIFICAR AL PRODUCTOR
        $notificaciones_productor->url='solicitud-importacion/'.$ult_solicitud->id;
        $notificaciones_productor->descripcion = 'Nueva Solicitud de Importación';
        $notificaciones_productor->color = 'bg-orange';
        $notificaciones_productor->icono = 'fa fa-user-plus';
        $notificaciones_productor->tipo ='SI';
        $notificaciones_productor->productor_id = $productor->id;
        $notificaciones_productor->fecha = $fecha;
        $notificaciones_productor->leida = '0';
        $notificaciones_productor->save();
        // *** //
        
        return redirect('solicitud-importacion')->with('msj', 'Su solicitud ha sido almacenada con éxito.');
    }

    public function show($id)
    {
        $demandaMarcada = DB::table('productor_solicitud_importacion')
                            ->where('productor_id', '=', session('perfilId'))
                            ->where('solicitud_importacion_id', '=', $id)
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
            
            return redirect('solicitud-importacion/'.$id)->with('msj', 'Se ha agregado la Demanda de Importación a su sección de "Demandas De Interés"');
        }

        return redirect('solicitud-importacion/solicitudes-importacion')->with('msj', 'Se ha eliminado la demanda de importación de los listados.');
    }

    public function demandas_interes(){
        $demandas = Solicitud_Importacion::select('solicitud_importacion.*')
                        ->join('productor_solicitud_importacion', 'solicitud_importacion.id', '=', 'productor_solicitud_importacion.solicitud_importacion_id')
                        ->where('productor_solicitud_importacion.productor_id', '=', session('perfilId'))
                        ->where('productor_solicitud_importacion.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);    

        return view('solicitudImportacion.demandasDeInteres')->with(compact('demandas'));
    }

    public function edit($id)
    {
      
    }

    public function update(Request $request, $id)
    {
        
    }

     //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Solicitud_Importacion::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("solicitud-importacion")->with('msj', 'El status de su demanda ha sido actualizado con éxito.');
    }

    public function destroy($id)
    {
        //
    }

    public function solicitudes_importacion(){
        $notificaciones_pendientes_SI = DB::table('notificacion_p')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'SI')
                                        ->get();

        foreach ($notificaciones_pendientes_SI as $notificacion){
            $act = DB::table('notificacion_p')
                    ->where('id', '=', $notificacion->id)
                    ->update(['leida' => '1']);
        }

        $demandasImportacion = Solicitud_Importacion::select('solicitud_importacion.*')
                                ->join('marca', 'solicitud_importacion.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_importacion.status', '=', '1')
                                ->orderBy('solicitud_importacion.created_at', 'DESC')
                                ->paginate(8);

        return view('solicitudImportacion.solicitudesDisponibles')->with(compact('demandasImportacion'));
    }
}
