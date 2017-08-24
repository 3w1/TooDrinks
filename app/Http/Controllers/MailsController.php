<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productor;
use Mail;
use DB;

class MailsController extends Controller
{
    public function correo_invitacion(Request $request){

        foreach ($request->productores as $prod){
            $productor = Productor::find($prod)->toArray();
            $productor['tipo'] = 'P';

            Mail::send('emails.invitacion', ['productor'=>$productor], function($msj) use ($productor){
                $msj->subject('Invitación a TooDrinks');
                $msj->to($productor['email']);
            });
        }

        return redirect('admin/correo-de-invitacion')->with('msj-success', 'Los correos de invitación han sido enviados exitosamente');
    }

    public function index()
    {
        /*$productor = Productor::find(10)->toArray();
        $productor['tipo'] = 'P';

        Mail::send('emails.confirmacionUsuario',['productor'=>$productor], function($msj) use ($productor){
            $msj->subject('Confirmación de cuenta TooDrinks');
            $msj->to($productor['email']);
        });*/
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
