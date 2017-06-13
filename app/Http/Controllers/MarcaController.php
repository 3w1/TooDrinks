<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Productor;
use DB; use Input; use Image;

class MarcaController extends Controller
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
       
    }

    public function store(Request $request)
    {
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/marcas/';
        $path2 = public_path().'/imagenes/marcas/thumbnails/';
        $nombre = 'marca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $marca=new Marca($request->all());
        $marca->logo = $nombre;
        $marca->save();

        if ($request->who == 'P'){
            return redirect('productor/mis-marcas')->with('msj', 'Su marca se ha agregado con exito');
        }elseif ($request->who == 'I'){
            $marca->importadores()->attach(session('importadorId'));
            $url = 'importador/'.session('importadorId');
            return redirect($url)->with('msj', 'Su marca se ha agregado con exito');
        }elseif ($request->who == 'D'){
            $marca->distribuidores()->attach(session('distribuidorId'));
            $url = 'distribuidor/'.session('distribuidorId');
            return redirect($url)->with('msj', 'Su marca se ha agregado con exito');
        }   
    }
    
    public function show($id)
    {
       
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->fill($request->all());
        $marca->save();

        if ($request->who == 'P'){
            $url = 'productor/ver-marca/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'Los datos de su marca se han actualizado exitosamente');
        }elseif ($request->who == 'I'){
            $url = 'importador/ver-marca/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'Los datos de la marca se han actualizado exitosamente');
        }elseif ($request->who == 'D'){
            $url = 'distribuidor/ver-marca/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'Los datos de la marca se han actualizado exitosamente');
        }          
    }

    public function updateLogo(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/marcas/';
        $path2 = public_path().'/imagenes/marcas/thumbnails/';      
        $nombre = 'marca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('marca')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
        if ($request->who == 'P'){
            $url = 'productor/ver-marca/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'La imagen de la marca se ha actualizado exitosamente');
        }elseif ($request->who == 'I'){
            $url = 'importador/ver-marca/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'La imagen de la marca se ha actualizado exitosamente');
        }elseif ($request->who == 'D'){
            $url = 'distribuidor/ver-marca/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'La imagen de la marca se ha actualizado exitosamente');
        }       
    }

    public function destroy($id)
    {

    }
}
