<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Productor;
use App\Models\Importador;
use App\Models\Distribuidor;
use App\Models\Horeca;
use DB;
use Auth;
use Input;
use Image;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmar_correo($id, $token){
        $user = User::find($id);
        //$the_user = $user->select()->where('id', '=', $id)->get()->first();

        if ($user->codigo_confirmacion == $token){
            $actualizacion = DB::table('users')
                            ->where('id', '=', $id)
                            ->update(['activado' => '1', 'codigo_confirmacion' => null ]);

            return redirect('usuario')->with('msj', 'Su cuenta ha sido activada exitosamente.');
        }else{
            return redirect('');
        }
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);

        if ($user->productor == '1'){
            $productor = DB::table('productor')
                            ->where('user_id', '=', Auth::user()->id)
                            ->select('id', 'nombre')
                            ->get()
                            ->first();

            session(['productorId' => $productor->id]);
            session(['productorNombre' => $productor->nombre]);
        }

        if ($user->importador == '1'){
            $importador = DB::table('importador')
                            ->where('user_id', '=', Auth::user()->id)
                            ->select('id', 'nombre')
                            ->get()
                            ->first();

            session(['importadorId' => $importador->id]);
            session(['importadorNombre' => $importador->nombre]);
        }

        if ($user->distribuidor == '1'){
            $distribuidor = DB::table('distribuidor')
                            ->where('user_id', '=', Auth::user()->id)
                            ->select('id', 'nombre')
                            ->get()
                            ->first();

            session(['distribuidorId' => $distribuidor->id]);
            session(['distribuidorNombre' => $distribuidor->nombre]);
        }

        if ($user->horeca == '1'){
             $horeca = DB::table('horeca')
                            ->where('user_id', '=', Auth::user()->id)
                            ->select('id', 'nombre')
                            ->get()
                            ->first();

            session(['horecaId' => $horeca->id]);
            session(['horecaNombre' => $horeca->nombre]);
        }

        return view('usuario.index');
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
        return redirect($url)->with('status', 'Sus datos han sido actualizados con éxito');
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

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN PRODUCTOR DE SU PROPIEDAD
    public function registrar_productor(){
        $perfil = 'P';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises'));
    }

    //FUNCION QUE PERMITE VER LOS PRODUCTORES PERTENECIENTES A U USUARIO
    public function ver_productores(){
        $usuario = User::find(Auth::user()->id);

        $productores = DB::table('productor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', Auth::user()->id)
                        ->paginate(4);

        return view('usuario.listados.productores')->with(compact('usuario', 'productores'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN IMPORTADOR DE SU PROPIEDAD
    public function registrar_importador(){
        $perfil = 'I';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises'));
    }

    //FUNCION QUE PERMITE VER LOS IMPORTADORES PERTENECIENTES A U USUARIO
    public function ver_importadores(){
        $usuario = User::find(Auth::user()->id);

        $importadores = DB::table('importador')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', Auth::user()->id)
                        ->paginate(8);

        return view('usuario.listados.importadores')->with(compact('usuario', 'importadores'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN DISTRIBUIDOR DE SU PROPIEDAD
    public function registrar_distribuidor(){
        $perfil = 'D';

       $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises'));
    }

    //FUNCION QUE PERMITE VER LOS DISTRIBUIDORES PERTENECIENTES A U USUARIO
    public function ver_distribuidores(){
        $usuario = User::find(Auth::user()->id);

        $distribuidores = DB::table('distribuidor')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', Auth::user()->id)
                        ->paginate(8);

        return view('usuario.listados.distribuidores')->with(compact('usuario', 'distribuidores'));
    }

    //FUNCION QUE LE PERMITE AL USUARIO REGISTRAR UN HORECA DE SU PROPIEDAD
    public function registrar_horeca(){
        $perfil = 'H';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('usuario.registrarPerfil')->with(compact('perfil', 'paises'));
    }

    //FUNCION QUE PERMITE VER LOS HORECAS PERTENECIENTES A U USUARIO
    public function ver_horecas(){
        $usuario = User::find(Auth::user()->id);

        $horecas = DB::table('horeca')
                        ->orderBy('nombre')
                        ->select('id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id')
                        ->where('user_id', Auth::user()->id)
                        ->paginate(8);

        return view('usuario.listados.horecas')->with(compact('usuario', 'horecas'));
    }

    public function registrar_producto(){
        $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $clases_bebidas = DB::table('clase_bebida')
                    ->orderBy('clase')
                    ->pluck('clase', 'id');

        return view('usuario.registrarProducto')->with(compact('marcas', 'paises', 'clases_bebidas'));
    }

    public function ver_productos(){
        $productos = DB::table('producto')
                    ->orderBy('nombre')
                    ->where([
                            ['tipo_creador', '=', 'U'],
                            ['creador_id', '=', Auth::user()->id],
                        ])
                    ->paginate(6);

        return view('usuario.listados.productos')->with(compact('productos'));
    }

    public function listado_productores(){
        $productores = Productor::orderBy('nombre', 'ASC')
                        ->where('user_id', '=', '0')
                        ->paginate(6);

        return view('usuario.listados.productoresDisponibles')->with(compact('productores'));
    }

    public function reclamar_productor($id){
        $actualizacion = DB::table('productor')
                            ->where('id', '=', $id)
                            ->update(['user_id' => Auth::user()->id ]);

        return redirect('usuario/mis-productores')->with('msj', 'Se ha agregado exitosamente un productor a su propiedad');

    }

    public function listado_importadores(){
        $importadores = Importador::orderBy('nombre', 'ASC')
                        ->where('user_id', '=', '0')
                        ->paginate(6);

        return view('usuario.listados.importadoresDisponibles')->with(compact('importadores'));
    }

    public function reclamar_importador($id){
        $actualizacion = DB::table('importador')
                            ->where('id', '=', $id)
                            ->update(['user_id' => Auth::user()->id ]);

        return redirect('usuario/mis-importadores')->with('msj', 'Se ha agregado exitosamente un importador a su propiedad');
    }

    public function listado_distribuidores(){
        $distribuidores = Distribuidor::orderBy('nombre', 'ASC')
                        ->where('user_id', '=', '0')
                        ->paginate(6);

        return view('usuario.listados.distribuidoresDisponibles')->with(compact('distribuidores'));
    }

    public function reclamar_distribuidor($id){
        $actualizacion = DB::table('distribuidor')
                            ->where('id', '=', $id)
                            ->update(['user_id' => Auth::user()->id ]);

        return redirect('usuario/mis-distribuidores')->with('msj', 'Se ha agregado exitosamente un distribuidor a su propiedad');
    }

    public function listado_horecas(){
        $horecas = Horeca::orderBy('nombre', 'ASC')
                        ->where('user_id', '=', '0')
                        ->paginate(6);

        return view('usuario.listados.horecasDisponibles')->with(compact('horecas'));
    }

    public function reclamar_horeca($id){
        $actualizacion = DB::table('horeca')
                            ->where('id', '=', $id)
                            ->update(['user_id' => Auth::user()->id ]);

        return redirect('usuario/mis-horecas')->with('msj', 'Se ha agregado exitosamente un horeca a su propiedad');
    }
}
