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

    }

    public function create()
    {   
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        return view('opinion.create')->with(compact('productos'));
    }

    public function store(Request $request)
    {
        $opinion = new Opinion($request->all());
        $opinion->tipo_creador = session('perfilTipo');
        $opinion->creador_id = session('perfilId');
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
       
    }

    public function update(Request $request, $id)
    {
        
        $opinion = Opinion::find($id);
        $opinion->fill($request->all());
        $opinion->save();

        return redirect('producto/detalle-de-producto/'.$request->producto_id)->with('msj', 'Su comentario ha sido modificado exitosamente');
        
    }

    public function destroy($id)
    {

    }
}
