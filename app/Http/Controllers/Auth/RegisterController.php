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

    /*public function registrarse($tipo, $id, $token){
        return view('auth.register')->with(compact('id', 'tipo'));
    }*/

    public function registrarse(){
        return view('auth.register');
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

        if ($data['tipo'] == 'U'){
            $data['rol'] = 'US';
            $data['cantidad_entidades'] = '0';
            $data['productor'] = '0';
            $data['multinacional'] = '0';
            $data['importador'] = '0';
            $data['distribuidor'] = '0';
            $data['horeca'] = '0';
        }else{
            $data['rol'] = 'MB';
            $data['cantidad_entidades'] = '1';
            if ($data['tipo'] == 'P'){
                $data['productor'] = '1';
                $data['multinacional'] = '0';
                $data['importador'] = '0';
                $data['distribuidor'] = '0';
                $data['horeca'] = '0';
            }elseif ($data['tipo'] == 'M'){
                $data['productor'] = '0';
                $data['multinacional'] = '1';
                $data['importador'] = '0';
                $data['distribuidor'] = '0';
                $data['horeca'] = '0';
            }elseif ($data['tipo'] == 'I'){
                $data['productor'] = '0';
                $data['multinacional'] = '0';
                $data['importador'] = '1';
                $data['distribuidor'] = '0';
                $data['horeca'] = '0';
            }elseif ($data['tipo'] == 'D'){
                $data['productor'] = '0';
                $data['multinacional'] = '0';
                $data['importador'] = '0';
                $data['distribuidor'] = '1';
                $data['horeca'] = '0';
            }elseif ($data['tipo'] == 'H'){
                $data['productor'] = '0';
                $data['multinacional'] = '0';
                $data['importador'] = '0';
                $data['distribuidor'] = '0';
                $data['horeca'] = '1';
            }
        }
  
        $user = User::create([
            'rol' => $data['rol'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'pais_id' => $data['pais_id'],
            'provincia_region_id' => $data['provincia_region_id'],
            'avatar' => 'usuario-icono.jpg',
            'estado_datos' => $data['estado_datos'],
            'productor' => $data['productor'],
            'multinacional' => $data['multinacional'],
            'importador' => $data['importador'],
            'distribuidor' => $data['distribuidor'],
            'horeca' => $data['horeca'],
            'activado' => '0',
            'cantidad_entidades' => $data['cantidad_entidades'],
            'codigo_confirmacion' => $data['codigo_confirmacion'],
            'remember_token' => $data['_token']
        ]);
        
        $ult_user = DB::table('users')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->first();

        $data['id_usuario'] = $ult_user->id;

        if ($data['rol']== 'MB'){
            if ($data['productor'] == '1'){
                DB::table('productor')->insertGetId(['user_id' => $data['id_usuario'], 'nombre' => $data['nombre'],
                    'pais_id' => $data['pais_id'], 'provincia_region_id' => $data['provincia_region_id'],
                    'logo' => 'usuario-icono.jpg', 'reclamada' => '1', 'estado_datos' => '0', 'saldo' => '0', 'suscripcion_id' => '0' ]);

                $prod = DB::table('productor')
                		->select('id')
                		->where('user_id', '=', $data['id_usuario'])
                		->first();

               	DB::table('users')
                    ->where('id', '=', $data['id_usuario'])
                    ->update(['entidad_predefinida' => 'P',
                    		  'id_entidad_predefinida' => $prod->id]);

            }elseif ($data['importador'] == '1'){
                DB::table('importador')->insertGetId(['user_id' => $data['id_usuario'], 'nombre' => $data['nombre'],
                    'pais_id' => $data['pais_id'], 'provincia_region_id' => $data['provincia_region_id'],
                    'logo' => 'usuario-icono.jpg', 'reclamada' => '1', 'estado_datos' => '0', 'saldo' => '0', 'suscripcion_id' => '0' ]);
            	
            	$imp = DB::table('importador')
                		->select('id')
                		->where('user_id', '=', $data['id_usuario'])
                		->first();

               	DB::table('users')
                    ->where('id', '=', $data['id_usuario'])
                    ->update(['entidad_predefinida' => 'I',
                    		  'id_entidad_predefinida' => $imp->id]);

            }elseif ($data['distribuidor'] == '1'){
                DB::table('distribuidor')->insertGetId(['user_id' => $data['id_usuario'], 'nombre' => $data['nombre'],
                    'pais_id' => $data['pais_id'], 'provincia_region_id' => $data['provincia_region_id'],
                    'logo' => 'usuario-icono.jpg', 'reclamada' => '1', 'estado_datos' => '0', 'saldo' => '0', 'suscripcion_id' => '0' ]);
           		
           		$dist = DB::table('distribuidor')
                		->select('id')
                		->where('user_id', '=', $data['id_usuario'])
                		->first();

               	DB::table('users')
                    ->where('id', '=', $data['id_usuario'])
                    ->update(['entidad_predefinida' => 'D',
                    		  'id_entidad_predefinida' => $dist->id]);

            }elseif ($data['horeca'] == '1'){
                DB::table('horeca')->insertGetId(['user_id' => $data['id_usuario'], 'nombre' => $data['nombre'],
                    'pais_id' => $data['pais_id'], 'provincia_region_id' => $data['provincia_region_id'],
                    'logo' => 'usuario-icono.jpg', 'tipo_horeca' => $data['tipo_horeca'], 'reclamada' => '1', 
                    'estado_datos' => '0', 'saldo' => '0' ]);
            	
            	$hor = DB::table('horeca')
                		->select('id')
                		->where('user_id', '=', $data['id_usuario'])
                		->first();

               	DB::table('users')
                    ->where('id', '=', $data['id_usuario'])
                    ->update(['entidad_predefinida' => 'H',
                    		  'id_entidad_predefinida' => $hor->id]);
            }
            
            Mail::send('emails.confirmarCorreo', ['data' => $data] , function($msj) use ($data){
                $msj->subject('Confirmación de cuenta TooDrinks');
                $msj->to($data['email']);
            });
        }

        /*if ($data['id_entidad'] != '0'){
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
        }*/

        return $user;
    }
}
