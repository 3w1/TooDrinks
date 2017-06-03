<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horeca;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Telefono_Horeca;
use DB;
use Storage;
use Auth;


class HorecaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $horecas = Horeca::paginate(1);
        return view('horeca.index')->with(compact('horecas'));
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

        return view('horeca.create')->with(compact('paises', 'provincias'));
    }

    public function store(Request $request)
    {
        $file = $request->file('logo');
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/horecas';
        $file->move($path, $nombre);

        $horeca = new Horeca($request->all());
        $horeca->logo = $nombre;
        $horeca->save();

        return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su horeca');
    }

    public function show($id)
    {
        $horeca = Horeca::find($id);
        
        return view('horeca.show')->with(compact('horeca'));
    }

    public function edit($id)
    {
       $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        $horeca = Horeca::find($id);

        return view('horeca.edit')->with(compact('horeca', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $horeca = Horeca::find($id);
        $horeca->fill($request->all());
        $horeca->save();

        $url = 'horeca/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
        $imagen = $request->file('logo');

        $nombre = 'horeca_'.time().'.'.$imagen->getClientOriginalExtension();
        $path = public_path() . '/imagenes/horecas';
        $imagen->move($path, $nombre);

        $actualizacion = DB::table('horeca')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'horeca/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {
        $horeca = Horeca::find($id);
        $horeca->delete();

        return redirect()->action('HorecaController@index');
    }
}
