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
        $demandaImportadores = Demanda_Importador::paginate(1);
        return view('demandaImportacion.index')->with(compact('demandaImportadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('demandaImportacion.create')->with(compact('productos','paises','provincias')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $demanda_importador  = new Demanda_Importador($request->all());
        $demanda_importador ->save();

        $url = 'productor/'.session('productorId');
        return redirect($url)->with('msj', 'Su solicitud de importador ha sido creada exitosamente');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $demandaImportador = Demanda_Importador::find($id);
        
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('demandaImportacion.edit')->with(compact('demandaImportador','productos', 'paises', 'provincias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $demanda_importador = Demanda_Importador::find($id);
        $demanda_importador->fill($request->all());
        $demanda_importador->save();

        return redirect()->action('DemandaImportacionController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $demanda_importador  = Demanda_Importador::find($id);
        $demanda_importador ->delete();

        return redirect()->action('DemandaImportacionController@index');
    }
}
