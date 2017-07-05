<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opinion;
use App\Models\User;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use DB;


class OpinionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

        $opiniones = Opinion::paginate(1);
        return view('opinion.index')->with(compact('opiniones'));
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

        return view('opinion.create')->with(compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $opinion = new Opinion($request->all());
        $opinion->tipo_creador = session('perfilTipo');
        $opinion->creador_id = session('perfilId');
        $opinion->valoracion = '5';
        $opinion->fecha = new \DateTime();
        $opinion->editada = '0';
        $opinion->save();

        return redirect('producto/detalle-de-producto/'.$request->producto_id)->with('msj', 'Su comentario ha sido almacenado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();
       
        $opinion = Opinion::find($id);


        return view('opinion.edit')->with(compact('opinion', 'productos'));
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
        
        $opinion = Opinion::find($id);
        $opinion->fill($request->all());
        $opinion->save();

        return redirect()->action('OpinionController@index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $opinion = Opinion::find($id);
        $opinion->delete();

        return redirect()->action('OpinionController@index');

    }
}
