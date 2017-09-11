<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Productor; use App\Models\Importador; use App\Models\Distribuidor;
use App\Models\Horeca; use App\Models\Multinacional;
use DB; use Auth; use Input; use Image; use CheckCuenta;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'welcome']);
    }

    public function confirmar_correo($id, $token){
        $user = User::find($id);

        if ($user->codigo_confirmacion == $token){
            $actualizacion = DB::table('users')
                            ->where('id', '=', $id)
                            ->update(['activado' => '1', 'codigo_confirmacion' => null ]);

            return redirect('home')->with('msj', 'Su cuenta ha sido activada con éxito');
        }else{
            return redirect('');
        }
    }

    public function cambiar_perfil(Request $request){
        $entidad = explode(".", $request->entidad);

        if ($entidad[0] == 'P'){
            $productor = Productor::where('id', '=', $entidad[1])
                                    ->first();

            session(['perfilId' => $productor->id]);
            session(['perfilNombre' => $productor->nombre]);
            session(['perfilLogo' => $productor->logo]);
            session(['perfilSaldo' => $productor->saldo]);
            session(['perfilTipo' => 'P']);
            session(['perfilPais' => $productor->pais_id]);
            session(['perfilProvincia' => $productor->provincia_region_id]);
            session(['perfilSuscripcion' => $productor->suscripcion->suscripcion]);

            return redirect('productor/inicio')->with('msj', 'Se ha cambiado a su perfil '.session('perfilNombre').' con éxito.');
        }elseif ($entidad[0] == 'I'){
            $importador = Importador::where('id', '=', $entidad[1])
                                    ->first();

            session(['perfilId' => $importador->id]);
            session(['perfilNombre' => $importador->nombre]);
            session(['perfilLogo' => $importador->logo]);
            session(['perfilSaldo' => $importador->saldo]);
            session(['perfilPais' => $importador->pais_id]);
            session(['perfilProvincia' => $importador->provincia_region_id]);
            session(['perfilTipo' => 'I']);
            session(['perfilSuscripcion' => $importador->suscripcion->suscripcion]);

            return redirect('importador/inicio')->with('msj', 'Se ha cambiado a su perfil '.session('perfilNombre').' con éxito.');
        }elseif ($entidad[0] == 'D'){
            $distribuidor = Distribuidor::where('id', '=', $entidad[1])
                                        ->first();

            session(['perfilId' => $distribuidor->id]);
            session(['perfilNombre' => $distribuidor->nombre]);
            session(['perfilLogo' => $distribuidor->logo]);
            session(['perfilSaldo' => $distribuidor->saldo]);
            session(['perfilPais' => $distribuidor->pais_id]);
            session(['perfilProvincia' => $distribuidor->provincia_region_id]);
            session(['perfilTipo' => 'D']);
            session(['perfilSuscripcion' => $distribuidor->suscripcion->suscripcion]);

            return redirect('distribuidor/inicio')->with('msj', 'Se ha cambiado a su perfil '.session('perfilNombre').' con éxito.');
        }elseif ($entidad[0] == 'H'){
            $horeca = DB::table('horeca')
                            ->where('id', '=', $entidad[1])
                            ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id')
                            ->get()
                            ->first();

            session(['perfilId' => $horeca->id]);
            session(['perfilNombre' => $horeca->nombre]);
            session(['perfilLogo' => $horeca->logo]);
            session(['perfilSaldo' => $horeca->saldo]);
            session(['perfilPais' => $horeca->pais_id]);
            session(['perfilProvincia' => $horeca->provincia_region_id]);
            session(['perfilTipo' => 'H']);

            return redirect('horeca/inicio')->with('msj', 'Se ha cambiado a su perfil '.session('perfilNombre').' con éxito.');
        }
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);

        if (Auth::user()->entidad_predefinida == 'P'){
            $entidad = Productor::select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                        ->where('id', '=', Auth::user()->id_entidad_predefinida)
                        ->first();

            session(['perfilTipo' => 'P']);
        }elseif (Auth::user()->entidad_predefinida == 'I'){
            $entidad = Importador::select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                        ->where('id', '=', Auth::user()->id_entidad_predefinida)
                        ->first();

            session(['perfilTipo' => 'I']);
        }elseif (Auth::user()->entidad_predefinida == 'D'){
            $entidad = Distribuidor::select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id', 'suscripcion_id')
                        ->where('id', '=', Auth::user()->id_entidad_predefinida)
                        ->first();

            session(['perfilTipo' => 'D']);
        }elseif (Auth::user()->entidad_predefinida == 'H'){
            $entidad = DB::table('horeca')
                        ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id')
                        ->where('id', '=', Auth::user()->id_entidad_predefinida)
                        ->first();

            session(['perfilTipo' => 'H']);
        }
                                        
        session(['perfilId' => $entidad->id]);
        session(['perfilNombre' => $entidad->nombre]);
        session(['perfilLogo' => $entidad->logo]);
        session(['perfilSaldo' => $entidad->saldo]);
        session(['perfilPais' => $entidad->pais_id]);
        session(['perfilProvincia' => $entidad->provincia_region_id]);

        if (session('perfilTipo') != 'H'){
            session(['perfilSuscripcion' => $entidad->suscripcion->suscripcion]);
        }

        if (session('perfilTipo') == 'P'){
            $url = "productor/inicio";
        }elseif (session('perfilTipo') == 'I'){
            $url = "importador/inicio";
        }elseif (session('perfilTipo') == 'D'){
            $url = "distribuidor/inicio";
        }elseif (session('perfilTipo') == 'H'){
            $url = "horeca/inicio";
        }
        return redirect($url)->with('msj', 'Se ha cambiado a su perfil '.session('perfilNombre').' con éxito.');
    }

    public function create()
    {   
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('usuario.create')->with(compact('paises','provincias'));
    }

    public function store(Request $request)
    {
    	$usuario = new Usuario($request->all());
        $usuario->save();  
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
       
       $usuario = User::find($id);
       
       $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $usuario->pais_id)
                        ->pluck('provincia', 'id');

       return view('usuario.edit')->with(compact('usuario', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        
        $usuario = User::find(Auth::user()->id);
        $usuario->fill($request->all());
        $usuario->save();

        $url = 'usuario/'.Auth::user()->id.'/edit';
        return redirect($url)->with('status', 'Sus datos han sido actualizados con éxito.');
    }

    public function updateAvatar(Request $request){

        $file = Input::file('avatar');   
        $image = Image::make(Input::file('avatar'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/usuarios/';
        $path2 = public_path().'/imagenes/usuarios/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'usuario_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

        $actualizacion = DB::table('users')
                            ->where('id', '=', Auth::user()->id)
                            ->update(['avatar' => $nombre ]);
       
       $url = 'usuario/'.Auth::user()->id.'/edit';
       return redirect($url)->with('status', 'Su imagen de perfil ha sido cambiada con éxito.');
    }

    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->delete();

        return redirect()->action('UsuarioController@index');

    }
}
