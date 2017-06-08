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
        $demandaDistribuidores = Demanda_Distribuidor::paginate(1);
        return view('demandaDistribucion.index')->with(compact('demandaDistribuidores'));
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

        return view('demandaDistribucion.create')->with(compact('productos','paises','provincias')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $demanda_distribuidor  = new Demanda_Distribuidor($request->all());
        $demanda_distribuidor ->save();

        if ($request->who == 'P')
            $url = 'productor/'.session('productorId');
            return redirect($url)->with('msj', 'Su solicitud de distribuidor ha sido creada exitosamente');    
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

        $demandaDistribuidor = Demanda_Distribuidor::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        return view('demandaDistribucion.edit')->with(compact('demandaDistribuidor','productos', 'paises', 'provincias'));
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
        $demanda_distribuidor = Demanda_Distribuidor::find($id);
        $demanda_distribuidor->fill($request->all());
        $demanda_distribuidor->save();

        return redirect()->action('DemandaDistribucionController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $demanda_distribuidor  = Demanda_Distribuidor::find($id);
        $demanda_distribuidor ->delete();

        return redirect()->action('DemandaDistribucionController@index');
    }
}
