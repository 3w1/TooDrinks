<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador; use App\Models\Distribuidor; use App\Models\User;
use App\Models\Pais; use App\Models\Provincia_Region; use App\Models\Marca;
use App\Models\Producto;
use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta;
use App\Models\Destino_Oferta;
use App\Models\Demanda_Distribuidor; use App\Models\Demanda_Producto;
use App\Models\Notificacion_P;
use DB; use Auth; use Input; use Image;

class ImportadorController extends Controller
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
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $suscripciones = DB::table('suscripcion')
                        ->orderBy('precio')
                        ->pluck('suscripcion', 'id');

        return view('adminWeb.perfiles.crearImportador')->with(compact('paises', 'suscripciones'));
    }

    public function store(Request $request)
    {
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $importador = new Importador($request->all());
        $importador->logo = $nombre;
        $importador->save();

        return redirect('admin')->with('msj', 'Se ha creado el Importador exitosamente');
    }

    public function show($id)
    {
        $importador = Importador::find($id);
        return view('importador.show')->with(compact('importador'));
    }

   /* public function edit($id)
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

        $url = 'importador/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
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
       
       $url = 'importador/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {

    }*/
    
    public function listado_marcas(){
        $accion = 'Asociar';

        $marcas = DB::table('marca')
                    ->select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('perfilId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->paginate(6);

        return view('importador.listados.marcasDisponibles')->with(compact('marcas', 'accion'));
    }

    public function asociar_marca($id){
        $fecha = new \DateTime();

        $marca = Marca::find($id);

        //Asociar importador a la marca
        $marca->importadores()->attach(session('perfilId'), ['status' => '0']);
        // ... //

        //Notificar al productor
        $url = 'notificacion/notificar-productor/AI/'.$marca->nombre.'/'.$marca->productor_id;
        return redirect($url);
        // ... //
       
        //return redirect('marca')->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');
    }

    public function listado_ofertas(){
        $importador = DB::table('importador')
                            ->where('id', '=', session('perfilId') )
                            ->select('pais_id')
                            ->get()
                            ->first();

        $ofertas = DB::table('oferta')
                    ->select('oferta.*')
                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                    ->where('oferta.visible_importadores', '=', '1')
                    ->where('destino_oferta.pais_id', '=', $importador->pais_id)
                    ->groupBy('oferta.id')
                    ->paginate(6);

        return view('importador.listados.ofertasDisponibles')->with(compact('ofertas'));
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
