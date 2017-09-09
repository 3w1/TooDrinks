<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador; use App\Models\Distribuidor; use App\Models\User;
use App\Models\Pais; use App\Models\Provincia_Region; use App\Models\Marca;
use App\Models\Producto; use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta; use App\Models\Destino_Oferta;
use App\Models\Demanda_Distribuidor; use App\Models\Demanda_Producto;
use App\Models\Notificacion_P; use App\Models\Notificacion_Admin;
use DB; use Auth; use Input; use Image;

class ImportadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'create', 'store']]);
    }
    
    public function index()
    {
        $importadores = Importador::select('id', 'nombre', 'pais_id', 'telefono', 'persona_contacto', 'email', 'reclamada')
                        ->orderBy('nombre', 'ASC')
                        ->paginate(10);

        return view('adminWeb.importador.listado')->with(compact('importadores'));
    }

    public function create()
    {      
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        return view('adminWeb.importador.create')->with(compact('paises'));
    }

    public function store(Request $request)
    {
        $importador = new Importador($request->all());
        $importador->logo = 'usuario-icono.jpg';
        $importador->save();

        return redirect('admin/listado-importadores')->with('msj-success', 'Se ha creado el Importador con éxito.');
    }

    public function show($id)
    {
        $importador = Importador::find($id);
        return view('importador.show')->with(compact('importador'));
    }

   public function edit($id)
    {
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

    public function update(Request $request, $id)
    {
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
    
    public function asociar_marca($id, $nombre){
        $fecha = new \DateTime();

        $marca = Marca::find($id);

        //Asociar importador a la marca
        $marca->importadores()->attach(session('perfilId'), ['status' => '0']);
        // ... //
        
        if ($marca->productor_id == '0'){
            //NOTIFICAR AL ADMIN WEB
            $notificaciones_admin = new Notificacion_Admin();
            $notificaciones_admin->creador_id = session('perfilId');
            $notificaciones_admin->tipo_creador = session('perfilTipo');
            $notificaciones_admin->titulo = session('perfilNombre') . ' ha indicado que importa la marca '.$marca->nombre;
            $notificaciones_admin->url='admin/confirmar-importadores-marcas';
            $notificaciones_admin->user_id = 0;
            $notificaciones_admin->descripcion = 'Asociación Importador / Marca';
            $notificaciones_admin->color = 'bg-blue';
            $notificaciones_admin->icono = 'fa fa-hand-pointer-o';
            $notificaciones_admin->fecha = new \DateTime();
            $notificaciones_admin->tipo = 'AI';
            $notificaciones_admin->leida = '0';
            $notificaciones_admin->save();
            // *** //
        }else{
            //NOTIFICAR AL PRODUCTOR
            $notificaciones_productor = new Notificacion_P();
            $notificaciones_productor->creador_id = session('perfilId');
            $notificaciones_productor->tipo_creador = session('perfilTipo');
            $notificaciones_productor->titulo = session('perfilNombre') . ' ha indicado que importa tu marca '.$marca->nombre;
            $notificaciones_productor->url='productor/confirmar-importadores';
            $notificaciones_productor->descripcion = 'Nuevo Importador';
            $notificaciones_productor->color = 'bg-blue';
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

}
