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

    }

    public function create()
    {   
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        return view('adminWeb.perfiles.crearDistribuidor')->with(compact('paises'));
    }

    public function store(Request $request)
    {
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $horeca = new Horeca($request->all());
        $horeca->logo = $nombre;
        $horeca->save();

        return redirect('admin')->with('msj', 'Se ha creado el Horeca exitosamente');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $horeca = Horeca::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $horeca->pais_id)
                        ->pluck('provincia', 'id');

        return view('horeca.edit')->with(compact('horeca', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $horeca = Horeca::find($id);
        $horeca->fill($request->all());
        $horeca->save();

        $url = 'horeca/'.$id.'/edit';
       return redirect($url)->with('msj', 'Sus datos han sido actualizados exitosamente.');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('horeca')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'horeca/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido actualizada exitosamente.');
    }

    public function destroy($id)
    {

    }
}
