<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Requests\MarcaCreateRequest; use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use App\Models\Pais;
use App\Models\Provincia_Region; 
use App\Models\Productor; use App\Models\Importador; use App\Models\Distribuidor;
use App\Models\Notificacion_Admin;
use DB; use Input; use Image;

class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'store']);
    }

    //Pestaña Mis Marcas
    public function index(Request $request){
        if (session('perfilTipo') == 'P'){
            $marcas = Marca::nombre($request->get('busqueda'))
            			->status($request->get('status'))
            			->where('productor_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->paginate(6);

            $cont=0;
            foreach ($marcas as $m){
                $cont++;
            }
        }elseif (session('perfilTipo') == 'I'){
            $marcas = Marca::select('marca.*', 'importador_marca.status')
                        ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->nombre($request->get('busqueda'))
                        ->status($request->get('status'))
                        ->orderBy('marca.nombre', 'ASC')
                        ->paginate(6);

            $cont=0;
            foreach ($marcas as $m){
                $cont++;
            }
        }elseif (session('perfilTipo') == 'D'){
            $marcas = Marca::select('marca.*', 'distribuidor_marca.status')
                        ->join('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                        ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                        ->nombre($request->get('busqueda'))
                        ->status($request->get('status'))
                        ->orderBy('marca.nombre', 'ASC')
                        ->paginate(6);
            $cont=0;
            foreach ($marcas as $m){
                $cont++;
            }
        }

        return view('marca.tabs.misMarcas')->with(compact('marcas', 'cont'));
    }

    //Pestaña Agregar Marca para asociar
    public function agregar_marca(Request $request){
    	if (session('perfilTipo') == 'P'){
            $marcas = Marca::nombre($request->get('busqueda'))
                        ->where('id', '<>', '0')
                        ->where('productor_id', '=', '0')
                        ->where('publicada', '=', '1')
                        ->orderBy('nombre', 'ASC')
                        ->paginate(6);

            $cont=0;
            foreach ($marcas as $m){
                $cont++;
            }
        }elseif (session('perfilTipo') == 'I'){
            $marcas = Marca::select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('perfilId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->where('marca.id', '<>', '0')
                    ->where('publicada', '=', '1')
                    ->nombre($request->get('busqueda'))
                    ->orderBy('nombre', 'ASC')
                    ->paginate(6);

            $cont=0;
            foreach ($marcas as $m){
                $cont++;
            }
        }elseif (session('perfilTipo') == 'D'){
            $marcas = Marca::select('marca.*')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '!=', session('perfilId'))
                    ->orwhere('distribuidor_marca.marca_id', '=', null)
                    ->where('marca.id', '<>', '0')
                    ->where('publicada', '=', '1')
                    ->nombre($request->get('busqueda'))
                    ->orderBy('nombre', 'ASC')
                    ->paginate(6);

            $cont=0;
            foreach ($marcas as $m){
                $cont++;
            }
        }

        return view('marca.tabs.agregarMarca')->with(compact('marcas', 'cont'));
    }

    //Pestaña Crear Marca
    public function create()
    {
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('marca.tabs.create')->with(compact('paises'));
    }

    //Almacenar una Marca
    public function store(Request $request)
    {
        $fecha = new \DateTime();
        
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/marcas/';
        $path2 = public_path().'/imagenes/marcas/thumbnails/';
        $nombre = 'marca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $marca=new Marca($request->all());
        $marca->logo = $nombre;
        $marca->save();

        if (session('perfilTipo') == 'I'){
            $marca->importadores()->attach(session('perfilId'), ['status' => '0']);
        }elseif (session('perfilTipo') == 'D'){
            $marca->distribuidores()->attach(session('perfilId'), ['status' => '0']);
        }       

        if (session('perfilTipo') != 'P'){
            $notificacion_admin = new Notificacion_Admin();
            $notificacion_admin->creador_id = session('perfilId');
            $notificacion_admin->tipo_creador = session('perfilTipo');
            $notificacion_admin->titulo = session('perfilNombre') . ' ha creado una nueva marca';
            $notificacion_admin->url='admin/aprobar-marcas';
            $notificacion_admin->user_id = 0;
            $notificacion_admin->descripcion = 'Nueva Marca';
            $notificacion_admin->color = 'bg-purple';
            $notificacion_admin->icono = 'fa fa-plus-circle';
            $notificacion_admin->fecha = $fecha;
            $notificacion_admin->tipo = 'NM';
            $notificacion_admin->leida = '0';
            $notificacion_admin->save();
        }
        
        if (session('perfilTipo') == 'P'){ 
            return redirect('marca')->with('msj', 'Su marca '.$marca->nombre.' ha sido creada con éxito.');
        }else{
            return redirect('marca')->with('msj', 'La marca '.$marca->nombre.' ha sido creada con éxito. Debe esperar la aprobación del Administrador para comercializarla.');
        }
    }
    
    public function show(Request $request, $id, $nombre_seo)
    {
        $marca = Marca::find($id);

        return view('marca.show')->with(compact('marca'));
    }

    public function descripcion($id){
        $marca = DB::table('marca')
                    ->select('descripcion', 'website')
                    ->where('id', '=', $id)
                    ->first();

        return response()->json(
            $marca
        );
    }

    public function detalles_marca($id){
        $marca = Marca::where('id', '=', $id)->with('productor', 'pais')
                    ->first()->toArray();

        /*if (session('perfilTipo') == 'I'){
            $relacion = DB::table('importador_marca')
                        ->select('id')
                        ->where('importador_id', '=', session('perfilId'))
                        ->where('marca_id', '=', $id)
                        ->first();
        }elseif (session('perfilTipo') == 'D'){
            $relacion = DB::table('distribuidor_marca')
                        ->select('id')
                        ->where('distribuidor_id', '=', session('perfilId'))
                        ->where('marca_id', '=', $id)
                        ->first();
        }*/
        
        //Verifico que el usuario se encuentre relacionado con la marca que seleccionó
        /*if ($relacion != null ){
            $marca['relacion'] = 1;
        }else{
            $marca['relacion'] = 0;
            
            //Si no se encuentra relacionado verifico que el productor 
            //haya marcado su país como destino laboral
            //para permitir la solicitud de importación / distribución
            $paises_productor = DB::table('productor_pais')
                                ->select('pais_id')
                                ->where('productor_id', '=', $marca['productor_id'])
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
            
            $marca['check'] = $check;
        }*/

        return response()->json(
            $marca
        );
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->fill($request->all());
        $marca->save();
        
        return redirect('marca/'.$id.'/'.$marca->nombre_seo)->with('msj', 'Los datos de su marca se han actualizado con éxito.');       
    }

    public function updateLogo(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/marcas/';
        $path2 = public_path().'/imagenes/marcas/thumbnails/';      
        $nombre = 'marca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('marca')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        return redirect('marca/'.$request->id.'/'.$request->nombre_seo)->with('msj', 'El logo de la marca se ha actualizado con éxito.');     
    }

    public function destroy($id)
    {

    }
}
