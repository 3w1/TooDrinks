<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribuidor;
use App\Models\Pais;
use App\Models\Provincia_Region;
use DB;
use Auth;

class DistribuidorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $distribuidores = Distribuidor::paginate(1);
        return view('distribuidor.index')->with(compact('distribuidores'));
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

        return view('distribuidor.create')->with(compact('paises','provincias'));
     }

    public function store(Request $request)
    {
        $file = $request->file('logo');
        $nombre = 'distribuidor_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/distribuidores';
        $file->move($path, $nombre);

        $distribuidor = new Distribuidor($request->all());
        $distribuidor->logo = $nombre;
        $distribuidor->user_id = Auth::user()->id;
        $distribuidor->save();

         if ($request->who == 'U'){
             return redirect()->action('UsuarioController@index'); 
        }elseif ($request->who == 'D'){
            return redirect()->action('DistribuidorController@index');
        }
    }

    public function show($id)
    {
        $distribuidor = Distribuidor::find($id);
        $cont=0;
        $cont2=0;

        foreach($distribuidor->marcas as $marca)
            $cont++;

        $ofertas = DB::table('oferta')
                        ->orderBy('titulo')
                        ->select('id')
                        ->where([
                            ['tipo_creador', 'D'],
                            ['creador_id', $id],
                        ])->get();

        foreach($ofertas as $oferta)
            $cont2++;

        return view('distribuidor.show')->with(compact('distribuidor', 'cont', 'cont2'));
    }

    public function edit($id)
    {
        $distribuidor = Distribuidor::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

       return view('distribuidor.edit')->with(compact('distribuidor', 'paises', 'provincias')); 
    }

    public function update(Request $request, $id)
    {
        $distribuidor = Distribuidor::find($id);
        $distribuidor->fill($request->all());
        $distribuidor->save();

        $url = 'distribuidor/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
        $imagen = $request->file('logo');

        $nombre = 'distribuidor_'.time().'.'.$imagen->getClientOriginalExtension();
        $path = public_path() . '/imagenes/distribuidores';
        $imagen->move($path, $nombre);

        $actualizacion = DB::table('distribuidor')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'distribuidor/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {
        $distribuidor = Distribuidor::find($id);
        $distribuidor->delete();

        return redirect()->action('DistribuidorController@index');   
     }
}
