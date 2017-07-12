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
        if (session('perfilTipo') == 'AD'){
            $productos = Producto::orderBy('nombre')
                            ->paginate(7);

            $marca = '0';

            return view('adminWeb.listados.productos')->with(compact('productos', 'marca'));
        }

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

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.producto.create')->with(compact('marcas', 'paises', 'tipos_bebidas', 'marca'));
        }
        
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

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.producto.create')->with(compact('marcas', 'paises', 'tipos_bebidas', 'marca'));
        }

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

        /*$productor = DB::table('marca')
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
        }*/

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

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.listados.productos')->with(compact('productos', 'marca'));
        }

        return view('producto.listado')->with(compact('productos', 'marca'));
    }

    public function show($id)
    {
        $tipo = explode('.', $id);

        if ($tipo[1] == '1'){
            //Mostrar Productos de una Marca específica
            $productos = DB::table('producto')
                    ->select('id', 'nombre')
                    ->orderBy('nombre')
                    ->where('marca_id', '=', $tipo[0])
                    ->get();
        }elseif ($tipo[1] == '2'){
            //Método para buscar un producto específico
            $productos = DB::table('producto')
                    ->select('id', 'nombre', 'nombre_seo', 'imagen')
                    ->orderBy('nombre')
                    ->where('nombre', 'ILIKE', '%'.$tipo[0].'%')
                    ->get();
        }elseif ($tipo[1] == '3'){
            //Cargar la información de un producto específico para confirmar 
            //la solicitud de importación o distribución del mismo.
            $productos = Producto::where('id', '=', $tipo[0])->with('bebida', 'clase_bebida', 'marca')
                        ->first();
        }
       
        return response()->json(
            $productos->toArray()
        );
    }

    public function detalle(Request $request, $id){
        $producto = Producto::find($id);

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        $comentarios = DB::table('opinion')
                        ->orderBy('fecha', 'DESC')
                        ->where('producto_id', '=', $id)
                        ->take(6)
                        ->get();

        $cont = 0;
        foreach ($comentarios as $comentario)
            $cont++;

        $comentarioPerfil = DB::table('opinion')
                            ->where('tipo_creador', '=', session('perfilTipo'))
                            ->where('creador_id', '=', session('perfilId'))
                            ->where('producto_id', '=', $id)
                            ->first();

        $existe = 0;
        if ( $comentarioPerfil != null)
            $existe = '1';

        //Mostrar los datos de un producto específico para aprobarlo por el AdminWeb
        if ($request->ajax()){
            $producto = Producto::where('id', '=', $id)->with('pais', 'provincia_region', 'marca', 'bebida', 'clase_bebida')
                        ->first();
            return response()->json(
                $producto->toArray()
            );
        }

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.producto.detalleProducto')->with(compact('producto', 'productor', 'comentarios', 'cont'));
        }else{
            return view('producto.show')->with(compact('producto', 'productor', 'comentarios', 'cont', 'comentarioPerfil', 'existe'));
        }
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->fill($request->all());
        $producto->save();

        if (session('perfilTipo') == 'AD'){
            return redirect('admin/detalle-producto/'.$request->id)->with('msj-success', 'Los datos del producto han sido actualizados exitosamente');
        }

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

        if (session('perfilTipo') == 'AD'){
            return redirect('admin/detalle-producto/'.$request->id)->with('msj-success', 'La imagen del producto ha sido actualizada exitosamente');
        }

        return redirect('producto/detalle-de-producto/'.$request->id)->with('msj', 'La imagen del producto ha sido actualizada exitosamente');
    }

    public function destroy($id)
    {

    }
}
