<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productor; use App\Models\Importador;
use App\Models\Distribuidor; use App\Models\Multinacional;
use App\Models\Horeca;
use Mail;
use DB; use DateTime;
 
class MailsController extends Controller
{
    public function correo_invitacion($tipo, $id){
    	$fecha = new DateTime();
        
        if ($tipo == 'P'){
            $entidad = Productor::find($id)->toArray();
        }elseif ($tipo == 'I'){
        	$entidad = Importador::find($id)->toArray();
        }elseif ($tipo == 'D'){
        	$entidad = Distribuidor::find($id)->toArray();
        }elseif ($tipo == 'M'){
        	$entidad = Multinacional::find($id)->toArray();
        }elseif ($tipo == 'H'){
        	$entidad = Horeca::find($id)->toArray();
        }

        $entidad['tipo'] = $tipo;

        Mail::send('emails.invitacion', ['entidad'=>$entidad], function($msj) use ($entidad){
            $msj->subject('Invitación a TooDrinks');
            $msj->to($entidad['email']);
        });

        if ($tipo == 'P'){
        	 DB::table('productor')
        	->where('id', '=', $id)
        	->update(['invitacion' => '1',
        		      'fecha_invitacion' => $fecha]);

        	return redirect('admin/listado-productores')->with('msj-success', 'El correo de invitación para '.$entidad['nombre'].' ha sido enviado con éxito.');
        }elseif ($tipo == 'I'){
        	DB::table('importador')
        	->where('id', '=', $id)
        	->update(['invitacion' => '1',
        		      'fecha_invitacion' => $fecha]);

        	return redirect('admin/listado-importadores')->with('msj-success', 'El correo de invitación para '.$entidad['nombre'].' ha sido enviado con éxito.');
        }elseif ($tipo == 'M'){
        	DB::table('multinacional')
        	->where('id', '=', $id)
        	->update(['invitacion' => '1',
        		      'fecha_invitacion' => $fecha]);

        	return redirect('admin/listado-multinacionales')->with('msj-success', 'El correo de invitación para '.$entidad['nombre'].' ha sido enviado con éxito.');
        }elseif ($tipo == 'D'){
        	DB::table('distribuidor')
        	->where('id', '=', $id)
        	->update(['invitacion' => '1',
        		      'fecha_invitacion' => $fecha]);

        	return redirect('admin/listado-distribuidores')->with('msj-success', 'El correo de invitación para '.$entidad['nombre'].' ha sido enviado con éxito.');
        }elseif ($tipo == 'H'){
        	DB::table('horeca')
        	->where('id', '=', $id)
        	->update(['invitacion' => '1',
        		      'fecha_invitacion' => $fecha]);

        	return redirect('admin/listado-horecas')->with('msj-success', 'El correo de invitación para '.$entidad['nombre'].' ha sido enviado con éxito.');
        }
    }

    public function index()
    {

    }

    public function registrarse($id){
        return view('auth.register')->with(compact('id'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function notificaciones_Productor(){
        $fecha = new \DateTime();

        $notificaciones_del_dia = DB::table('notificacion_p')
                                    ->select('productor_id')
                                    ->where('fecha','=', $fecha)
                                    ->groupBy ('productor_id')  -> get();

        foreach ($notificaciones_del_dia as $notificacion) {
            $notificacion_por_usuario = DB::table('notificacion_p')
                ->where('fecha', '=', $fecha)
                ->where('productor_id','=', $notificacion->productor_id)
                -> get();
            
            $notificaciones = $notificacion_por_usuario->toArray();

            $usuario = DB::table('productor')
                            ->select('email')
                            ->where('id', '=', $notificacion->productor_id)
                            -> get()->first();
        
            $user=$usuario->email;

            Mail::send('emails.notificaciones',['notificaciones'=>$notificaciones], function($msj) use ($user) {
                $msj->subject('TooDrinks. Notificaciones del Dia.');
                $msj->to($user);
            });
        }

        return redirect('admin')->with('msj-success', 'Las notificaciones diarias de los productores han sido enviadas con éxito.');
    }

    public function notificaciones_Importador(){
        $fecha = new \DateTime();

        $notificaciones_del_dia = DB::table('notificacion_i')
                        ->select('importador_id')
                        ->where('fecha','=', $fecha)
                        ->groupBy ('importador_id')  -> get();

        foreach ($notificaciones_del_dia as $notificacion) {
            $notificacion_por_usuario = DB::table('notificacion_i')
                        ->where('fecha', '=', $fecha)
                        ->where('importador_id','=', $notificacion->importador_id)
                        -> get();
            
            $notificaciones = $notificacion_por_usuario->toArray();

            $usuario = DB::table('importador')
                        ->select('email')
                        ->where('id', '=', $notificacion->importador_id)
                        -> get()->first();
            
            $user=$usuario->email;

            Mail::send('emails.notificaciones',['notificaciones'=>$notificaciones], function($msj) use ($user) {
                $msj->subject('TooDrinks. Notificaciones del Dia.');
                $msj->to($user);
            });
        }

        return redirect('admin')->with('msj-success', 'Las notificaciones diarias de los importadores han sido enviadas con éxito.');
    }

    public function notificaciones_distribuidor(){
        $fecha = new \DateTime();

        $notificaciones_del_dia = DB::table('notificacion_d')
                        ->select('distribuidor_id')
                        ->where('fecha','=', $fecha)
                        ->groupBy ('distribuidor_id')  -> get();

        foreach ($notificaciones_del_dia as $notificacion){
            $notificacion_por_usuario = DB::table('notificacion_d')
                        ->where('fecha', '=', $fecha)
                        ->where('distribuidor_id','=', $notificacion->distribuidor_id)
                        -> get();
            
            $notificaciones = $notificacion_por_usuario->toArray();

            $usuario = DB::table('distribuidor')
                        ->select('email')
                        ->where('id', '=', $notificacion->distribuidor_id)
                        -> get()->first();
                         $user=$usuario->email;

            Mail::send('emails.notificaciones',['notificaciones'=>$notificaciones], function($msj) use ($user) {
                $msj->subject('TooDrinks. Notificaciones del Dia.');
                $msj->to($user);
            });
        }

        return redirect('admin')->with('msj-success', 'Las notificaciones diarias de los distribuidores han sido enviadas con éxito.');
    }
}
