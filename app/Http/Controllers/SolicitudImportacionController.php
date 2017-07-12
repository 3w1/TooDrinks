<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Importacion;
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
        return view('solicitudImportacion.create');
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();
        $solicitudImportacion =new Solicitud_Importacion($request->all());
        $solicitudImportacion->fecha = $fecha;
        $solicitudImportacion->save();

        $productor = DB::table('producto')
                        ->select('productor.id', 'producto.nombre')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->join('productor', 'marca.productor_id', '=', 'productor.id')
                        ->where('producto.id', '=', $request->producto_id )
                        ->first();

        //Notificar al productor
        $url = 'notificacion/notificar-productor/SI/'.$productor->nombre.'/'.$productor->id;
        return redirect($url);
        // ... //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $solicitudImportacion = Solicitud_Importacion::find($id);

        return view('solicitudImportacion.edit')->with(compact('solicitudImportacion'));
    }

    public function update(Request $request, $id)
    {
        $solicitudImportacion = Solicitud_Importacion::find($id);
        $solicitudImportacion->fill($request->all());
        $solicitudImportacion->save();

        return redirect('solicitar-importacion')->with('msj', 'El status de su solicitud se ha actualizado exitosamente');
    }

    public function destroy($id)
    {
        //
    }

    public function demandas_importacion(){
        $demandasImportacion = DB::table('solicitud_importacion')
                                ->select('solicitud_importacion.*', 'producto.nombre')
                                ->join('producto', 'solicitud_importacion.producto_id', '=', 'producto.id')
                                ->join('marca', 'producto.marca_id', '=', 'marca.id')
                                ->join('productor', 'marca.productor_id', '=', 'productor.id')
                                ->where('productor.id', '=', session('perfilId'))
                                ->where('solicitud_importacion.status', '=', '1')
                                ->paginate(8);

        return view('solicitudImportacion.solicitudesDisponibles')->with(compact('demandasImportacion'));
    }
}
