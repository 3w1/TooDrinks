<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Clase_Bebida;
use App\Models\Marca; use App\Models\Bebida;
use App\Models\Productor;
use DB; use Image; use Input;

class ProductoController extends Controller
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

    public function agregar($id, $marca){
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        return view('producto.create')->with(compact('id', 'marca', 'paises', 'tipos_bebidas'));
    }

    public function store(Request $request)
    {
        
       $file = Input::file('imagen');   
       $image = Image::make(Input::file('imagen'));

       $path = public_path().'/imagenes/productos/';
       $path2 = public_path().'/imagenes/productos/thumbnails/';
       $nombre = 'producto_'.time().'.'.$file->getClientOriginalExtension();

       $image->save($path.$nombre);
       $image->resize(240,200);
       $image->save($path2.$nombre);

        $producto = new Producto($request->all());
        $producto->imagen = $nombre;
        $producto->save();

        return redirect('producto/listado-de-productos/'.$request->marca_id.'-'.$request->marca_nombre);             
    }

    public function listado($id, $marca){
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('producto.listado')->with(compact('productos', 'marca'));
    }

    public function show($id)
    {
        $productos = DB::table('producto')
                    ->select('id', 'nombre')
                    ->orderBy('nombre')
                    ->where('marca_id', '=', $id)
                    ->get();

        return response()->json(
            $productos->toArray()
        );
    }

    public function detalle($id){
        $producto = Producto::find($id);

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('producto.show')->with(compact('producto', 'productor'));
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->fill($request->all());
        $producto->save();

       return redirect('producto/detalle-de-producto/'.$request->id)->with('msj', 'Los datos de su producto han sido actualizados exitosamente');
    }

     public function updateImagen(Request $request){
        $file = Input::file('imagen');   
        $image = Image::make(Input::file('imagen'));

        $path = public_path().'/imagenes/productos/';
        $path2 = public_path().'/imagenes/productos/thumbnails/';
        $nombre = 'producto_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('producto')
                            ->where('id', '=', $request->id)
                            ->update(['imagen' => $nombre ]);

        return redirect('producto/detalle-de-producto/'.$request->id)->with('msj', 'La imagen del producto ha sido actualizada exitosamente');
    }

    public function destroy($id)
    {

    }
}
