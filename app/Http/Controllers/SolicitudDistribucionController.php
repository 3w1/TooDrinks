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

        $productor = DB::table('producto')
                        ->select('productor.id', 'productor.pais_id', 'producto.nombre', 'producto.marca_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('producto.id', '=', $request->producto_id )
                        ->first();

        if ($productor->pais_id == session('perfilPais')){
            //Notificar al productor
            $url = 'notificacion/notificar-productor/SD/'.$productor->nombre.'/'.$productor->id;
            return redirect($url);
            // ... //
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
                    $notificaciones_importador->url='importador/solicitudes-distribucion';
                    $notificaciones_importador->importador_id = $importador->importador_id;
                    $notificaciones_importador->descripcion = 'Solicitud de Distribución';
                    $notificaciones_importador->color = 'bg-green';
                    $notificaciones_importador->icono = 'fa fa-user-plus';
                    $notificaciones_importador->fecha = $fecha;
                    $notificaciones_importador->tipo = 'SI';
                    $notificaciones_importador->leida = '0';
                    $notificaciones_importador->save();
                }
            }else{
               //Notificar al productor
                $url = 'notificacion/notificar-productor/SD/'.$productor->nombre.'/'.$productor->id;
                return redirect($url);
                // ... //
            }
        }

        return redirect('solicitar-distribucion')->with('msj', 'Su solicitud ha sido creada exitosamente. Debe esperar la aprobación del Productor / Importador');
    }

    public function show($id)
    {
        //
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
            $demandasDistribucion = DB::table('solicitud_distribucion')
                                ->select('solicitud_distribucion.*', 'producto.nombre')
                                ->join('producto', 'solicitud_distribucion.producto_id', '=', 'producto.id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_distribucion.status', '=', '1')
                                ->paginate(8);
        }elseif (session('perfilTipo') == 'I'){
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
