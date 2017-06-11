<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Importador;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use DB;

class DemandaImportacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $demanda_importador  = new Demanda_Importador($request->all());
        $demanda_importador ->save();

        $url = 'productor/'.session('productorId');
        return redirect($url)->with('msj', 'Su solicitud de importador ha sido creada exitosamente');    
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        $demanda_importador = Demanda_Importador::find($id);
        $demanda_importador->fill($request->all());
        $demanda_importador->save();

        return redirect('productor/mis-demandas-importadores')->with('msj', 'Los datos de su demanda se han actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
}
