<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Productor; use App\Models\Importador; use App\Models\Distribuidor;
use DB; use Input; use Image;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session('perfilTipo') == 'P'){
            $marcas = Productor::find(session('perfilId'))
                                    ->marcas()
                                    ->paginate(6);
        }elseif (session('perfilTipo') == 'I'){
            $marcas = Importador::find(session('perfilId'))
                                    ->marcas()
                                    ->paginate(6);
        }else{
            $marcas = Distribuidor::find(session('perfilId'))
                                    ->marcas()
                                    ->paginate(6);
        }

        return view('marca.index')->with(compact('marcas'));
    }

    public function create()
    {
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('marca.create')->with(compact('paises'));
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

        if (session('perfilTipo') == 'I'){
            $marca->importadores()->attach(session('perfilId'), ['status' => '0']);
            //NOTIFICAR A PRODUCTORES QUE HAY UNA NUEVA MARCA DISPONIBLES
        }elseif (session('perfilTipo') == 'D'){
            $marca->distribuidores()->attach(session('perfilId'), ['status' => '0']);
            //NOTIFICAR A PRODUCTORES QUE HAY UNA NUEVA MARCA DISPONIBLES
        }   

        return redirect('marca')->with('msj', 'Su marca ha sido creada exitosamente');
    }
    
    public function show(Request $request, $id)
    {
        $marca = Marca::find($id);

        return view('marca.show')->with(compact('marca'));
    }

    public function descripcion($id){
        $marca = DB::table('marca')
                    ->select('descripcion', 'website')
                    ->where('id', '=', $id)
                    ->first();

        return response()->json(
            $marca
        );
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->fill($request->all());
        $marca->save();

        return redirect('marca/'.$id)->with('msj', 'Los datos de su marca se han actualizado exitosamente');       
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
       
        return redirect('marca/'.$request->id)->with('msj', 'La imagen de la marca se ha actualizado exitosamente');     
    }

    public function destroy($id)
    {

    }
}
