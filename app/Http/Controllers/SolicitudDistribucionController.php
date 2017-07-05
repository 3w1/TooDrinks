<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud_Distribucion;

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
        $solicitudDistribucion =new Solicitud_Distribucion($request->all());
        $solicitudDistribucion->save();

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
}
