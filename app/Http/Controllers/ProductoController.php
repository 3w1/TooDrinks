<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Clase_Bebida;
use App\Models\Marca;
use App\Models\Bebida;
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

        if ($request->who == 'P'){
            $url = 'productor/'.$request->marca_id.'-'.$request->marca_nombre.'/productos';
            return redirect($url)->with('msj', 'Su producto ha sido agregado con éxito');
        }elseif ($request->who == 'U'){
            $url = 'usuario';
            return redirect($url)->with('msj', 'Su producto ha sido agregado con éxito');
        }elseif ($request->who == 'I'){
            $url = 'importador/'.$request->marca_id.'-'.$request->marca_nombre.'/productos';
            return redirect($url)->with('msj', 'Su producto ha sido agregado con éxito');
        }elseif ($request->who == 'D'){
            $url = 'distribuidor/'.$request->marca_id.'-'.$request->marca_nombre.'/productos';
            return redirect($url)->with('msj', 'Su producto ha sido agregado con éxito');
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
        $producto = Producto::find($id);
        $producto->fill($request->all());
        $producto->save();

        if ($request->who == 'P'){
            $url = 'productor/ver-producto/'.$id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'Los datos del producto se han actualizado exitosamente');
        }elseif ($request->who == 'I'){
            $url = 'importador/ver-producto/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'Los datos del producto se han actualizado exitosamente');
        }elseif ($request->who == 'D'){
            $url = 'distribuidor/ver-producto/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'Los datos del producto se han actualizado exitosamente');
        }    
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
       
        if ($request->who == 'P'){
            $url = 'productor/ver-producto/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'La imagen del producto se ha actualizado exitosamente');
        }elseif ($request->who == 'I'){
            $url = 'importador/ver-producto/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'La imagen del producto se ha actualizado exitosamente');
        }elseif ($request->who == 'D'){
            $url = 'distribuidor/ver-producto/'.$request->id.'-'.$request->nombre;
            return redirect($url)->with('msj', 'La imagen del producto se ha actualizado exitosamente');
        }    
    }

    public function destroy($id)
    {

    }
}
