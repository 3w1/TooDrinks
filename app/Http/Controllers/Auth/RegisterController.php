<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Productor;
use Mail;
use DB;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function registrarse(){
        return view('auth.register');
    }

    public function registrarse_invitacion($tipo, $id, $token){
        return view('auth.register2')->with(compact('id', 'tipo'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:users',
            //'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        $data['codigo_confirmacion'] = str_random(25);
       
        if ($data['entidad_tipo'] == 'U' ){
            $rol = 'US';
            $cant = 0;
            $productor = '0';
            $importador = '0';
            $multinacional = '0';
            $distribuidor = '0';
            $horeca = '0';
            $entidad_predefinida = '';
            $id_entidad_predefinida = 0;
        }else{
            $rol = 'MB';
            $cant = 1;
            if ($data['entidad_tipo'] == 'P'){
                $productor = '1';
                $importador = '0';
                $multinacional = '0';
                $distribuidor = '0';
                $horeca = '0';
            }elseif ($data['entidad_tipo'] == 'I'){
                $productor = '0';
                $importador = '1';
                $multinacional = '0';
                $distribuidor = '0';
                $horeca = '0';
            }elseif ($data['entidad_tipo'] == 'M'){
                $productor = '0';
                $importador = '0';
                $multinacional = '1';
                $distribuidor = '0';
                $horeca = '0';
            }elseif ($data['entidad_tipo'] == 'D'){
                $productor = '0';
                $importador = '0';
                $multinacional = '0';
                $distribuidor = '1';
                $horeca = '0';
            }elseif ($data['entidad_tipo'] == 'H'){
                $productor = '0';
                $importador = '0';
                $multinacional = '0';
                $distribuidor = '0';
                $horeca = '1';
            }
            $entidad_predefinida = $data['entidad_tipo'];
            $id_entidad_predefinida = $data['entidad_id'];
        }

        $user = User::create([
            'rol' => $rol,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'pais_id' => $data['pais_id'],
            'provincia_region_id' => $data['provincia_region_id'],
            'avatar' => 'usuario-icono.jpg',
            'estado_datos' => '0',
            'productor' => $productor,
            'multinacional' => $multinacional,
            'importador' => $importador,
            'distribuidor' => $distribuidor,
            'horeca' => $horeca,
            'activado' => '0',
            'cantidad_entidades' => $cant,
            'codigo_confirmacion' => $data['codigo_confirmacion'],
            'remember_token' => $data['_token'],
            'entidad_predefinida' => $entidad_predefinida,
            'id_entidad_predefinida' => $id_entidad_predefinida
        ]);
        
        $ult_user = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->first();

        $data['id_usuario'] = $ult_user->id;

        Mail::send('emails.confirmarCorreo', ['data' => $data] , function($msj) use ($data){
            $msj->subject('Confirmación de cuenta TooDrinks');
            $msj->to($data['email']);
        });

        if ($data['entidad_id'] != '0'){
            if ($data['entidad_tipo'] == 'P'){
                DB::table('productor')
                    ->where('id', '=', $data['entidad_id'])
                    ->update(['user_id' => $ult_user->id]);
            }elseif ($data['entidad_tipo'] == 'I'){
                DB::table('importador')
                    ->where('id', '=', $data['entidad_id'])
                    ->update(['user_id' => $ult_user->id,
                    		  'reclamada' => '1']);
            }elseif ($data['entidad_tipo'] == 'D'){
                DB::table('distribuidor')
                    ->where('id', '=', $data['entidad_id'])
                    ->update(['user_id' => $ult_user->id,
                    	      'reclamada' => '1']);
            }elseif ($data['entidad_tipo'] == 'M'){
                DB::table('multinacional')
                    ->where('id', '=', $data['entidad_id'])
                    ->update(['user_id' => $ult_user->id,
                    	      'reclamada' => '1']);
            }elseif ($data['entidad_tipo'] == 'H'){
                DB::table('horeca')
                    ->where('id', '=', $data['entidad_id'])
                    ->update(['user_id' => $ult_user->id,
                    	      'reclamada' => '1']);
            }
        }

        return $user;
    }
}
