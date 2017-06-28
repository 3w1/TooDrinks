<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Clase_Bebida;
use App\Models\Marca; use App\Models\Bebida;
use App\Models\Productor; use App\Models\Notificacion_P;
use DB; use Image; use Input; use Auth;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $productos = DB::table('producto')
                        ->where('tipo_creador', '=', 'U')
                        ->where('creador_id', '=', Auth::user()->id)
                        ->orderBy('nombre')
                        ->paginate(6);

        return view('usuario.listados.productos')->with(compact('productos'));
    }

    public function create()
    {
        $usuario = '1';

        $id = 0; 
        $marca = 0;

        $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        return view('producto.create')->with(compact('marcas', 'paises', 'tipos_bebidas', 'usuario', 'id', 'marca'));
    }

    public function agregar($id, $marca){
        $usuario = '0';

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        return view('producto.create')->with(compact('id', 'marca', 'paises', 'tipos_bebidas', 'usuario'));
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();

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

        $productor = DB::table('marca')
                        ->select('productor_id', 'nombre')
                        ->where('id', '=', $request->marca_id)
                        ->get()
                        ->first();

        $ult_producto = DB::table('producto')
                            ->select('id')
                            ->orderBY('id', 'DESC')
                            ->get()
                            ->first();

        if ( $productor->productor_id != '0'){
            $notificaciones_productor = new Notificacion_P();
            $notificaciones_productor->creador_id = session('perfilId');
            $notificaciones_productor->tipo_creador = session('perfilTipo');
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha creado un producto en tu marca '. $productor->nombre;
            $notificaciones_productor->url='productor/confirmar-productos/';
            $notificaciones_productor->productor_id = $productor->productor_id;
            $notificaciones_productor->descripcion = 'Nuevo Producto';
            $notificaciones_productor->color = 'bg-yellow';
            $notificaciones_productor->icono = 'fa fa-plus-square-o';
            $notificaciones_productor->fecha = $fecha;
            $notificaciones_productor->save();            
        }

        if ($request->usuario == '1'){
            return redirect('producto')->with('msj', 'Su producto ha sido agregado exitosamente');
        }else{
            return redirect('producto/listado-de-productos/'.$request->marca_id.'-'.$request->marca_nombre)->with('msj', 'Su producto ha sido agregado exitosamente');
        }           
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
