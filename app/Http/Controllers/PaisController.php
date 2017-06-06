<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Pais;
use DB; use Mail; use Session; use Redirect;

class PaisController extends Controller
{
    public function index()
    {
        $data['datos'] = "Hola";
        
        Mail::send('emails.confirmacionUsuario', $data, function($msj){
            $msj->subject('Confirmación de cuenta TooDrinks');
            $msj->to('lvmb29@gmail.com');
        });
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
