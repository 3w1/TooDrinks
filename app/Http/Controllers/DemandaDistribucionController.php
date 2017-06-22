<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Distribuidor;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use DB;

class DemandaDistribucionController extends Controller
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
        $demanda_distribuidor  = new Demanda_Distribuidor($request->all());
        $demanda_distribuidor ->save();

        if ($request->who == 'P'){
            $url = 'productor/mis-demandas-distribuidores';
            return redirect($url)->with('msj', 'Su solicitud de distribuidor ha sido creada exitosamente');    
        }else{
            $url = 'importador/mis-demandas-distribuidores';
            return redirect($url)->with('msj', 'Su solicitud de distribuidor ha sido creada exitosamente');  
        }
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
        $demanda_distribuidor = Demanda_Distribuidor::find($id);
       	$demanda_distribuidor->fill($request->all());
        $demanda_distribuidor->save();

        if ($request->who == 'P'){
            return redirect('productor/mis-demandas-distribuidores')->with('msj', 'Los datos de su demanda se han actualizado exitosamente');
        }else{
            return redirect('importador/mis-demandas-distribuidores')->with('msj', 'Los datos de su demanda se han actualizado exitosamente');
        }
    }

    public function destroy($id)
    {

    }
}
