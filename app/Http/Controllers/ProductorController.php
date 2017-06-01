<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;
use App\Models\Pais;
use App\Models\Telefono_Productor;
use DB;
use Auth;
use Session;
use Redirect;

class ProductorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $productores = Productor::paginate(1);
        return view('productor.index')->with(compact('productores'));
    }

    public function create()
    {
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('productor.create')->with(compact('paises', 'provincias'));
    }

    public function store(Request $request)
    {
        $file = $request->file('logo');
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/productores';
        $file->move($path, $nombre);

        $productor = new Productor($request->all());
        $productor->logo = $nombre;
        $productor->user_id = Auth::user()->id;
        $productor->save();

        if ($request->who == 'U'){
             return redirect()->action('UsuarioController@index'); 
        }elseif ($request->who == 'P'){
            return redirect()->action('ProductorController@index');
        }
    }

    public function show($id)
    {
        $productor = Productor::find($id);
        $cont=0;
        $cont2=0;
        $cont3=0;
        $cont4=0;

        foreach($productor->marcas as $marca)
            $cont++;
        foreach($productor->importadores as $importador)
            $cont2++;
        foreach($productor->distribuidores as $distribuidor)
            $cont3++;
        foreach($productor->demandas_importadores as $demandaImportador)
            $cont4++;
        foreach($productor->demandas_distribuidores as $demandasDistribuidor)
            $cont4++;

        return view('productor.show')->with(compact('productor', 'cont', 'cont2', 'cont3', 'cont4'));
    }

    public function edit($id)
    {
       $productor = Productor::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

       return view('productor.edit')->with(compact('productor','paises', 'provincias'));

        /*$productor = Productor::find($id);
        return response()->json(
            $productor->toArray()
        );*/
    }

    public function update(Request $request, $id)
    {
        $productor = Productor::find($id);
        $productor->fill($request->all());
        $productor->save();

        //Session::flash('message','Your message');
        //return Redirect::to('/usuario/mis-productores');
        
        /*response()->json([
            "mensaje" => "Listo"
        ]);*/
        return redirect()->action('ProductorController@index');
    }

    public function destroy($id)
    {
        $productor = Productor::find($id);
        $productor->delete();

        return redirect()->action('ProductorController@index');
    }
}
