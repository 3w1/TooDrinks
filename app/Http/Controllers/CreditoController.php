<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreditoCreateRequest;
use App\Http\Requests\CreditoUpdateRequest;
use App\Models\Credito;
use App\Models\User;
use DB;

class CreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $creditos=Credito::paginate(10);
        return view ('credito.index')->with (compact('creditos'));
    }

    public function create()
    {
      return view ('credito.create');
    }

    public function store(CreditoCreateRequest $request)
    {
        $credito=new Credito($request->all());
        $credito->save();
        return redirect()->action('CreditoController@index');
    }


    public function show($id)
    {
       $credito = Credito::all();
        return view ('credito.show')->with(compact('credito'));
    }

    public function edit($id)
    {
        $credito = Credito::find($id);

        return view('credito.edit')->with(compact('credito'));
    }

    public function update(CreditoUpdateRequest $request, $id)
    {
        $credito = Credito::find($id);
        $credito->fill($request->all());
        $credito->save();

        return redirect()->action('CreditoController@index');
    }

    public function destroy($id)
    {
         $credito = Credito::find($id);
        $credito->delete();

        return redirect()->action('CreditoController@index');
    }

    public function compra()
    {   
        $idusuario = Auth::id(); 
        
        $productores = DB::table('productor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $idusuario)
                        ->paginate(10);
        $distribuidores = DB::table('distribuidor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $idusuario)
                        ->paginate(10);
        $importador = DB::table('importador')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $idusuario)
                        ->paginate(10);

        
        $lista = array($productores, $distribuidores, $importador);

        return view('credito.lista')->with(compact('lista'));
        //dd($lista)
    }
}

