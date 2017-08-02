<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Productor; use App\Models\Importador; use App\Models\Distribuidor;
use App\Models\Horeca; use App\Models\Multinacional;
use DB; use Auth; use Input; use Image;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'welcome']);
    }

    public function welcome(){
        return view('auth.home');
    }

    public function confirmar_correo($id, $token){
        $user = User::find($id);

        if ($user->codigo_confirmacion == $token){
            $actualizacion = DB::table('users')
                            ->where('id', '=', $id)
                            ->update(['activado' => '1', 'codigo_confirmacion' => null ]);

            return redirect('usuario')->with('msj', 'Su cuenta ha sido activada exitosamente.');
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
        }elseif ($entidad[0] == 'M'){
            $multinacional = Multinacional::where('id', '=', $entidad[1])
                                    ->first();

            session(['perfilId' => $multinacional->id]);
            session(['perfilNombre' => $multinacional->nombre]);
            session(['perfilLogo' => $multinacional->logo]);
            session(['perfilSaldo' => $multinacional->saldo]);
            session(['perfilPais' => $multinacional->pais_id]);
            session(['perfilProvincia' => $multinacional->provincia_region_id]);
            session(['perfilTipo' => 'M']);
            session(['perfilSuscripcion' => $multinacional->suscripcion->suscripcion]);
            session(['perfilPadre' => $multinacional->productor_id]);
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
        }

        return redirect('notificacion')->with('msj', 'Se ha cambiado de perfil exitosamente');
    }

    public function inicio(){
        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.index');
        }else{
            return view('usuario.index');
        }
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);

        if ($user->rol == 'AD'){

            session(['perfilId' => $user->id]);
            session(['perfilNombre' => $user->nombre." ".$user->apellido]);
            session(['perfilLogo' => $user->avatar]);
            session(['perfilTipo' => 'AD']);
            session(['perfilPais' => $user->pais_id]);
            session(['perfilProvincia' => $user->provincia_region_id]);

            return view('adminWeb.index');

        }elseif ($user->rol == 'US'){
            session(['perfilId' => $user->id]);
            session(['perfilNombre' => $user->nombre." ".$user->apellido]);
            session(['perfilLogo' => $user->avatar]);
            session(['perfilTipo' => 'US']);
            session(['perfilPais' => $user->pais_id]);
            session(['perfilProvincia' => $user->provincia_region_id]);

            return view('usuario.index');
        }else{

            if ($user->productor == '1'){
                $productor = Productor::where('user_id', '=', Auth::user()->id)
                                        ->first();
                                        
                session(['perfilId' => $productor->id]);
                session(['perfilNombre' => $productor->nombre]);
                session(['perfilLogo' => $productor->logo]);
                session(['perfilSaldo' => $productor->saldo]);
                session(['perfilTipo' => 'P']);
                session(['perfilPais' => $productor->pais_id]);
                session(['perfilProvincia' => $productor->provincia_region_id]);
                session(['perfilSuscripcion' => $productor->suscripcion->suscripcion]);
            }elseif ($user->importador == '1'){
                $importador = Importador::where('user_id', '=', Auth::user()->id)
                                        ->first();

                session(['perfilId' => $importador->id]);
                session(['perfilNombre' => $importador->nombre]);
                session(['perfilLogo' => $importador->logo]);
                session(['perfilSaldo' => $importador->saldo]);
                session(['perfilTipo' => 'I']);
                session(['perfilPais' => $importador->pais_id]);
                session(['perfilProvincia' => $importador->provincia_region_id]);
                session(['perfilSuscripcion' => $importador->suscripcion->suscripcion]);
            }elseif ($user->multinacional == '1'){
                $multinacional = Multinacional::where('user_id', '=', Auth::user()->id)
                                        ->first();

                session(['perfilId' => $multinacional->id]);
                session(['perfilNombre' => $multinacional->nombre]);
                session(['perfilLogo' => $multinacional->logo]);
                session(['perfilSaldo' => $multinacional->saldo]);
                session(['perfilTipo' => 'M']);
                session(['perfilPais' => $multinacional->pais_id]);
                session(['perfilProvincia' => $multinacional->provincia_region_id]);
                session(['perfilSuscripcion' => $multinacional->suscripcion->suscripcion]);
                session(['perfilPadre' => $multinacional->productor_id]);
            }elseif ($user->distribuidor == '1'){
                $distribuidor = Distribuidor::where('user_id', '=', Auth::user()->id)
                                        ->first();

                session(['perfilId' => $distribuidor->id]);
                session(['perfilNombre' => $distribuidor->nombre]);
                session(['perfilLogo' => $distribuidor->logo]);
                session(['perfilSaldo' => $distribuidor->saldo]);
                session(['perfilTipo' => 'D']);
                session(['perfilPais' => $distribuidor->pais_id]);
                session(['perfilProvincia' => $distribuidor->provincia_region_id]);
                session(['perfilSuscripcion' => $distribuidor->suscripcion->suscripcion]);
            }elseif ($user->horeca == '1'){
                $horeca = DB::table('horeca')
                                ->where('user_id', '=', Auth::user()->id)
                                ->select('id', 'nombre', 'logo', 'saldo', 'pais_id', 'provincia_region_id')
                                ->get()
                                ->first();

                session(['perfilId' => $horeca->id]);
                session(['perfilNombre' => $horeca->nombre]);
                session(['perfilLogo' => $horeca->logo]);
                session(['perfilSaldo' => $horeca->saldo]);
                session(['perfilTipo' => 'H']);
                session(['perfilPais' => $horeca->pais_id]);
                session(['perfilProvincia' => $horeca->provincia_region_id]);
            }
        }

        return redirect('notificacion');
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
        return redirect($url)->with('status', 'Sus datos han sido actualizados exitosamente');
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
       return redirect($url)->with('status', 'Su imagen de perfil ha sido cambiada exitosamente');
    }

    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->delete();

        return redirect()->action('UsuarioController@index');

    }
}
