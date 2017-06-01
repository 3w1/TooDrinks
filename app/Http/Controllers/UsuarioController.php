<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use DB;
use Auth;
use Input;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        $cont=0;
        $cont2=0;
        $cont3=0;
        $cont4=0;

        foreach($user->productores as $productor)
            $cont++;
        foreach($user->importadores as $importador)
            $cont2++;
        foreach($user->distribuidores as $distribuidor)
            $cont3++;
        foreach($user->horecas as $horeca)
            $cont4++;

        return view('usuario.index')->with(compact('user', 'cont', 'cont2', 'cont3', 'cont4'));
        //$usuarios = User::paginate(5);
        //return view('usuario.index')->with(compact('usuarios'));

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
        $file = $request->file('avatar');
        $nombre = 'usuario_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/usuarios';
        $file->move($path, $nombre);

        $usuario = new User($request->all());
        $usuario->avatar = $nombre;
        $usuario->save();
        return redirect()->action('UsuarioController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
       $usuario = User::find($id);
       
       $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

       return view('usuario.edit')->with(compact('usuario', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        
        $usuario = User::find($id);
        $usuario->fill($request->all());
        $usuario->save();

        $url = 'usuario/'.Auth::user()->id.'/edit';
        return redirect($url)->with('status', 'Sus datos han sido actualizados con éxito');
    }

    public function updateAvatar(Request $request){

        $imagen = $request->file('avatar');

        $nombre = 'usuario_'.time().'.'.$imagen->getClientOriginalExtension();
        $path = public_path() . '/imagenes/usuarios';
        $imagen->move($path, $nombre);

        $actualizacion = DB::table('users')
                            ->where('id', '=', Auth::user()->id)
                            ->update(['avatar' => $nombre ]);
       
       $url = 'usuario/'.Auth::user()->id.'/edit';
       return redirect($url)->with('status', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->delete();

        return redirect()->action('UsuarioController@index');

    }

    //FUNCION QUE PERMITE VER LOS PRODUCTORES PERTENECIENTES A U USUARIO
    public function ver_productores($id){
        $usuario = User::find($id);

        $productores = DB::table('productor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $id)
                        ->paginate(4);

        return view('usuario.listados.productores')->with(compact('usuario', 'productores'));
    }

    //FUNCION QUE PERMITE VER LOS IMPORTADORES PERTENECIENTES A U USUARIO
    public function ver_importadores($id){
        $usuario = User::find($id);

        $importadores = DB::table('importador')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $id)
                        ->paginate(8);

        return view('usuario.listados.importadores')->with(compact('usuario', 'importadores'));
    }

    //FUNCION QUE PERMITE VER LOS DISTRIBUIDORES PERTENECIENTES A U USUARIO
    public function ver_distribuidores($id){
        $usuario = User::find($id);

        $distribuidores = DB::table('distribuidor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $id)
                        ->paginate(8);

        return view('usuario.listados.distribuidores')->with(compact('usuario', 'distribuidores'));
    }

    //FUNCION QUE PERMITE VER LOS HORECAS PERTENECIENTES A U USUARIO
    public function ver_horecas($id){
        $usuario = User::find($id);

        $horecas = DB::table('horeca')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', $id)
                        ->paginate(8);

        return view('usuario.listados.horecas')->with(compact('usuario', 'horecas'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN PRODUCTOR DE SU PROPIEDAD
    public function registrar_productor(){
        $perfil = 'P';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises', 'provincias'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN IMPORTADOR DE SU PROPIEDAD
    public function registrar_importador(){
        $perfil = 'I';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises', 'provincias'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN DISTRIBUIDOR DE SU PROPIEDAD
    public function registrar_distribuidor(){
        $perfil = 'D';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises', 'provincias'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN HORECA DE SU PROPIEDAD
    public function registrar_horeca(){
        $perfil = 'H';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises', 'provincias'));
    }
}
