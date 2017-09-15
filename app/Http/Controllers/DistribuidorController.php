<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribuidor; use App\Models\Importador;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Marca; use App\Models\Producto;
use App\Models\Bebida; use App\Models\Productor;
use App\Models\Oferta; use App\Models\Destino_Oferta; 
use App\Models\Notificacion_P; use App\Models\Notificacion_Admin; use App\Models\Notificacion_I;
use DB; use Auth; use Input; use Image;

class DistribuidorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'create', 'store']]);
    }
    
    // ¨*** MÉTODOS PARA EL ADMIN WEB *** //
    public function index(){
        $distribuidores = Distribuidor::select('id', 'nombre', 'pais_id', 'telefono', 'persona_contacto', 'email', 'reclamada')                        ->orderBy('nombre', 'ASC')
                        ->paginate(10);

        return view('adminWeb.distribuidor.listado')->with(compact('distribuidores'));
    }

    public function create(){
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        return view('adminWeb.distribuidor.create')->with(compact('paises'));
    }

    public function store(Request $request){
        $distribuidor = new Distribuidor($request->all());
        $distribuidor->logo = 'usuario-icono.jpg'; 
        $distribuidor->save();

        return redirect('admin/listado-distribuidores')->with('msj-success', 'Se ha creado el distribuidor con éxito.');
    }
    // *** FIN DE MÉTODOS PARA EL ADMIN WEB *** //
    
    public function inicio(){
        $marcas = DB::table('marca')
                    ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $productos = DB::table('producto')
                    ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.producto_id')
                    ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $ofertas = DB::table('oferta')
                    ->where('tipo_creador', '=', 'D')
                    ->where('creador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $banners = DB::table('banner')
                    ->where('tipo_creador', '=', 'D')
                    ->where('creador_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $notificaciones = DB::table('notificacion_d')
                            ->where('distribuidor_id', '=', session('perfilId'))
                            ->orderBy('fecha', 'DESC')
                            ->take(8)
                            ->get();

        $importadores = Importador::select('importador.nombre', 'importador.logo', 'importador.provincia_region_id', 'importador_distribuidor.created_at')
                    ->join('importador_distribuidor', 'importador.id', '=', 'importador_distribuidor.importador_id')
                    ->where('importador_distribuidor.distribuidor_id', '=', session('perfilId'))
                    ->orderBy('importador_distribuidor.created_at', 'DESC')
                    ->take(4)
                    ->get();

        $solicitudesProductos = DB::table('demanda_producto')
                    ->join('producto', 'demanda_producto.producto_id', '=', 'producto.id')
                    ->join('distribuidor_producto', 'producto.id', '=', 'distribuidor_producto.id')
                    ->where('distribuidor_producto.distribuidor_id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $solicitudesDistribuidor = DB::table('demanda_distribuidor')
                    ->join('distribuidor', 'demanda_distribuidor.provincia_region_id', '=', 'distribuidor.provincia_region_id')
                    ->where('distribuidor.id', '=', session('perfilId'))
                    ->select(DB::raw('count(*) as cant'))
                    ->first();

        $ofertasMarcadas = DB::table('oferta')
                    ->where('tipo_creador', '=', 'D' )
                    ->where('creador_id', '=', session('perfilId'))
                    ->where('cantidad_contactos', '>', 0)
                    ->select('cantidad_contactos')
                    ->get();
        $contactos=0;
        foreach ($ofertasMarcadas as $om){
            $contactos = $contactos + $om->cantidad_contactos;
        }

        return view('distribuidor.inicio')
        ->with(compact('marcas', 'productos', 'ofertas', 'banners', 'notificaciones', 'importadores',
         'solicitudesProductos', 'solicitudesDistribuidor', 'contactos'));
    }
    
    public function show($id)
    {
        $distribuidor = Distribuidor::find($id);
        return view('distribuidor.show')->with(compact('distribuidor'));
    }

    public function edit($id)
    {
        $distribuidor = Distribuidor::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $distribuidor->pais_id)
                        ->pluck('provincia', 'id');

       return view('distribuidor.edit')->with(compact('distribuidor', 'paises', 'provincias')); 
    }

    public function update(Request $request, $id)
    {
        $distribuidor = Distribuidor::find($id);
        $distribuidor->fill($request->all());
        $distribuidor->save();

        session(['perfilNombre' => $distribuidor->nombre]);
        session(['perfilPais' => $distribuidor->pais_id]);
        session(['perfilProvincia' => $distribuidor->provincia_region_id]);

        $url = 'distribuidor/'.$id.'/edit';
        return redirect($url)->with('msj', 'Sus datos han sido actualizados con éxito.');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/distribuidores/';
        $path2 = public_path().'/imagenes/distribuidores/thumbnails/';
        $nombre = 'distribuidor_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('distribuidor')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
        session(['perfilLogo' => $nombre]);

        $url = 'distribuidor/'.$request->id.'/edit';
        return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito.');
    }

    public function destroy($id)
    {
         
    }

    public function asociar_marca($id, $nombre){
        $marca = Marca::find($id);

        $marca->distribuidores()->attach(session('perfilId'), ['status' => '0']);

        $importadores = DB::table('importador')
                    ->select('importador.id')
                    ->join('importador_marca', 'importador.id', '=', 'importador_marca.importador_id')
                    ->where('importador_marca.marca_id', '=', $id)
                    ->where('importador_marca.status', '=', '1')
                    ->where('importador.pais_id', '=', session('perfilPais'))
                    ->get();

        $cont=0;
        foreach ($importadores as $i){
            $cont++;
        }

        if ($cont > 0){
            foreach ($importadores as $imp){
                //NOTIFICAR A LOS IMPORTADORES QUE TENGAN LA MARCA EN EL PAÍS DEL DISTRIBUIDOR
                $notificacion_importador = new Notificacion_I();
                $notificacion_importador->creador_id = session('perfilId');
                $notificacion_importador->tipo_creador = session('perfilTipo');
                $notificacion_importador->titulo = session('perfilNombre') . ' ha indicado que distribuye una marca que tu posees '.$marca->nombre;
                $notificacion_importador->url= 'importador/confirmar-distribuidores';
                $notificacion_importador->descripcion = 'Nuevo Distribuidor';
                $notificacion_importador->color = 'bg-green';
                $notificacion_importador->icono = 'fa fa-hand-pointer-o';
                $notificacion_importador->tipo ='AD';
                $notificacion_importador->importador_id = $imp->id;
                $notificacion_importador->fecha = new \DateTime();
                $notificacion_importador->leida = '0';
                $notificacion_importador->save();
                // *** //
            }
        }

        if ( ($marca->productor_id != '0') && ($marca->productor->pais_id == session('perfilPais')) ){
            //NOTIFICAR AL PRODUCTOR
            $notificaciones_productor = new Notificacion_P();
            $notificaciones_productor->creador_id = session('perfilId');
            $notificaciones_productor->tipo_creador = session('perfilTipo');
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que distribuye tu marca '.$marca->nombre;
            $notificaciones_productor->url='productor/confirmar-distribuidores';
            $notificaciones_productor->descripcion = 'Nuevo Distribuidor';
            $notificaciones_productor->color = 'bg-red';
            $notificaciones_productor->icono = 'fa fa-hand-pointer-o';
            $notificaciones_productor->tipo ='AD';
            $notificaciones_productor->productor_id = $marca->productor_id;
            $notificaciones_productor->fecha = new \DateTime();
            $notificaciones_productor->leida = '0';
            $notificaciones_productor->save();
            // *** //
        }
        
        return redirect('marca')->with('msj', 'La marca '.$marca->nombre.' ha sido agregada a su lista con éxito. Debe esperar la confirmación del productor o de un importador.');

    }   
}
