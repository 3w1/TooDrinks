<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horeca;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Telefono_Horeca;
use DB; use Storage; use Auth; use Input; use Image;


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
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

        $horeca = new Horeca($request->all());
        $horeca->logo = $nombre;
        $horeca->save();

        return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su horeca');
    }

    public function show($id)
    {
        $horeca = Horeca::find($id);

        session(['horecaId' => $id]);
        session(['horecaNombre' => $horeca->nombre]);
        session(['horecaLogo' => $horeca->logo]);
        
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
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

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
