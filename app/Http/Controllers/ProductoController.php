<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Clase_Bebida;
use App\Models\Marca;
use DB;
use Image;
use Input;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $productos = Producto::paginate(1);
        return view('producto.index')->with(compact('productos'));
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

        $bebidas = DB::table('clase_bebida')
                        ->orderBy('clase')
                        ->select('id', 'clase')
                        ->get();

        $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        return view('producto.create')->with(compact('paises','provincias', 'bebidas', 'marcas'));
    }

    public function store(Request $request)
    {
        
       $file = Input::file('imagen');   
       $image = Image::make(Input::file('imagen'));

       //Ruta donde queremos guardar las imagenes
       $path = public_path().'/imagenes/productos/';
       $path2 = public_path().'/imagenes/productos/thumbnails/';
        
       //Nombre en el sistema de la imagen
       $nombre = 'producto_'.time().'.'.$file->getClientOriginalExtension();
       // Guardar Original
       $image->save($path.$nombre);
       // Cambiar de tamaño
       $image->resize(240,200);
       // Guardar Thumbnail
       $image->save($path2.$nombre);

        $producto = new Producto($request->all());
        $producto->imagen = $nombre;
        $producto->save();

        if ($request->who == 'P')
            $url = 'productor/'.$request->marca_id.'-'.$request->marca_nombre.'/productos';
            return redirect($url)->with('msj', 'Su producto ha sido agregado con éxito');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $producto = Producto::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        $bebidas = DB::table('clase_bebida')
                        ->orderBy('clase')
                        ->select('id', 'clase')
                        ->get();

        $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->select('id', 'nombre')
                        ->get();

        return view('producto.edit')->with(compact('producto', 'paises', 'provincias', 'bebidas', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->fill($request->all());
        $producto->save();

        return redirect()->action('ProductoController@index');
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);
        $producto->delete();

        return redirect()->action('ProductoController@index');
    }
}
