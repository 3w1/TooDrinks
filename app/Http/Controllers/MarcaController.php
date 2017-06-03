<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Productor;
use DB;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $listas=Marca::paginate(1);
        return view ('marca.index')->with (compact('listas'));
    }

    public function create()
    {
        //
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        $productores = DB::table('productor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        return view ('marca.create')->with (compact('paises','provincias','productores'));
    }

    public function store(Request $request)
    {
        $file = $request->file('logo');
        $nombre = 'marca_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/marcas';
        $file->move($path, $nombre);

        $marca=new Marca($request->all());
        $marca->logo = $nombre;
        $marca->save();

        if ($request->who == 'P'){
            $url = 'productor/'.session('productorId');
            return redirect($url)->with('msj', 'Su marca se ha agregado con exito');
        }else{
            return redirect()->action('MarcaController@index');
        }
        
    }

    public function show($id)
    {
       
    }

    public function edit($id)
    {
       $marca = Marca::find($id);
       $productores = Productor::all();
        $paises = Pais::all();
        $provincias = Provincia_Region::all();

        return view('marca.edit')->with(compact('productores', 'paises', 'provincias', 'marca'));
    }

    public function update(Request $request, $id)
    {
         $marca = Marca::find($id);
        $marca->fill($request->all());
        $marca->save();

        return redirect()->action('MarcaController@index');
    }

    public function destroy($id)
    {
       $marca = Marca::find($id);
        $marca->delete();

        return redirect()->action('MarcaController@index');
    }

    public function agregar_producto($id){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        $marca = DB::table('marca')
                    ->select('id', 'nombre')
                    ->where('id', $id)
                    ->get()
                    ->first();

        if ( session('perfil') == 'P')
            return view('productor.registrarProducto')->with(compact('paises', 'provincias', 'marca'));
    }
}
