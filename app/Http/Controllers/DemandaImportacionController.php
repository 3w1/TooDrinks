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
        $cont = 0;

        $demandasImportadores = Demanda_Importador::where('productor_id', '=', session('perfilId'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('demandaImportacion.index')->with(compact('demandasImportadores', 'cont'));
    }

    public function demandas_disponibles(){
        if (session('perfilTipo') == 'I'){
            $pais_origen = DB::table('importador')
                            ->where('id', '=', session('perfilId'))
                            ->select('pais_id')
                            ->get()
                            ->first();

            $demandasImportadores = DB::table('demanda_importador')
                                        ->orderBy('created_at', 'DESC')
                                        ->where('pais_id', '=', $pais_origen->pais_id)
                                        ->where('status', '=', '1')
                                        ->paginate(10);
        }

        return view('demandaImportacion.demandasDisponibles')->with(compact('demandasImportadores'));
    }

    public function create()
    {
        $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->where('productor_id', '=', session('perfilId'))
                    ->pluck('nombre', 'id');

        $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->where('id', '<>', $pais_origen->pais_id)
                    ->pluck('pais', 'id');

        return view('demandaImportacion.create')->with(compact('marcas', 'paises'));
    }

    public function store(Request $request)
    {
        $demanda_importador  = new Demanda_Importador($request->all());
        $demanda_importador ->save();

        return redirect('demanda-importador')->with('msj', 'Su solicitud de importador ha sido creada exitosamente');    
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $demandaImportador = Demanda_Importador::find($id);
        
        $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->where('id', '<>', $pais_origen->pais_id)
                        ->pluck('pais', 'id');

        return view('demandaImportacion.edit')->with(compact('demandaImportador','marcas', 'paises'));
    }

    public function update(Request $request, $id)
    {
        $demanda_importador = Demanda_Importador::find($id);
        $demanda_importador->fill($request->all());
        $demanda_importador->save();

        return redirect('demanda-importador')->with('msj', 'Los datos de su demanda se han actualizado exitosamente');
    }

    public function destroy($id)
    {
       
    }
}
