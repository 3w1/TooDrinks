<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bebida;
use DB;

class BebidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
       $bebidas=Bebida::paginate(1);
        return view ('bebida.index')->with (compact('bebidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view ('bebida.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bebida=new Bebida($request->all());
        $bebida->save();
        return redirect()->action('BebidaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clases = DB::table('clase_bebida')
                    ->orderBy('clase', 'ASC')
                    ->select('id', 'clase')
                    ->where('bebida_id', '=', $id)
                    ->get();

        return response()->json(
            $clases->toArray()
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
        $bebida = Bebida::find($id);

        return view('bebida.edit')->with(compact('bebida'));
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
        $bebida = Bebida::find($id);
        $bebida->fill($request->all());
        $bebida->save();

        return redirect()->action('BebidaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bebida = Bebida::find($id);
        $bebida->delete();

        return redirect()->action('BebidaController@index');
    }
}
