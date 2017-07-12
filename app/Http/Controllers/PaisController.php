<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Pais;
use App\Models\Productor;
use DB; use Mail; use Session; use Redirect;

class PaisController extends Controller
{

    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estados= DB::table('provincia_region')
                    ->orderBy('provincia', 'ASC')
                    ->select('id', 'provincia')
                    ->where('pais_id', '=', $id)
                    ->get();

        return response()->json(
            $estados->toArray()
        );
    }

    public function edit($id)
    {
        
    }

    public function paises_destino(){
        $paises_elegidos = DB::table('productor_pais')
                            ->select('pais_id')
                            ->where('productor_id', '=', session('perfilId'))
                            ->get();

        return response()->json(
            $paises_elegidos->toArray()
        );
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
