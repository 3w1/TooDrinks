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
    
    //Pestaña Mis Productos 
    public function index(Request $request)
    {
        if (session('perfilTipo') == 'P'){
            $productos = Producto::select('producto.*')
                            ->join('marca', 'producto.marca_id', '=', 'marca.id')
                            ->where('marca.productor_id', '=', session('perfilId'))
                            ->nombre($request->get('busqueda'))
                            ->bebida($request->get('bebida'), $request->get('clase_bebida'))
                            ->marca($request->get('marca'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->paginate(9);

            $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('nombre', 'id');
        }elseif (session('perfilTipo') == 'I'){
            $productos = Producto::select('producto.*')
                            ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.importador_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->nombre($request->get('busqueda'))
                            ->bebida($request->get('bebida'), $request->get('clase_bebida'))
                            ->marca($request->get('marca'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->paginate(9);

            $marcas = DB::table('marca')
                        ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }elseif (session('perfilTipo') == 'D'){
            $productos = Producto::select('producto.*')
                            ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                            ->where('producto.id', '<>', '0')
                            ->nombre($request->get('busqueda'))
                            ->bebida($request->get('bebida'), $request->get('clase_bebida'))
                            ->marca($request->get('marca'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->paginate(9);

            $marcas = DB::table('marca')
                        ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                        ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }

        $cont=0;
        foreach ($productos as $p){
            $cont++;
        }

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id')
                    ->toArray();
        $tipos_bebidas = array('' => "Seleccione una bebida...") + $tipos_bebidas;

        return view('producto.tabs.misProductos')->with(compact('productos', 'tipos_bebidas', 'cont', 'marcas'));
    }

    //Pestaña Agregar Producto
    public function agregar_producto(Request $request){
        if (session('perfilTipo') == 'P'){
            $productos = Producto::nombre($request->get('busqueda'))
                        ->bebida($request->get('bebida'), $request->get('clase_bebida'))
                        ->where('marca_id', '=', '0')
                        ->where('publicado', '=', '1')
                        ->where('id', '<>', '0')
                        ->orderBy('nombre', 'ASC')
                        ->paginate(9);
        }elseif (session('perfilTipo') == 'I'){
            $productos = Producto::select('producto.*')
                            ->join('importador_marca', 'producto.marca_id', '=', 'importador_marca.marca_id')
                            ->where('importador_marca.status', '=', 1)
                            ->where('importador_marca.importador_id', '=', session('perfilId'))
                            ->leftjoin('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                            ->where('importador_producto.producto_id', '=', null)
                            ->orwhere('importador_producto.importador_id', '!=', session('perfilId'))
                            ->nombre($request->get('busqueda'))
                            ->marca($request->get('marca'))
                            ->bebida($request->get('bebida'), $request->get('clase_bebida'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->paginate(9);

            $marcas = DB::table('marca')
                        ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }elseif (session('perfilTipo') == 'D'){
            $productos = Producto::select('producto.*')
                            ->join('distribuidor_marca', 'producto.marca_id', '=', 'distribuidor_marca.marca_id')
                            ->where('distribuidor_marca.status', '=', 1)
                            ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                            ->leftjoin('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                            ->where('distribuidor_producto.producto_id', '=', null)
                            ->orwhere('distribuidor_producto.distribuidor_id', '!=', session('perfilId'))
                            ->nombre($request->get('busqueda'))
                            ->marca($request->get('marca'))
                            ->bebida($request->get('bebida'), $request->get('clase_bebida'))
                            ->orderBy('producto.nombre', 'ASC')
                            ->paginate(9);

            $marcas = DB::table('marca')
                        ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                        ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }

        $cont=0;
        foreach ($productos as $p){
            $cont++;
        }

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id')
                    ->toArray();

        $tipos_bebidas = array('' => "Seleccione una bebida...") + $tipos_bebidas;

        return view('producto.tabs.agregarProducto')->with(compact('productos', 'tipos_bebidas', 'cont', 'marcas'));
    }

    //Pestaña Crear Producto (Productor, Importador, Distribuidor)
    public function create()
    {
        if (session('perfilTipo')== 'P'){
            $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->where('productor_id', '=', session('perfilId'))
                    ->pluck('nombre', 'id');
        }elseif (session('perfilTipo') == 'I'){
            $marcas = DB::table('marca')
                        ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }elseif (session('perfilTipo') == 'D'){
            $marcas = DB::table('marca')
                        ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                        ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }
        
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');
        
        return view('producto.tabs.create')->with(compact('marcas', 'paises', 'tipos_bebidas'));
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

        if (session('perfilTipo') != 'P'){
            $ult_producto = Producto::select('id', 'marca_id')
                                ->orderBY('id', 'DESC')
                                ->get()
                                ->first();

            $notificaciones_admin = new Notificacion_Admin();
            $notificaciones_admin->creador_id = session('perfilId');
            $notificaciones_admin->tipo_creador = session('perfilTipo');
            $notificaciones_admin->titulo = session('perfilNombre') . ' ha creado un nuevo producto en la marca '. $ult_producto->marca->nombre;
            $notificaciones_admin->url='admin/productos-sin-aprobar';
            $notificaciones_admin->user_id = 0;
            $notificaciones_admin->descripcion = 'Nuevo Producto';
            $notificaciones_admin->color = 'bg-yellow';
            $notificaciones_admin->icono = 'fa fa-plus-square-o';
            $notificaciones_admin->fecha = $fecha;
            $notificaciones_admin->tipo = 'NP';
            $notificaciones_admin->leida = '0';
            $notificaciones_admin->save(); 
        }           
        
        if (session('perfilTipo') == 'P'){
            return redirect('producto')->with('msj', 'Su producto '.$producto->nombre.' ha sido creado con éxito.'); 
        }else{
            return redirect('producto')->with('msj', 'El producto '.$producto->nombre.' ha sido creado con éxito. Debe esperar la revisión del Administrador para visualizarlo en sus listados.');
        }                
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->fill($request->all());
        $producto->save();

        return redirect('producto/detalle-de-producto/'.$id.'/'.$producto->nombre_seo)->with('msj', 'Los datos de su producto han sido actualizados con éxito.');
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

        return redirect('producto/detalle-de-producto/'.$request->id.'/'.$request->nombre_seo)->with('msj', 'La imagen del producto ha sido actualizada con éxito.');
    }

    public function detalle(Request $request, $id, $nombre_seo){
        $producto = Producto::find($id);

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('producto.show')->with(compact('producto', 'productor'));
    }

    //Asociar un producto con un importador / distribuidor (Pestaña Agregar Producto)
    public function asociar_producto($id){
        if (session('perfilTipo') == 'I'){
            Producto::find($id)->importadores()->attach(session('perfilId'));
        }elseif (session('perfilTipo') == 'D'){
            Producto::find($id)->distribuidores()->attach(session('perfilId'));
        }

        return redirect('producto')->with('msj', 'El producto ha sido agregado a su listado con éxito.');   
    }

    public function show($id)
    {
        $tipo = explode('.', $id);

        if ($tipo[1] == '2'){
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

    public function edit($id)
    {
       
    }

    public function destroy($id)
    {

    }
}
