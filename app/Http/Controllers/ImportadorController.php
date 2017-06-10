<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Marca;
use DB; use Auth; use Input; use Image;

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
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

        $importador = new Importador($request->all());
        $importador->logo = $nombre;
        $importador->save();

        if ( $request->who == 'U'){
             return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su Importador');
        }else{
            $importador->productores()->attach(session('productorId'));
            $url = 'productor/'.session('productorId');
            return redirect($url)->with('msj', 'Se ha registrado exitosamente su Importador');
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

        session(['importadorId' => $id]);
        session(['importadorNombre' => $importador->nombre]);
        session(['importadorLogo' => $importador->logo]);

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
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

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

     //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UN DISTRIBUIDOR ASOCIADO
    public function registrar_distribuidor(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarDistribuidor')->with(compact('paises'));
    }

    //FUNCION QUE PERMITE VER LOS DISTRIBUIDORES ASOCIADOS A UN IMPORTADOR
    public function ver_distribuidores(){
        $distribuidores = Importador::find(session('importadorId'))
                                    ->distribuidores()
                                    ->paginate(6);

        return view('importador.listados.distribuidores')->with(compact('distribuidores'));
    }

    //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UNA MARCA
    public function registrar_marca(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarMarca')->with(compact('paises'));
    }
    
     //FUNCION QUE PERMITE VER LAS MARCAS QUE MANEJA UN IMPORTADOR
    public function ver_marcas(){
        $marcas = Importador::find(session('importadorId'))
                                    ->marcas()
                                    ->paginate(6);

        return view('importador.listados.marcas')->with(compact('marcas'));
    }

    public function ver_detalle_marca($id, $nombre){
        $marca = Marca::find($id);

        return view('importador.detalleMarca')->with(compact('marca'));
    }
}
