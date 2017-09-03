<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor; use App\Models\Pais; use App\Models\Marca; use App\Models\Bebida;
use App\Models\Clase_Bebida; use App\Models\Producto; use App\Models\Oferta;
use App\Models\Destino_Oferta; use App\Models\Demanda_Importador; use App\Models\Demanda_Distribuidor;
use App\Models\Importador; use App\Models\Importador_Marca; use App\Models\Notificacion_I; use App\Models\Notificacion_D;
use DB; use Auth; use Session; use Redirect; use Input; use Image;

class ProductorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'create', 'store']]);
    }
    
    public function index()
    {
        $productores = Productor::select('id', 'nombre', 'pais_id', 'telefono', 'persona_contacto', 'email', 'reclamada')
                        ->where('id', '<>', 0)
                        ->orderBy('nombre', 'ASC')
                        ->paginate(10);

        return view('adminWeb.productor.listado')->with(compact('productores'));
    }

    public function create()
    {   
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('adminWeb.productor.create')->with(compact('paises'));
    }

    public function store(Request $request)
    {   
        $productor = new Productor($request->all());
        $productor->logo = 'usuario-icono.jpg'; 
        $productor->save();

        return redirect('admin/listado-productores')->with('msj-success', 'Se ha creado el productor con éxito.');
    }

    public function show(Request $request, $id)
    {
        $productor = Productor::find($id);
        return view('productor.show')->with(compact('productor'));
    }

    public function edit($id)
    {
        $productor = Productor::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $productor->pais_id)
                        ->pluck('provincia', 'id');

        $paises_destino = DB::table('pais')
                    ->select('id', 'pais')
                    ->orderBy('pais', 'ASC')
                    ->where('id', '!=', session('perfilPais'))
                    ->get();

       return view('productor.edit')->with(compact('productor','paises', 'provincias', 'paises_destino'));

    }

    public function update(Request $request, $id)
    {
        $productor = Productor::find($id);
        $productor->fill($request->all());
        $productor->save();

        $paises = DB::table('productor_pais')
                    ->where('productor_id', '=', session('perfilId'))
                    ->first();

        if ($paises == null){
            Productor::find(session('perfilId'))
                    ->paises_importaciones()->attach(session('perfilPais'));
        }else{
            $act = DB::table('productor_pais')
                        ->where('productor_id', '=', session('perfilId'))
                        ->delete();

            Productor::find(session('perfilId'))
                    ->paises_importaciones()->attach(session('perfilPais'));

        }

        if ($request->paises != null){
            foreach ($request->paises as $pais){
                Productor::find(session('perfilId'))
                    ->paises_importaciones()->attach($pais);
            }
        }

        session(['perfilNombre' => $productor->nombre]);
        session(['perfilPais' => $productor->pais_id]);
        session(['perfilProvincia' => $productor->provincia_region_id]);

        $url = 'productor/'.$id.'/edit';
        return redirect($url)->with('msj', 'Sus datos han sido actualizados con éxito.');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/productores/';
        $path2 = public_path().'/imagenes/productores/thumbnails/';      
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('productor')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        session(['perfilLogo' => $nombre]);
       
        $url = 'productor/'.$request->id.'/edit';
        return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito.');
    }

    public function destroy($id)
    {

    }

    public function asociar_marca($id, $nombre){
        $fecha = new \DateTime();

        DB::table('marca')
            ->where('id', '=', $id)
            ->update(['reclamada' => '1',
                      'productor_id' => session('perfilId')]);

        return redirect('marca')->with('msj', 'La marca '.$nombre.' ha sido reclamada de su propiedad con éxito.');
    }

    public function asociar_producto(Request $request){
    	DB::table('producto')
    		->where('id', '=', $request->producto_id)
    		->update([ 'marca_id' => $request->marca_id,
    					'confirmado' => '1']);

    	return redirect('producto')->with('msj', 'El producto ha sido agregado a su listado con éxito');
    }

    public function listado_importadores(){
        if ( session('perfilSuscripcion') != 'G'){
            $check = 1;
        }else{
            $check = 0;
        }

        $importadores = Importador::orderBy('nombre')
                            ->select('id', 'nombre', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto')
                            ->paginate(6);

        return view('productor.listados.importadoresMundiales')->with(compact('importadores', 'check'));
    }

    public function confirmar_importadores(){
        $notificaciones_pendientes_DB = DB::table('notificacion_p')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'AI')
                                        ->get();

        foreach ($notificaciones_pendientes_DB as $notificacion){
            $act = DB::table('notificacion_p')
                    ->where('id', '=', $notificacion->id)
                    ->update(['leida' => '1']);
        }

        $solicitudes = DB::table('importador_marca')
                    ->select('importador_marca.*')
                    ->join('marca', 'importador_marca.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', session('perfilId'))
                    ->where('importador_marca.status', '=', '0')
                    ->paginate(10);

        return view('productor.solicitudes.importadores')->with(compact('solicitudes'));
    }

    public function confirmar_importador($id, $tipo, $imp){
        $fecha = new \DateTime();

        $id_marca = DB::table('importador_marca')
         -> select('marca_id')
                        ->where('id','=', $id)
                        -> get()->first();

        $nombre_marca = DB::table('marca')
         -> select('nombre')
                        ->where('id','=', $id_marca->marca_id)
                        -> get()->first();

        $productor = Productor::find(session('perfilId'));

        if ($tipo == 'S'){
            $actualizacion = DB::table('importador_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);

            $productor->importadores()->attach($imp);

            $notificaciones_importador = new Notificacion_I();
            $notificaciones_importador->creador_id = session('perfilId');
            $notificaciones_importador->tipo_creador = session('perfilTipo');
            $notificaciones_importador->titulo = 'El productor ' . $productor->nombre  . 'lo ha confirmado como importador de la marca: '. $nombre_marca->nombre;
            $notificaciones_importador->url='marca';
            $notificaciones_importador->importador_id = $imp;
            $notificaciones_importador->descripcion = "Confirmación de Importador";
            $notificaciones_importador->color = 'bg-blue';
            $notificaciones_importador->icono = 'fa fa-thumbs-o-up';
            $notificaciones_importador->fecha = $fecha;
            $notificaciones_importador->tipo = 'CI';
            $notificaciones_importador->leida = '0';
            $notificaciones_importador->save();

            return redirect('productor/confirmar-importadores')->with('msj', 'Solicitud aprobada con éxito.');
        }else{

            DB::table('importador_marca')->where('id', '=', $id)->delete();

            $notificaciones_importador = new Notificacion_I();
            $notificaciones_importador->creador_id = session('perfilId');
            $notificaciones_importador->tipo_creador = session('perfilTipo');
            $notificaciones_importador->titulo = 'El productor ' . $productor->nombre . ' lo ha rechazado como importador de la marca '. $nombre_marca->nombre;
            $notificaciones_importador->url='marca';
            $notificaciones_importador->importador_id = $imp;
            $notificaciones_importador->descripcion = "Denegación de Importador";
            $notificaciones_importador->color = 'bg-red';
            $notificaciones_importador->icono = 'fa fa-thumbs-o-down';
            $notificaciones_importador->fecha = $fecha;
            $notificaciones_importador->tipo = 'CI';
            $notificaciones_importador->leida = '0';
            $notificaciones_importador->save();

            return redirect('productor/confirmar-importadores')->with('msj', 'Solicitud denegada con éxito.');
        }
    }

    public function confirmar_distribuidores(){
        $notificaciones_pendientes_DB = DB::table('notificacion_p')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'AD')
                                        ->get();

        foreach ($notificaciones_pendientes_DB as $notificacion){
            $act = DB::table('notificacion_p')
                    ->where('id', '=', $notificacion->id)
                    ->update(['leida' => '1']);
        }

        $solicitudes = DB::table('distribuidor_marca')
                    ->select('distribuidor_marca.*')
                    ->join('marca', 'distribuidor_marca.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', session('perfilId'))
                    ->where('distribuidor_marca.status', '=', '0')
                    ->paginate(10);

        return view('productor.solicitudes.distribuidores')->with(compact('solicitudes'));
    }

    public function confirmar_distribuidor($id, $tipo, $dist){
        $fecha = new \DateTime();
        if ($tipo == 'S'){
            $actualizacion = DB::table('distribuidor_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);
           
            $id_marca = DB::table('distribuidor_marca')
                        ->select('marca_id')
                        ->where('id','=', $id)
                        ->first();

            $nombre_marca = DB::table('marca')
                            ->select('nombre')
                            ->where('id','=', $id_marca->marca_id)
                            ->first();

            $productor = Productor::find(session('perfilId'));

            $productor->distribuidores()->attach($dist);

            $notificaciones_distribuidor = new Notificacion_D();
            $notificaciones_distribuidor->creador_id = session('perfilId');
            $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
            $notificaciones_distribuidor->titulo = 'El productor ' . $productor->nombre  . ' lo ha confirmado como distribuidor de la marca: '. $nombre_marca->nombre;
            $notificaciones_distribuidor->url='marca';
            $notificaciones_distribuidor->distribuidor_id = $dist;
            $notificaciones_distribuidor->descripcion = "Confirmación de Distribuidor";
            $notificaciones_distribuidor->color = 'bg-blue';
            $notificaciones_distribuidor->icono = 'fa fa-thumbs-o-up';
            $notificaciones_distribuidor->fecha = $fecha;
            $notificaciones_distribuidor->tipo = 'CD';
            $notificaciones_distribuidor->leida = '0';
            $notificaciones_distribuidor->save();

            return redirect('productor/confirmar-distribuidores')->with('msj', 'Solicitud aprobada con éxito.');
        }else{
            DB::table('distribuidor_marca')->where('id', '=', $id)->delete();

            $notificaciones_distribuidor = new Notificacion_D();
            $notificaciones_distribuidor->creador_id = session('perfilId');
            $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
            $notificaciones_distribuidor->titulo = 'El productor ' . $productor->nombre  . 'lo ha rechazado como distribuidor de la marca: '. $nombre_marca->nombre;
            $notificaciones_distribuidor->url='marca';
            $notificaciones_distribuidor->distribuidor_id = $dist;
            $notificaciones_distribuidor->descripcion = "Denegación de Distribuidor";
            $notificaciones_distribuidor->color = 'bg-red';
            $notificaciones_distribuidor->icono = 'fa fa-thumbs-o-down';
            $notificaciones_distribuidor->fecha = $fecha;
            $notificaciones_distribuidor->tipo = 'CD';
            $notificaciones_distribuidor->leida = '0';
            $notificaciones_distribuidor->save();

            return redirect('productor/confirmar-distribuidores')->with('msj', 'Solicitud denegada con éxito.');
        }
    }

     public function confirmar_productos(){
        $productos = Producto::select('producto.*')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', session('perfilId'))
                    ->where('producto.confirmado', '=', '0')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6);

        return view('productor.solicitudes.productos')->with(compact('productos'));
    }

    public function confirmar_producto($id, $tipo){
        $fecha = new \DateTime();
        $producto = DB::table('producto')
                        ->select('creador_id', 'tipo_creador', 'nombre')
                        ->where('id', '=', $id)
                        ->get()
                        ->first();
         
        if ($tipo == 'S'){
            $actualizacion = DB::table('producto')
                                ->where('id', '=', $id)
                                ->update(['confirmado' => '1']);

            if ($producto->tipo_creador == 'I'){
                $notificaciones_importador = new Notificacion_I();
                $notificaciones_importador->creador_id = session('perfilId');
                $notificaciones_importador->tipo_creador = session('perfilTipo');
                $notificaciones_importador->titulo = session('perfilNombre') . ' ha confirmado el producto '. $producto->nombre;
                $notificaciones_importador->url='producto/detalle-de-producto/'.$id;
                $notificaciones_importador->importador_id = $producto->creador_id;
                $notificaciones_importador->descripcion = "Confirmación de Producto";
                $notificaciones_importador->color = 'bg-yellow';
                $notificaciones_importador->icono = 'fa fa-check-square-o';
                $notificaciones_importador->fecha = $fecha;
                $notificaciones_importador->tipo = 'CP';
                $notificaciones_importador->leida = '0';
                $notificaciones_importador->save(); 
            }elseif ($producto->tipo_creador == 'D'){
                $notificaciones_distribuidor = new Notificacion_D();
                $notificaciones_distribuidor->creador_id = session('perfilId');
                $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                $notificaciones_distribuidor->titulo = session('perfilNombre') . ' ha confirmado el producto '. $producto->nombre;
                $notificaciones_distribuidor->url='producto/detalle-de-producto/'.$id;
                $notificaciones_distribuidor->distribuidor_id = $producto->creador_id;
                $notificaciones_distribuidor->descripcion = "Confirmación de Producto";
                $notificaciones_distribuidor->color = 'bg-rede';
                $notificaciones_distribuidor->icono = 'fa fa-check-square-o';
                $notificaciones_distribuidor->fecha = $fecha;
                $notificaciones_distribuidor->tipo = 'CP';
                $notificaciones_distribuidor->leida = '0';
                $notificaciones_distribuidor->save(); 
            }
            return redirect('productor/confirmar-productos')->with('msj', 'Producto aprobado con éxito.');
        }else{
            DB::table('producto')
                ->where('id', '=', $id)
                ->update(['marca_id' => '0']);

            if ($producto->tipo_creador == 'I'){
                $notificaciones_importador = new Notificacion_I();
                $notificaciones_importador->creador_id = session('perfilId');
                $notificaciones_importador->tipo_creador = session('perfilTipo');
                $notificaciones_importador->titulo = session('perfilNombre') . ' ha indicado que el producto '. $producto->nombre.' no pertenece a su marca.';
                $notificaciones_importador->url='producto/detalle-de-producto/'.$id;
                $notificaciones_importador->importador_id = $producto->creador_id;
                $notificaciones_importador->descripcion = "Denegación de Producto";
                $notificaciones_importador->color = 'bg-red';
                $notificaciones_importador->icono = 'fa fa-exclamation-circle';
                $notificaciones_importador->fecha = $fecha;
                $notificaciones_importador->tipo = 'CP';
                $notificaciones_importador->leida = '0';
                $notificaciones_importador->save(); 
            }elseif ($producto->tipo_creador == 'D'){
                $notificaciones_distribuidor = new Notificacion_D();
                $notificaciones_distribuidor->creador_id = session('perfilId');
                $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                $notificaciones_distribuidor->titulo = session('perfilNombre') . ' ha indicado que el producto '. $producto->nombre.' no pertenece a su marca.';
                $notificaciones_distribuidor->url='producto/detalle-de-producto/'.$id;
                $notificaciones_distribuidor->distribuidor_id = $producto->creador_id;
                $notificaciones_distribuidor->descripcion = "Denegación de Producto";
                $notificaciones_distribuidor->color = 'bg-red';
                $notificaciones_distribuidor->icono = 'fa fa-exclamation-cirlce';
                $notificaciones_distribuidor->fecha = $fecha;
                $notificaciones_distribuidor->tipo = 'CP';
                $notificaciones_distribuidor->leida = '0';
                $notificaciones_distribuidor->save();
            }

            return redirect('productor/confirmar-productos')->with('msj', 'Producto eliminado con éxito.');
        }
    }
}
