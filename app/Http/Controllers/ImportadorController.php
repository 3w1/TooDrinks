<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador; use App\Models\Distribuidor; use App\Models\User;
use App\Models\Pais; use App\Models\Provincia_Region; use App\Models\Marca;
use App\Models\Producto; use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta; use App\Models\Destino_Oferta;
use App\Models\Demanda_Distribuidor; use App\Models\Demanda_Producto;
use App\Models\Notificacion_P; use App\Models\Notificacion_Admin; use App\Models\Notificacion_D;
use DB; use Auth; use Input; use Image;

class ImportadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'create', 'store']]);
    }
    
    // *** MÉTODOS DEL ADMIN WEB ***//
    public function index(){
        $importadores = Importador::select('id', 'nombre', 'pais_id', 'telefono', 'persona_contacto', 'email', 'reclamada')
                        ->orderBy('nombre', 'ASC')
                        ->paginate(10);

        return view('adminWeb.importador.listado')->with(compact('importadores'));
    }

    public function create(){      
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        return view('adminWeb.importador.create')->with(compact('paises'));
    }

    public function store(Request $request){
        $importador = new Importador($request->all());
        $importador->logo = 'usuario-icono.jpg';
        $importador->save();

        return redirect('admin/listado-importadores')->with('msj-success', 'Se ha creado el Importador con éxito.');
    }
    // *** FIN DE MÉTODOS DEL ADMIN WEB ***/
    
    public function inicio(){
        $marcas = DB::table('marca')
                    ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $productos = DB::table('producto')
                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.producto_id')
                    ->where('importador_producto.importador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $ofertas = DB::table('oferta')
                    ->where('tipo_creador', '=', 'I')
                    ->where('creador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $banners = DB::table('banner')
                    ->where('tipo_creador', '=', 'I')
                    ->where('creador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $notificaciones = DB::table('notificacion_i')
                            ->where('importador_id', '=', session('perfilId'))
                            ->orderBy('fecha', 'DESC')
                            ->take(8)
                            ->get();

        $productores = Productor::select('productor.nombre', 'productor.logo', 'productor.pais_id', 'productor_importador.created_at')
                    ->join('productor_importador', 'productor.id', '=', 'productor_importador.productor_id')
                    ->where('productor_importador.importador_id', '=', session('perfilId'))
                    ->orderBy('productor_importador.created_at', 'DESC')
                    ->take(2)
                    ->get();

        $distribuidores = Distribuidor::select('distribuidor.nombre', 'distribuidor.logo', 'distribuidor.provincia_region_id', 'importador_distribuidor.created_at')
                    ->join('importador_distribuidor', 'distribuidor.id', '=', 'importador_distribuidor.distribuidor_id')
                    ->where('importador_distribuidor.importador_id', '=', session('perfilId'))
                    ->orderBy('importador_distribuidor.created_at', 'DESC')
                    ->take(2)
                    ->get();

        $solicitudesProductos = DB::table('demanda_producto')
                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                    ->join('importador_producto', 'producto.id', '=', 'importador_producto.id')
                    ->where('importador_producto.importador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $solicitudesImportador = DB::table('demanda_importador')
                    ->join('importador', 'demanda_importador.pais_id', '=', 'importador.pais_id')
                    ->where('importador.id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $solicitudesDistribucion = DB::table('solicitud_distribucion')
                    ->join('marca', 'solicitud_distribucion.marca_id', '=', 'marca.id')
                    ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $ofertasMarcadas = DB::table('oferta')
                    ->where('tipo_creador', '=', 'I' )
                    ->where('creador_id', '=', session('perfilId'))
                    ->where('cantidad_contactos', '>', 0)
                    ->select('cantidad_contactos')
                    ->get();
        $contactos=0;
        foreach ($ofertasMarcadas as $om){
            $contactos = $contactos + $om->cantidad_contactos;
        }

        return view('importador.inicio')
        ->with(compact('marcas', 'productos', 'ofertas', 'banners', 'notificaciones', 'productores', 'distribuidores',
         'solicitudesProductos', 'solicitudesImportador', 'solicitudesDistribucion', 'contactos'));
    }

    public function show($id){
        $importador = Importador::find($id);
        return view('importador.show')->with(compact('importador'));
    }

    public function edit($id){
        $importador = Importador::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $importador->pais_id)
                        ->pluck('provincia', 'id');

       return view('importador.edit')->with(compact('importador', 'paises', 'provincias'));
    }

    public function update(Request $request, $id){
        $importador = Importador::find($id);
        $importador->fill($request->all());
        $importador->save();

        session(['perfilNombre' => $importador->nombre]);
        session(['perfilPais' => $importador->pais_id]);
        session(['perfilProvincia' => $importador->provincia_region_id]);

        $url = 'importador/'.$id.'/edit';
        return redirect($url)->with('msj', 'Sus datos han sido actualizados con éxito.');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('importador')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        session(['perfilLogo' => $nombre]);
       
       $url = 'importador/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito.');
    }

    public function destroy($id)
    {

    }
    
    //Pestaña Importador / Marca / Agregar Marca
    public function asociar_marca($id, $nombre){
        $fecha = new \DateTime();

        $marca = Marca::find($id);

        //Asociar importador a la marca
        $marca->importadores()->attach(session('perfilId'), ['status' => '0']);
        // ... //
        
        if ($marca->productor_id != '0'){
            //NOTIFICAR AL PRODUCTOR
            $notificaciones_productor = new Notificacion_P();
            $notificaciones_productor->creador_id = session('perfilId');
            $notificaciones_productor->tipo_creador = session('perfilTipo');
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que importa tu marca '.$marca->nombre;
            $notificaciones_productor->url= 'productor/confirmar-importadores';
            $notificaciones_productor->descripcion = 'Nuevo Importador';
            $notificaciones_productor->color = 'bg-orange';
            $notificaciones_productor->icono = 'fa fa-hand-pointer-o';
            $notificaciones_productor->tipo ='AI';
            $notificaciones_productor->productor_id = $marca->productor_id;
            $notificaciones_productor->fecha = new \DateTime();
            $notificaciones_productor->leida = '0';
            $notificaciones_productor->save();
            // *** //
        }

        return redirect('marca')->with('msj', 'La marca '.$marca->nombre.' ha sido agregada a su lista con éxito. Debe esperar la confirmación del productor.');
    }

    public function solicitar_importacion(){
        $accion = 'Solicitar';

        $marcas = DB::table('marca')
                    ->select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('perfilId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->paginate(6);

        return view('importador.listados.marcasDisponibles')->with(compact('marcas', 'accion'));
    }

    public function listado_distribuidores(){
        $pais_importador = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('perfilId'))
                            ->get()
                            ->first();

        $distribuidores = Distribuidor::orderBy('nombre')
                            ->select('nombre', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto')
                            ->where('pais_id', '=', $pais_importador->pais_id)
                            ->paginate(6);

        return view('importador.listados.distribuidoresPais')->with(compact('distribuidores'));
    }

    //Pestaña importador / Confirmaciones / Distribuidores
    public function confirmar_distribuidores(Request $request){
        $solicitudes = DB::table('distribuidor_marca')
                    ->select('distribuidor_marca.*')
                    ->join('marca', 'distribuidor_marca.marca_id', '=', 'marca.id')
                    ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->where('distribuidor_marca.status', '=', '0')
                    ->paginate(10);

        if ($request->get('marca') != null){
            $solicitudes = DB::table('distribuidor_marca')
                    ->where('marca_id', '=', $request->get('marca'))
                    ->where('status', '=', '0')
                    ->paginate(10);
        }

        $cont = 0;
        foreach ($solicitudes as $s){
            $cont++;
        }

        $marcas = DB::table('marca')
                ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                ->where('importador_marca.importador_id', '=', session('perfilId'))
                ->where('importador_marca.status', '=', '1')
                ->orderBy('marca.nombre', 'marca.id')
                ->pluck('marca.nombre', 'marca.id');

        return view('confirmaciones.tabsImportador.distribuidores')->with(compact('solicitudes', 'cont', 'marcas'));
    }

    public function confirmar_distribuidor($id, $tipo, $dist){
        $fecha = new \DateTime();

        $marca = DB::table('marca')
                ->select('marca.nombre')
                ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                ->where('distribuidor_marca.id', '=', $id)
                ->first();

        $importador = Importador::find(session('perfilId'));
        
        if ($tipo == 'S'){
            $actualizacion = DB::table('distribuidor_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);

            $importador->distribuidores()->attach($dist);

            $notificaciones_distribuidor = new Notificacion_D();
            $notificaciones_distribuidor->creador_id = session('perfilId');
            $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
            $notificaciones_distribuidor->titulo = 'El importador ' . $importador->nombre  . ' lo ha confirmado como distribuidor de la marca '. $marca->nombre;
            $notificaciones_distribuidor->url='marca';
            $notificaciones_distribuidor->distribuidor_id = $dist;
            $notificaciones_distribuidor->descripcion = "Confirmación de Distribuidor";
            $notificaciones_distribuidor->color = 'bg-blue';
            $notificaciones_distribuidor->icono = 'fa fa-thumbs-o-up';
            $notificaciones_distribuidor->fecha = $fecha;
            $notificaciones_distribuidor->tipo = 'CD';
            $notificaciones_distribuidor->leida = '0';
            $notificaciones_distribuidor->save();

            return redirect('importador/confirmar-distribuidores')->with('msj', 'Solicitud aprobada con éxito.');
        }else{
            DB::table('distribuidor_marca')->where('id', '=', $id)->delete();

            $notificaciones_distribuidor = new Notificacion_D();
            $notificaciones_distribuidor->creador_id = session('perfilId');
            $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
            $notificaciones_distribuidor->titulo = 'El importador ' . $importador->nombre  . 'lo ha rechazado como distribuidor de la marca: '. $marca->nombre;
            $notificaciones_distribuidor->url='marca';
            $notificaciones_distribuidor->distribuidor_id = $dist;
            $notificaciones_distribuidor->descripcion = "Denegación de Distribuidor";
            $notificaciones_distribuidor->color = 'bg-red';
            $notificaciones_distribuidor->icono = 'fa fa-thumbs-o-down';
            $notificaciones_distribuidor->fecha = $fecha;
            $notificaciones_distribuidor->tipo = 'CD';
            $notificaciones_distribuidor->leida = '0';
            $notificaciones_distribuidor->save();

            return redirect('importador/confirmar-distribuidores')->with('msj', 'Solicitud denegada con éxito.');
        }
    }

}
