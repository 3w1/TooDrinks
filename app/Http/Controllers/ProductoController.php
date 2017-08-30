<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pais; use App\Models\Provincia_Region;
use App\Models\Clase_Bebida;
use App\Models\Marca; use App\Models\Bebida;
use App\Models\Importador; use App\Models\Distribuidor;
use App\Models\Productor; use App\Models\Notificacion_P; use App\Models\Notificacion_Admin;
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

    //Agregar un Producto (Usuarios (MB, AD, SA))
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

    //Agregar Producto a una Marca ya seleccionada
    public function agregar($id, $marca){
        $usuario = '0';

        if ($id == 0){
            if (session('perfilTipo') == 'P'){
                $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
            }elseif (session('perfilTipo') == 'I'){
                $marcas = DB::table('marca')
                            ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                            ->where('importador_marca.importador_id', '=', session('perfilId'))
                            ->pluck('marca.nombre', 'marca.id');
            }elseif (session('perfilTipo') == 'D'){
                $marcas = DB::table('marca')
                            ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                            ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                            ->pluck('marca.nombre', 'marca.id');
            }elseif (session('perfilTipo') == 'H'){
                $marcas = DB::table('marca')
                            ->orderBy('nombre', 'ASC')
                            ->pluck('nombre', 'id');
            }
        }

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.producto.create')->with(compact('marcas', 'paises', 'tipos_bebidas', 'marca'));
        }

        if ($id == 0){
            return view('producto.create')->with(compact('id', 'marca', 'marcas', 'paises', 'tipos_bebidas', 'usuario'));
        }else{
            return view('producto.create')->with(compact('id', 'marca', 'paises', 'tipos_bebidas', 'usuario'));
        }
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

        if (session('perfilTipo') == 'I'){
            $producto->importadores()->attach(session('perfilId'));
        }elseif (session('perfilTipo') == 'D'){
            $producto->distribuidores()->attach(session('perfilId'));
        }elseif (session('perfilTipo') == 'H'){
            $producto->horecas()->attach(session('perfilId'));
        }

        $ult_producto = DB::table('producto')
                            ->select('id')
                            ->orderBY('id', 'DESC')
                            ->get()
                            ->first();

        $notificaciones_admin = new Notificacion_Admin();
        $notificaciones_admin->creador_id = session('perfilId');
        $notificaciones_admin->tipo_creador = session('perfilTipo');
        $notificaciones_admin->titulo = session('perfilNombre') . ' ha creado un nuevo producto en la marca '. $request->marca_nombre;
        $notificaciones_admin->url='admin/productos-sin-aprobar';
        $notificaciones_admin->user_id = 0;
        $notificaciones_admin->descripcion = 'Nuevo Producto';
        $notificaciones_admin->color = 'bg-yellow';
        $notificaciones_admin->icono = 'fa fa-plus-square-o';
        $notificaciones_admin->fecha = $fecha;
        $notificaciones_admin->tipo = 'NP';
        $notificaciones_admin->leida = '0';
        $notificaciones_admin->save();            
    
        if ($request->usuario == '1'){
            return redirect('producto')->with('msj', 'Su producto ha sido agregado con éxito.');
        }else{
            return redirect('producto/listado-de-productos/'.$request->marca_id.'-'.$request->marca_nombre)->with('msj', 'Su producto ha sido agregado con éxito.');
        }           
    }

    //Metodo que permite seleccionar los productos que se importan / distribuyen
    //cuando la entidad se asocia a una marca
    public function seleccionar_productos($marca){
        $productos = Producto::where('marca_id', '=', $marca)
                        ->orderBy('nombre', 'ASC')
                        ->paginate();

        $nombre_marca = DB::table('marca')
                        ->select('nombre')
                        ->where('id', '=', $marca)
                        ->first();

        return view('producto.seleccionarProductos')->with(compact('productos','nombre_marca'));
    }

    //Método que guarda los productos seleccionados en el método anterior
    public function asociar_productos(Request $request){
        foreach ($request->productos as $producto){
            if (session('perfilTipo') == 'I'){
                Importador::find(session('perfilId'))->productos()->attach($producto);
            }elseif (session('perfilTipo') == 'D'){
                Distribuidor::find(session('perfilId'))->productos()->attach($producto);
            }elseif (session('perfilTipo') == 'H'){
                Horeca::find(session('perfilId'))->productos()->attach($producto);
            }
        }
        return redirect('marca')->with('msj', 'Los productos han sido asociados a su lista con éxito.');
    }

    //Listado de productos de una marca específica
    public function listado($id, $marca){
        $productos = Producto::where('marca_id', '=', $id)
                        ->paginate(9);

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.listados.productos')->with(compact('productos', 'marca'));
        }

        return view('producto.listado')->with(compact('productos', 'marca'));
    }

    //Listado de productos asociados a una entidad
    public function mis_productos($filtro){
        if ($filtro == 'todos'){
            if (session('perfilTipo') == 'I'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'D'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'H'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('horeca_producto', 'producto.id', '=', 'horeca_producto.producto_id')
                            ->where('horeca_producto.horeca_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->paginate(9);
            }
        }elseif ($filtro == 'confirmados') {
            if (session('perfilTipo') == 'I'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.confirmado', '=', 1)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'D'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.confirmado', '=', 1)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'H'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('horeca_producto', 'producto.id', '=', 'horeca_producto.producto_id')
                            ->where('horeca_producto.horeca_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.confirmado', '=', 1)
                            ->paginate(9);
            }
        }elseif ($filtro == 'no-confirmados'){
            if (session('perfilTipo') == 'I'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.confirmado', '=', 0)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'D'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.confirmado', '=', 0)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'H'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('horeca_producto', 'producto.id', '=', 'horeca_producto.producto_id')
                            ->where('horeca_producto.horeca_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.confirmado', '=', 0)
                            ->paginate(9);
            }
        }elseif ($filtro == 'publicados'){
            if (session('perfilTipo') == 'I'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.publicado', '=', 1)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'D'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.publicado', '=', 1)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'H'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('horeca_producto', 'producto.id', '=', 'horeca_producto.producto_id')
                            ->where('horeca_producto.horeca_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.publicado', '=', 1)
                            ->paginate(9);
            }
        }elseif ($filtro == 'no-publicados'){
            if (session('perfilTipo') == 'I'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.publicado', '=', 0)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'D'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.publicado', '=', 0)
                            ->paginate(9);
            }elseif (session('perfilTipo') == 'H'){
                $productos = Producto::orderBy('nombre', 'ASC')
                            ->select('producto.*')
                            ->join('horeca_producto', 'producto.id', '=', 'horeca_producto.producto_id')
                            ->where('horeca_producto.horeca_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', 0)
                            ->where('producto.publicado', '=', 0)
                            ->paginate(9);
            }
        }

        return view('producto.misProductos')->with(compact('productos'));
    }

    //Productos a nivel mundial para su búsqueda y asociación
    function productos_mundiales(){
        $bebidas = DB::table('bebida')
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id'); 

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        return view('producto.productosMundiales')->with(compact('bebidas', 'paises'));
    }

    public function asociar_producto(Request $request){
        if (session('perfilTipo') == 'I'){
            Producto::find($request->producto_id)->importadores()->attach(session('perfilId'));
        }elseif (session('perfilTipo') == 'D'){
            Producto::find($request->producto_id)->distribuidores()->attach(session('perfilId'));
        }elseif (session('perfilTipo') == 'H'){
             Producto::find($request->producto_id)->horecas()->attach(session('perfilId'));
        }

        return redirect('producto/mis-productos/todos')->with('msj', 'El producto ha sido agregado a su listado con éxito.');   
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
                    ->select('producto.id', 'producto.nombre', 'producto.nombre_seo', 'producto.imagen', 'productor.id as productor')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->orderBy('producto.nombre')
                    ->where('producto.nombre', 'ILIKE', '%'.$tipo[0].'%')
                    ->get();

            foreach ($productos as $producto){
                //Consulto los paises marcados como destino por el productor
                $paises_productor = DB::table('productor_pais')
                                ->select('pais_id')
                                ->where('productor_id', '=', $producto->productor)
                                ->get();
                $check = 0;
                $cont = 0;
                //Verifico si el país es destino laboral del productor
                foreach ($paises_productor as $pais){
                    $cont++;
                    if ($pais->pais_id == session('perfilPais')){
                        $check = 1;
                    }
                }

                //Si todavía el productor no ha marcado ningún país
                if ($cont == 0){
                    $check = 1;
                }

                $producto->check = $check;
            }
        }
       
        return response()->json(
            $productos->toArray()
        );
    }

    //Buscar productos por tipo de bebida y clase (opcional)
    public function productos_por_clase($bebida, $clase){
        if ($clase == '0'){
            $productos = DB::table('producto')
                    ->select('producto.id', 'producto.nombre', 'producto.nombre_seo', 'producto.imagen', 'productor.id as productor')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->orderBy('producto.nombre')
                    ->where('producto.bebida_id', '=', $bebida)
                    ->get();
        }else{
            $productos = DB::table('producto')
                    ->select('producto.id', 'producto.nombre', 'producto.nombre_seo', 'producto.imagen', 'productor.id as productor')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->orderBy('producto.nombre')
                    ->where('producto.clase_bebida_id', '=', $clase)
                    ->get();
        }

        foreach ($productos as $producto){
            //Consulto los paises marcados como destino por el productor
            $paises_productor = DB::table('productor_pais')
                                ->select('pais_id')
                                ->where('productor_id', '=', $producto->productor)
                                ->get();
            $check = 0;
            $cont = 0;
            //Verifico si el país es destino laboral del productor
            foreach ($paises_productor as $pais){
                $cont++;
                if ($pais->pais_id == session('perfilPais')){
                    $check = 1;
                }
            }

            //Si todavía el productor no ha marcado ningún país
            if ($cont == 0){
                $check = 1;
            }

            $producto->check = $check;
        }

        return response()->json(
            $productos->toArray()
        );
    }

    //Buscar productos por tipo de bebida y país
    public function productos_por_pais($bebida, $pais){
        $productos = DB::table('producto')
                    ->select('producto.id', 'producto.nombre', 'producto.nombre_seo', 'producto.imagen', 'productor.id as productor')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->join('productor', 'marca.productor_id', '=', 'productor.id')
                    ->orderBy('producto.nombre')
                    ->where('producto.bebida_id', '=', $bebida)
                    ->where('producto.pais_id', '=', $pais)
                    ->get();

        foreach ($productos as $producto){
            //Consulto los paises marcados como destino por el productor
            $paises_productor = DB::table('productor_pais')
                                ->select('pais_id')
                                ->where('productor_id', '=', $producto->productor)
                                ->get();
            $check = 0;
            $cont = 0;
            //Verifico si el país es destino laboral del productor
            foreach ($paises_productor as $pais){
                $cont++;
                if ($pais->pais_id == session('perfilPais')){
                    $check = 1;
                }
            }

            //Si todavía el productor no ha marcado ningún país
            if ($cont == 0){
                $check = 1;
            }

            $producto->check = $check;
        }

        return response()->json(
            $productos->toArray()
        );
    }

    //Método para cargar los detalles de un producto
    //Para solicitarlo en importación o distribución
    //Para asociarlo a una entidad
    public function verificar_producto($id){
        $producto = Producto::where('id', '=', $id)->with('bebida', 'clase_bebida', 'marca')
                    ->first()->toArray();

        if (session('perfilTipo') == 'I'){
            $relacion = DB::table('importador_producto')
                        ->where('importador_id', '=', session('perfilId'))
                        ->where('producto_id', '=', $id)
                        ->first();
        }elseif (session('perfilTipo') == 'D'){
            $relacion = DB::table('distribuidor_producto')
                        ->where('distribuidor_id', '=', session('perfilId'))
                        ->where('producto_id', '=', $id)
                        ->first();
        }elseif (session('perfilTipo') == 'H'){
            $relacion = DB::table('horeca_producto')
                        ->where('horeca_id', '=', session('perfilId'))
                        ->where('producto_id', '=', $id)
                        ->first();
        }
       
        if ($relacion == null){
            $producto['relacion'] = 0;
        }else{
            $producto['relacion'] = 1;
        }

        return response()->json(
            $producto
        );
    }

    public function detalle(Request $request, $id, $nombre_seo){
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

        return view('producto.show')->with(compact('producto', 'productor', 'comentarios', 'cont', 'comentarioPerfil', 'existe'));
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
            return redirect('admin/detalle-producto/'.$request->id)->with('msj-success', 'Los datos del producto han sido actualizados con éxito.');
        }

       return redirect('producto/detalle-de-producto/'.$request->id)->with('msj', 'Los datos de su producto han sido actualizados con éxito.');
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

        return redirect('producto/detalle-de-producto/'.$request->id)->with('msj', 'La imagen del producto ha sido actualizada con éxito.');
    }

    public function destroy($id)
    {

    }
}
