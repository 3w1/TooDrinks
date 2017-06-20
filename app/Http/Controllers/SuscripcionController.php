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
        //$suscripciones = Suscripcion::paginate(2);
        //
        $suscripciones = DB::table('suscripcion')
                        ->orderBy('precio')
                        ->get();
                        
        return view('suscripcion.index')->with(compact('suscripciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suscripcion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $suscripcion = new Suscripcion($request->all());
        $suscripcion->save();

        return redirect()->action('SuscripcionController@index');
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
        $suscripcion = Suscripcion::find($id);
        return view('suscripcion.edit')->with(compact('suscripcion'));
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
        $suscripcion = Suscripcion::find($id);
        $suscripcion->fill($request->all());
        $suscripcion->save();

        return redirect()->action('SuscripcionController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suscripcion = Suscripcion::find($id);
        $suscripcion->delete();

        return redirect()->action('SuscripcionController@index');
    }
}
