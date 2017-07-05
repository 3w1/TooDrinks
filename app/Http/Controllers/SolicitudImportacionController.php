<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Importacion;

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
        $solicitudImportacion =new Solicitud_Importacion($request->all());
        $solicitudImportacion->save();

        return redirect('solicitar-importacion')->with('msj', 'Su solicitud ha sido creada exitosamente. Debe esperar la aprobación del Productor');
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
}
