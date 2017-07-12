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
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function registrarse($tipo, $id, $token){
        return view('auth.register')->with(compact('id', 'tipo'));
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        $data['codigo_confirmacion'] = str_random(25);

        if ($data['tipo_entidad'] == 'U'){
            $data['rol'] = 'US';
        }else{
            $data['rol'] = 'MB';
        }
        
        $user = User::create([
            'rol' => $data['rol'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'direccion' => $data['direccion'], 
            'telefono' => $data['telefono'], 
            'telefono_opcional' => $data['telefono_opcional'],
            'codigo_postal' => $data['codigo_postal'],
            'pais_id' => $data['pais_id'],
            'provincia_region_id' => $data['provincia_region_id'],
            'avatar' => 'usuario-icono.jpg',
            'estado_datos' => $data['estado_datos'],
            'productor' => '0',
            'importador' => '0',
            'distribuidor' => '0',
            'horeca' => '0',
            'multinacional' => '0',
            'activado' => '0',
            'cantidad_entidades' => '0',
            'codigo_confirmacion' => $data['codigo_confirmacion'],
            'remember_token' => $data['_token']
        ]);
        
        $ult_user = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->first();

        $data['id_usuario'] = $ult_user->id;

        if ($data['id_entidad'] != '0'){
            if ($data['tipo_entidad'] == 'P'){
                $act_p = DB::table('productor')
                            ->where('id', '=', $data['id_entidad'])
                            ->update(['user_id' => $ult_user->id]);

                $act_u = DB::table('users')
                            ->where('id', '=', $ult_user->id)
                            ->update(['productor' => '1',
                                      'cantidad_entidades' => '1'
                                    ]);
            }elseif ($data['tipo_entidad'] == 'I'){
                $act_i = DB::table('importador')
                            ->where('id', '=', $data['id_entidad'])
                            ->update(['user_id' => $ult_user->id]);

                $act_u = DB::table('users')
                            ->where('id', '=', $ult_user->id)
                            ->update(['importador' => '1',
                                      'cantidad_entidades' => '1'
                                    ]);
            }elseif ($data['tipo_entidad'] == 'D'){
                $act_d = DB::table('distribuidor')
                            ->where('id', '=', $data['id_entidad'])
                            ->update(['user_id' => $ult_user->id]);

                $act_u = DB::table('users')
                            ->where('id', '=', $ult_user->id)
                            ->update(['distribuidor' => '1',
                                      'cantidad_entidades' => '1'
                                    ]);
            }
        }

        /*Mail::send('emails.confirmarCorreo', ['data' => $data] , function($msj) use ($data){
            $msj->subject('Confirmación de cuenta TooDrinks');
            $msj->to($data['email']);
        });*/

        return $user;
    }
}
