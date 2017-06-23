<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Distribuidor;
use App\Models\Producto;
use App\Models\Pais; use App\Models\Provincia_Region;
use DB;

class DemandaDistribucionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cont = 0;

        $demandasDistribuidores = Demanda_Distribuidor::where([ 
                                        ['tipo_creador', '=', session('perfilTipo')], 
                                        ['creador_id', '=', session('perfilId')], 
                                    ])
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('demandaDistribucion.index')->with(compact('demandasDistribuidores', 'cont'));
    }

    public function demandas_disponibles(){
        $provincia_origen = DB::table('distribuidor')
                        ->where('id', '=', session('perfilId'))
                        ->select('provincia_region_id')
                        ->get()
                        ->first();

        $demandasDistribuidores = DB::table('demanda_distribuidor')
                                    ->orderBy('created_at', 'DESC')
                                    ->where('provincia_region_id', '=', $provincia_origen->provincia_region_id)
                                    ->where('status', '=', '1')
                                    ->paginate(10);

        return view('demandaDistribucion.demandasDisponibles')->with(compact('demandasDistribuidores'));
    }


    public function create()
    {   
        if (session('perfilTipo') == 'P'){
            $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

            $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
        }else{
            $pais_origen = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('perfilId'))
                            ->get()
                            ->first();

            $marcas = DB::table('marca')
                        ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->pluck('marca.nombre', 'marca.id');
        }
       
        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_origen->pais_id)
                        ->pluck('provincia', 'id');

        return view('demandaDistribucion.create')->with(compact('marcas', 'provincias'));
    }

    public function store(Request $request)
    {
        $demanda_distribuidor  = new Demanda_Distribuidor($request->all());
        $demanda_distribuidor ->save();

        return redirect('demanda-distribuidor')->with('msj', 'Su demanda de distribuidor ha sido creada exitosamente');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $demandaDistribuidor = Demanda_Distribuidor::find($id);

        if (session('perfilTipo') == 'P'){
            $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

            $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
        }else{
            $pais_origen = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('perfilId'))
                            ->get()
                            ->first();

            $marcas = DB::table('marca')
                        ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->pluck('marca.nombre', 'marca.id');
        }

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_origen->pais_id)
                        ->pluck('provincia', 'id');

        return view('demandaDistribucion.edit')->with(compact('demandaDistribuidor', 'marcas', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $demanda_distribuidor = Demanda_Distribuidor::find($id);
       	$demanda_distribuidor->fill($request->all());
        $demanda_distribuidor->save();

        return redirect('demanda-distribuidor')->with('msj', 'Los datos de su demanda de distribución han sido actualizados exitosamente');
    }

    public function destroy($id)
    {

    }
}
