<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use DB;
use Auth;

class ImportadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $importadores = Importador::paginate(1);
        return view('importador.index')->with(compact('importadores'));
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

        return view('importador.create')->with(compact('paises','provincias'));
    }

    public function store(Request $request)
    {
        $file = $request->file('logo');
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/importadores';
        $file->move($path, $nombre);

        $importador = new Importador($request->all());
        $importador->logo = $nombre;
        $importador->user_id = Auth::user()->id;
        $importador->save();

        if ($request->who == 'U'){
             return redirect()->action('UsuarioController@index'); 
        }elseif ($request->who == 'I'){
            return redirect()->action('ImportadorController@index');
        }
    }

    public function show($id)
    {
        $importador = Importador::find($id);
        $cont=0;
        $cont2=0;
        $cont3=0;
        $cont4=0;

        foreach($importador->marcas as $marca)
            $cont++;
        foreach($importador->distribuidores as $distribuidor)
            $cont2++;

        $ofertas = DB::table('oferta')
                        ->orderBy('titulo')
                        ->select('id')
                        ->where([
                            ['tipo_creador', 'I'],
                            ['creador_id', $id],
                        ])->get();

        foreach($ofertas as $oferta)
            $cont3++;

        $demandas = DB::table('demanda_producto')
                        ->select('id')
                        ->where([
                            ['tipo_creador', 'I'],
                            ['creador_id', $id],
                        ])->get();

        foreach($demandas as $demanda)
            $cont4++;

        return view('importador.show')->with(compact('importador', 'cont', 'cont2', 'cont3', 'cont4'));
    }

    public function edit($id)
    {
        $importador = Importador::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

       return view('importador.edit')->with(compact('importador', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $importador = Importador::find($id);
        $importador->fill($request->all());
        $importador->save();

        $url = 'importador/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
        $imagen = $request->file('logo');

        $nombre = 'importador_'.time().'.'.$imagen->getClientOriginalExtension();
        $path = public_path() . '/imagenes/importadores';
        $imagen->move($path, $nombre);

        $actualizacion = DB::table('importador')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'importador/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {
        $importador = Importador::find($id);
        $importador->delete();

        return redirect()->action('ImportadorController@index');
    }
}
