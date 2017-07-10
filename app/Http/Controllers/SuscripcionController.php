<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suscripcion;
use DB;


class SuscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $suscripciones = DB::table('suscripcion')
                        ->orderBy('precio')
                        ->paginate(6);

        if ( session('perfilTipo') == 'AD' ){
            return view('adminWeb.listados.suscripciones')->with(compact('suscripciones'));
        }else{
            return view('suscripcion.index')->with(compact('suscripciones'));
        }
    }

    public function create()
    {
        return view('suscripcion.create');
    }

    public function store(Request $request)
    {
        $suscripcion = new Suscripcion($request->all());
        $suscripcion->save();

        return redirect('suscripcion')->with('msj', 'La nueva suscripción ha sido creada exitosamente');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $suscripcion = Suscripcion::find($id);
        return view('suscripcion.edit')->with(compact('suscripcion'));
    }

    public function update(Request $request, $id)
    {
        $suscripcion = Suscripcion::find($id);
        $suscripcion->fill($request->all());
        $suscripcion->save();

        return redirect('suscripcion')->with('msj', 'La suscripción ha sido modificada exitosamente');
    }

    public function destroy($id)
    {
        
    }
}
