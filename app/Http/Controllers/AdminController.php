<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Marca; use App\Models\Producto; 
use App\Models\Productor; use App\Models\Importador; use App\Models\Distribuidor; use App\Models\Horeca;
use App\Models\Banner; use App\Models\Impresion_Banner; use App\Models\Banner_Diario;
use App\Models\Notificacion_P; use App\Models\Notificacion_I; use App\Models\Notificacion_D;
use DB; use Input; use Image; use DateInterval;

class AdminController extends Controller
{
	// *** MÉTODOS PARA AUTENTICACIÓN *** //
    public function login(){
        return view('adminWeb.login');
    }

    public function loggear(Request $request){
        $user = Admin::where('name', '=', $request->username)
                    ->first();

        if ($user == null){
            return redirect('admin/login')->with('msj', 'El nombre de usuario es incorrecto.');
        }else{
            if ($user->password != $request->password){
                return redirect('admin/login')->with('msj', 'La contraseña es incorrecta.');   
            }else{
                session(['adminId' => $user->id]);
                session(['adminName' => $user->name]);
                session(['adminNombre' => $user->nombre." ".$user->apellido]);
                session(['adminAvatar' => $user->avatar]);
                session(['adminRol' => $user->rol]);
            
                return redirect('admin');
            }
        }
    } 

    public function logout(){
    	session(['adminId' => null]);
        session(['adminName' => null]);
        session(['adminNombre' => null]);
        session(['adminAvatar' => null]);
        session(['adminRol' => null]);

        return redirect('admin/login');
    }
    // **** FIN DE MÉTODOS DE AUTENTICACIÓN **** //

    public function index()
    {
        return view('adminWeb.index');
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

    // *** MÉTODOS PARA MENÚ DE PRODUCTOR *** //
    public function actualizar_productor($id, $nombre_seo)
    {
        $productor = Productor::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $productor->pais_id)
                        ->pluck('provincia', 'id');

       return view('adminWeb.productor.edit')->with(compact('productor','paises', 'provincias'));

    }

    public function productor_update(Request $request, $id)
    {
        $productor = Productor::find($id);
        $productor->fill($request->all());
        $productor->save();

        return redirect('admin/actualizar-productor/'.$productor->id.'/'.$productor->nombre)
            ->with('msj-success', 'Los datos del productor han sido actualizados con éxito.');
    }

    public function productor_updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/productores/';
        $path2 = public_path().'/imagenes/productores/thumbnails/';      
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('productor')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        $productor = DB::table('productor')
                        ->where('id', '=', $request->id)
                        ->select('nombre')
                        ->first();

        return redirect('admin/actualizar-productor/'.$request->id.'/'.$productor->nombre)
            ->with('msj-success', 'La imagen del productor ha sido actualizada con éxito.');
    }
    // **** FIN DE MÉTODOS PARA MENÚ DE PRODUCTOR **** //

    // *** MÉTODOS PARA MENÚ DE IMPORTADOR *** //
    public function actualizar_importador($id, $nombre_seo)
    {
        $importador = Importador::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $importador->pais_id)
                        ->pluck('provincia', 'id');

       return view('adminWeb.importador.edit')->with(compact('importador','paises', 'provincias'));

    }

    public function importador_update(Request $request, $id)
    {
        $importador = Importador::find($id);
        $importador->fill($request->all());
        $importador->save();

        return redirect('admin/actualizar-importador/'.$id.'/'.$importador->nombre)
            ->with('msj-success', 'Los datos del importador han sido actualizados con éxito.');
    }

    public function importador_updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';      
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('importador')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        $importador = DB::table('importador')
                        ->where('id', '=', $request->id)
                        ->select('nombre')
                        ->first();

        return redirect('admin/actualizar-importador/'.$request->id.'/'.$importador->nombre)
            ->with('msj-success', 'La imagen del importador ha sido actualizada con éxito.');
    }
    // **** FIN DE MÉTODOS PARA MENÚ DE IMPORTADOR **** //
    
    // *** MÉTODOS PARA MENÚ DE DISTRIBUIDOR *** //
    public function actualizar_distribuidor($id, $nombre_seo)
    {
        $distribuidor = Distribuidor::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $distribuidor->pais_id)
                        ->pluck('provincia', 'id');

       return view('adminWeb.distribuidor.edit')->with(compact('distribuidor','paises', 'provincias'));

    }

    public function distribuidor_update(Request $request, $id)
    {
        $distribuidor = Distribuidor::find($id);
        $distribuidor->fill($request->all());
        $distribuidor->save();

        return redirect('admin/actualizar-distribuidor/'.$id.'/'.$distribuidor->nombre)
            ->with('msj-success', 'Los datos del distribuidor han sido actualizados con éxito.');
    }

    public function distribuidor_updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/distribuidores/';
        $path2 = public_path().'/imagenes/distribuidores/thumbnails/';      
        $nombre = 'distribuidor_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('distribuidor')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        $distribuidor = DB::table('distribuidor')
                        ->where('id', '=', $request->id)
                        ->select('nombre')
                        ->first();

        return redirect('admin/actualizar-distribuidor/'.$request->id.'/'.$distribuidor->nombre)
            ->with('msj-success', 'La imagen del distribuidor ha sido actualizada con éxito.');
    }
    // **** FIN DE MÉTODOS PARA MENÚ DE DISTRIBUIDOR **** //

    // *** MÉTODOS PARA MENÚ DE HORECA *** //
    public function actualizar_horeca($id, $nombre_seo)
    {
        $horeca = Horeca::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $horeca->pais_id)
                        ->pluck('provincia', 'id');

       return view('adminWeb.horeca.edit')->with(compact('horeca','paises', 'provincias'));

    }

    public function horeca_update(Request $request, $id)
    {
        $horeca = Horeca::find($id);
        $horeca->fill($request->all());
        $horeca->save();

        return redirect('admin/actualizar-horeca/'.$id.'/'.$horeca->nombre)
            ->with('msj-success', 'Los datos del horeca han sido actualizados con éxito.');
    }

    public function horeca_updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';      
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('horeca')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);

        $horeca = DB::table('horeca')
                        ->where('id', '=', $request->id)
                        ->select('nombre')
                        ->first();

        return redirect('admin/actualizar-horeca/'.$request->id.'/'.$horeca->nombre)
            ->with('msj-success', 'La imagen del horeca ha sido actualizada con éxito.');
    }
    // **** FIN DE MÉTODOS PARA MENÚ DE HORECA **** //

    // *** MÉTODOS PARA MENÚ DE MARCAS *** //
    public function crear_marca(){
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('adminWeb.marca.create')->with(compact('paises'));
    }

    public function marca_store(Request $request){        
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

        return redirect('admin/listado-marcas')->with('msj-success', 'La marca ha sido creada con éxito.');
    }

    public function listado_marcas(){
        $marcas = Marca::orderBy('nombre')
                    ->where('id', '<>', 0)
                    ->paginate(8);

        return view('adminWeb.marca.listado')->with(compact('marcas'));
    }

    public function marca_detallada($id, $nombre_seo){
        $marca = Marca::find($id);

        return view('adminWeb.marca.show')->with(compact('marca'));
    }

    public function update_logo_marca(Request $request){
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
        
        return redirect('admin/marca-detallada/'.$request->id.'/'.$request->nombre_seo)->with('msj-success', 'El logo de la marca ha sido actualizado con éxito.');
    }

    public function update_marca(Request $request, $id)
    {
        $marca = Marca::find($id);
        $marca->fill($request->all());
        $marca->save();
        
        return redirect('admin/marca-detallada/'.$id.'/'.$request->nombre_seo)->with('msj-success', 'Los datos de la marca han sido actualizados con éxito.');  
    }

    public function marcas_sin_propietario(){
        $marcas = Marca::orderBy('nombre')
                    ->where('productor_id', '=', '0')
                    ->where('publicada', '=', '1')
                    ->paginate(9);

        return view('adminWeb.marca.marcasSinPropietario')->with(compact('marcas'));
    }

    public function asociar_marca_productor(Request $request){
        $actualizacion = DB::table('marca')
                            ->where('id', '=', $request->marca_id)
                            ->update([ 'productor_id' => $request->productor_id ]);

        $importadores = DB::table('importador_marca')
                            ->where('marca_id', '=', $request->marca_id)
                            ->get();

        foreach ($importadores as $importador)
            Productor::find($request->productor_id)->importadores()->attach($importador->importador_id);

        $distribuidores = DB::table('distribuidor_marca')
                            ->where('marca_id', '=', $request->marca_id)
                            ->get();

        foreach ($distribuidores as $distribuidor)
            Productor::find($request->productor_id)->distribuidores()->attach($distribuidor->distribuidor_id);

        return redirect('admin/marcas-sin-propietario')->with('msj-success', 'Se ha asociado el productor a la marca con éxito.');
    }
    // **** FIN DE MÉTODOS MENÚ MARCAS ****

    // *** MÉTODOS DE MENÚ PRODUCTOS ***
    public function crear_producto(){
        $marcas = DB::table('marca')
                    ->where('id', '<>', '0')
                    ->orderBy('nombre')
                    ->select('nombre', 'id')
                    ->get();

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $tipos_bebidas = DB::table('bebida')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        return view('adminWeb.producto.create')->with(compact('paises', 'marcas', 'tipos_bebidas'));
    }

    public function producto_store(Request $request)
    {
        $fecha = new \DateTime();

        $file = Input::file('imagen');   
        $image = Image::make(Input::file('imagen'));

        $path = public_path().'/imagenes/productos/';
        $path2 = public_path().'/imagenes/productos/thumbnails/';
        $nombre = 'producto_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $producto = new Producto($request->all());
        $producto->imagen = $nombre;
        $producto->save();    
    
        return redirect('admin/listado-productos')->with('msj-success', 'El producto '.$request->nombre.' ha sido creado con éxito.');        
    }

    public function productos_sin_marca(){
        $productos = Producto::orderBy('nombre', 'ASC')
                        ->where('id', '<>', '0')
                        ->where('publicado', '=', '1')
                        ->where('marca_id', '=', '0')
                        ->paginate(9);

        return view('adminWeb.producto.productosSinMarca')->with(compact('productos'));
    }

    public function asociar_producto_marca(Request $request){
        $actualizacion = DB::table('producto')
                            ->where('id', '=', $request->producto_id)
                            ->update([ 'marca_id' => $request->marca_id ]);

        $importadores = DB::table('importador_marca')
                            ->where('marca_id', '=', $request->marca_id)
                            ->get();

        $producto = Producto::find($request->producto_id);

        foreach ($importadores as $importador)
            $producto->importadores()->attach($importador->importador_id);

        $distribuidores = DB::table('distribuidor_marca')
                            ->where('marca_id', '=', $request->marca_id)
                            ->get();

        foreach ($distribuidores as $distribuidor)
            $producto->distribuidores()->attach($distribuidor->distribuidor_id);

        $marca = DB::table('marca')
                    ->select('nombre')
                    ->where('id', '=', $request->marca_id)
                    ->first();

        return redirect('admin/productos-sin-marca')->with('msj-success', 'El producto '.$producto->nombre.' ha sido asociado a la marca '.$marca->nombre.' con éxito.');
    }

    public function listado_productos(){
        $productos = Producto::orderBy('nombre')
                        ->where('id', '<>', '0')
                        ->paginate(9);

        return view('adminWeb.producto.listado')->with(compact('productos'));
    }

    public function producto_detallado($id, $nombre_seo){
        $producto = Producto::find($id);

        return view('adminWeb.producto.show')->with(compact('producto'));
    }

    public function update_logo_producto(Request $request){
        $file = Input::file('imagen');   
        $image = Image::make(Input::file('imagen'));

        $path = public_path().'/imagenes/productos/';
        $path2 = public_path().'/imagenes/productos/thumbnails/';
        $nombre = 'producto_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('producto')
                            ->where('id', '=', $request->id)
                            ->update(['imagen' => $nombre ]);

        return redirect('admin/producto-detallado/'.$request->id.'/'.$request->nombre_seo)->with('msj-success', 'El logo del producto ha sido actualizado con éxito.');
    }

    public function update_producto(Request $request, $id)
    {
        $marca = Producto::find($id);
        $marca->fill($request->all());
        $marca->save();
        
        return redirect('admin/producto-detallado/'.$id.'/'.$request->nombre_seo)->with('msj-success', 'Los datos del producto han sido actualizados con éxito.');  
    }
    // **** FIN DE MÉTODOS MENÚ PRODUCTOS **** //

    // *** MÉTODOS DE MENÚ CONFIRMACIONES *** //
    public function marcas_sin_aprobar(){
        $marcas = Marca::orderBy('nombre')
                    ->where('id', '<>', '0')
                    ->where('publicada', '=', '0')
                    ->paginate(7);

        return view('adminWeb.confirmaciones.marcas')->with(compact('marcas'));
    }

    public function aprobar_marca($id, Request $request){
        //Aprobar Marca desde la página general
        if ($id != '0'){
            $actualizacion = DB::table('marca')
                            ->where('id', '=', $id)
                            ->update(['publicada' => '1']);

            $marca = DB::table('marca')
                        ->select('tipo_creador', 'creador_id', 'nombre', 'id')
                        ->where('id', '=', $id)
                        ->first();
        }else{
            //Aprobar Marca desde la modal
            $actualizacion = DB::table('marca')
                            ->where('id', '=', $request->marca_id)
                            ->update(['publicada' => '1']);

            $marca = DB::table('marca')
                        ->select('tipo_creador', 'creador_id', 'nombre', 'id')
                        ->where('id', '=', $request->marca_id)
                        ->first();
        }

        if ($marca->tipo_creador == 'P'){
            //CREAR NOTIFICACIÓN AL PRODUCTOR
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $marca->creador_id;
            // *** //
        }elseif ($marca->tipo_creador == 'I'){
            //CREAR NOTIFICACIÓN AL IMPORTADOR
            $notificacion = new Notificacion_I();
            $notificacion->importador_id = $marca->creador_id;
            // *** //
        }elseif ($marca->tipo_creador == 'D'){
            //CREAR NOTIFICACIÓN AL DISTRIBUIDOR
            $notificacion = new Notificacion_D();
            $notificacion->distribuidor_id = $marca->creador_id;
            // *** //
        }

        if ( ($marca->tipo_creador != 'AD') && ($marca->tipo_creador != 'SA')){
            $notificacion->creador_id = '0';
            $notificacion->tipo_creador = 'U';
            $notificacion->titulo = 'La publicación de la marca '.$marca->nombre.' ha sido aprobado por el administrador.';
            $notificacion->url='marca/'.$marca->id;
            $notificacion->descripcion = 'Nueva Marca';
            $notificacion->color = 'bg-purple';
            $notificacion->icono = 'fa fa-plus-circle';
            $notificacion->tipo ='NM';
            $notificacion->fecha = new \DateTime();
            $notificacion->leida = '0';
            $notificacion->save();
        }
        
        return redirect('admin/marcas-sin-aprobar')->with('msj-success', 'La marca ha sido aprobada y publicada en los listados con éxito.');
    }

    public function productos_sin_aprobar(){
        $productos = Producto::orderBy('nombre')
                    ->where('id', '<>', '0')
                    ->where('publicado', '=', '0')
                    ->paginate(8);

        return view('adminWeb.confirmaciones.productos')->with(compact('productos'));
    }

    public function aprobar_producto($id, Request $request){
        //Aprobar Producto desde la página general
        if ($id != '0'){
            $actualizacion = DB::table('producto')
                            ->where('id', '=', $id)
                            ->update(['publicado' => '1']);

            $producto = DB::table('producto')
                        ->select('producto.tipo_creador', 'producto.creador_id', 'producto.nombre', 'producto.id', 'producto.marca_id', 'marca.productor_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->where('producto.id', '=', $id)
                        ->first();
        }else{
            //Aprobar Producto desde la modal
            $actualizacion = DB::table('producto')
                            ->where('id', '=', $request->producto_id)
                            ->update(['publicado' => '1']);

            $producto = DB::table('producto')
                        ->select('producto.tipo_creador', 'producto.creador_id', 'producto.nombre', 'producto.id', 'marca.productor_id')
                        ->join('marca', 'producto.marca_id', '=', 'marca.id')
                        ->where('producto.id', '=', $request->producto_id)
                        ->first();
        }

        //ENVIAR NOTIFICACIÓN DE APROBACIÓN AL CREADOR DEL PRODUCTO
        if ($producto->tipo_creador == 'P'){
            //CREAR NOTIFICACIÓN AL PRODUCTOR
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $producto->productor_id;
            // *** //
        }elseif ($producto->tipo_creador == 'I'){
            //CREAR NOTIFICACIÓN AL IMPORTADOR
            $notificacion = new Notificacion_I();
            $notificacion->importador_id = $producto->creador_id;
            // *** //
        }elseif ($producto->tipo_creador == 'D'){
            //CREAR NOTIFICACIÓN AL DISTRIBUIDOR
            $notificacion = new Notificacion_D();
            $notificacion->distribuidor_id = $producto->creador_id;
            // *** //
        }

        if ( ($producto->tipo_creador != 'AD') && ($producto->tipo_creador != 'SA')){
            $notificacion->creador_id = '0';
            $notificacion->tipo_creador = 'U';
            $notificacion->titulo = 'La publicación del producto '.$producto->nombre.' ha sido aprobada por el administrador.';
            $notificacion->url='producto/'.$producto->id;
            $notificacion->descripcion = 'Nuevo Producto';
            $notificacion->color = 'bg-yellow';
            $notificacion->icono = 'fa fa-plus-square-o';
            $notificacion->tipo ='NP';
            $notificacion->fecha = new \DateTime();
            $notificacion->leida = '0';
            $notificacion->save();
        }
        
        // *** //
        
        //ENVIAR NOTIFICACIÓN AL PRODUCTOR PARA QUE CONFIRME EL NUEVO PRODUCTO
        //EN CASO DE QUE EL PRODUCTO SE ENCUENTRE ASIGNADO A UNA MARCA
        if ($producto->marca_id != '0'){
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $producto->productor_id;
            $notificacion->creador_id = $producto->creador_id;
            $notificacion->tipo_creador = $producto->tipo_creador;
            $notificacion->titulo = 'El producto '.$producto->nombre.' ha sido agregado a tu marca.';
            $notificacion->url='productor/confirmar-productos';
            $notificacion->descripcion = 'Nuevo Producto';
            $notificacion->color = 'bg-yellow';
            $notificacion->icono = 'fa fa-plus-square-o';
            $notificacion->tipo ='NP';
            $notificacion->fecha = new \DateTime();
            $notificacion->leida = '0';
            $notificacion->save();
        }

        return redirect('admin/productos-sin-aprobar')->with('msj-success', 'El producto '.$producto->nombre.' ha sido aprobado y publicado en los listados con éxito.');
    }
    // *** FIN DE MÉTODOS PARA EL MENÚ CONFIRMACIONES *** //
    
    // *** MÉTODOS PARA EL MENÚ PUBLICIDAD *** //
    public function crear_banner(){
        return view('adminWeb.banner.create');
    } 

    public function banner_store(Request $request){
        $file = Input::file('imagen');   
        $image = Image::make(Input::file('imagen'));

        $path = public_path().'/imagenes/banners/';
        $path2 = public_path().'/imagenes/banners/thumbnails/';
        $nombre = 'banner_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $banner = new Banner($request->all());
        $banner->imagen = $nombre;
        $banner->save();

        return redirect('admin/banners-por-entidad')->with('msj', 'El banner '.$request->titulo.' ha sido agregado exitosamente');
    } 

    public function editar_banner(Request $request){
        $banners = Banner::entidad($request->get('tipo_entidad'), $request->get('entidad_id'))
                        ->nombre($request->get('busqueda'))
                        ->orderBy('titulo', 'ASC')
                        ->paginate(12);

        return view('adminWeb.banner.edit')->with(compact('banners'));
    }

    public function update_banner(Request $request){
        $banner = Banner::find($request->id);
        $banner->fill($request->all());
        $banner->save();
    
        return redirect('admin/editar-banner')->with('msj-success', 'Los datos del banner han sido actualizados con éxito.');  
    }

    public function update_imagen_banner(Request $request){
        $file = Input::file('imagen');   
        $image = Image::make(Input::file('imagen'));

        $path = public_path().'/imagenes/banners/';
        $path2 = public_path().'/imagenes/banners/thumbnails/';
        $nombre = 'banner_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        DB::table('banner')
            ->where('id', '=', $request->id_banner)
            ->update([ 'imagen' => $nombre]);

        return redirect('admin/editar-banner')->with('msj-success', 'La imagen del banner ha sido cambiado con éxito.');
    }

    public function aprobar_banners(){
        $banners = Banner::where('aprobado', '=', '0')
                    ->orderBy('created_at', 'ASC')
                    ->paginate(10);

        return view('adminWeb.banner.aprobarBanners')->with(compact('banners'));
    }

    public function aprobar_banner($id, Request $request){
        $actualizacion = DB::table('banner')
                            ->where('id', '=', $id)
                            ->update(['aprobado' => '1',
                                      'correcciones' => null]);

        $banner = DB::table('banner')
                        ->select('id', 'tipo_creador', 'creador_id', 'titulo')
                        ->where('id', '=', $id)
                        ->first();
        
        if ($banner->tipo_creador == 'P'){
            //CREAR NOTIFICACIÓN AL PRODUCTOR
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $banner->creador_id;
            // *** //
        }elseif ($banner->tipo_creador == 'I'){
            //CREAR NOTIFICACIÓN AL IMPORTADOR
            $notificacion = new Notificacion_I();
            $notificacion->importador_id = $banner->creador_id;
            // *** //
        }elseif ($banner->tipo_creador == 'D'){
            //CREAR NOTIFICACIÓN AL DISTRIBUIDOR
            $notificacion = new Notificacion_D();
            $notificacion->distribuidor_id = $banner->creador_id;
            // *** //
        }elseif ($banner->tipo_creador == 'H'){
            //CREAR NOTIFICACIÓN AL HORECA
            $notificacion = new Notificacion_H();
            $notificacion->horeca_id = $banner->creador_id;
            // *** //
        }

        $notificacion->creador_id = session('adminId');
        $notificacion->tipo_creador = session('adminRol');
        $notificacion->titulo = 'El administrador Web ha aprobado el contenido de tu banner '.$banner->titulo;
        $notificacion->url='banner-publicitario/'.$banner->id;
        $notificacion->descripcion = 'Aprobación de Banner';
        $notificacion->color = 'bg-aqua';
        $notificacion->icono = 'fa fa-plus-circle';
        $notificacion->tipo ='AB';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();

        return redirect('admin/aprobar-banners')->with('msj-success', 'El banner '.$banner->titulo.' ha sido aprobado con éxito.');
    }

    public function sugerir_correcciones_banner($id){
        $banner = Banner::find($id);

        return view('adminWeb.banner.sugerirCorrecciones')->with(compact('banner'));
    }

    public function guardar_sugerencias_banner(Request $request){
        DB::table('banner')
            ->where('id', '=', $request->banner_id)
            ->update(['aprobado' => '2',
                      'correcciones' => $request->sugerencias]);

        $banner = DB::table('banner')
                        ->select('id', 'tipo_creador', 'creador_id', 'titulo')
                        ->where('id', '=', $request->banner_id)
                        ->first();

        if ($banner->tipo_creador == 'P'){
            //CREAR NOTIFICACIÓN AL PRODUCTOR
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $banner->creador_id;
            // *** //
        }elseif ($banner->tipo_creador == 'I'){
            //CREAR NOTIFICACIÓN AL IMPORTADOR
            $notificacion = new Notificacion_I();
            $notificacion->importador_id = $banner->creador_id;
            // *** //
        }elseif ($banner->tipo_creador == 'D'){
            //CREAR NOTIFICACIÓN AL DISTRIBUIDOR
            $notificacion = new Notificacion_D();
            $notificacion->distribuidor_id = $banner->creador_id;
            // *** //
        }

        $notificacion->creador_id = session('adminId');
        $notificacion->tipo_creador = session('adminRol');
        $notificacion->titulo = 'El administrador Web ha sugerido cambios para el contenido de tu banner '.$banner->titulo;
        $notificacion->url='banner-publicitario/'.$banner->id;
        $notificacion->descripcion = 'Sugerencias de Banner';
        $notificacion->color = 'bg-orange';
        $notificacion->icono = 'fa fa-edit';
        $notificacion->tipo ='CB';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();

        return redirect('admin/aprobar-banners')->with('msj-success', 'La sugerencias para el banner '.$banner->titulo.' han sido guardadas con éxito. El banner ha sido puesto en revisión.');
    }

    public function publicar_banner(Request $request){
        $banners = Banner::entidad($request->get('tipo_entidad'), $request->get('entidad_id'))
                        ->nombre($request->get('busqueda'))
                        ->where('aprobado', '=', '1')
                        ->orderBy('titulo', 'ASC')
                        ->paginate(12);

        return view('adminWeb.banner.publicar')->with(compact('banners'));
    }

    public function guardar_publicacion(Request $request){
        $publicacion = new Impresion_Banner($request->all());
        $publicacion->cantidad_clics = 0;
        $publicacion->pagado = 1;
        $publicacion->admin = 1;
        $publicacion->save();

        $banner_diario = new Banner_Diario();
        $banner_diario->pais_id = $publicacion->pais_id;
        $banner_diario->banner_id = $publicacion->banner_id;
        $banner_diario->fecha = $publicacion->fecha_inicio;
        $banner_diario->save();

        $fecha1 = new \DateTime($publicacion->fecha_inicio);
        $tiempo = ($publicacion->tiempo_publicacion * 7);

        for ($i = 1; $i < $tiempo; $i++){
            $fecha1->add(new DateInterval('P1D'));
            $banner_diario = new Banner_Diario();
            $banner_diario->pais_id = $publicacion->pais_id;
            $banner_diario->banner_id = $publicacion->banner_id;
            $banner_diario->fecha = $fecha1;
            $banner_diario->save();
        }

        if ($request->precio != 0){
            if ($request->tipo_creador == 'P'){
                $saldo = DB::table('productor')
                            ->where('id', '=', $request->creador_id)
                            ->select('saldo')
                            ->first();

                DB::table('productor')
                    ->where('id', '=', $request->creador_id)
                    ->update([ 'saldo' => ($saldo->saldo - $request->precio) ]);
            }elseif ($request->tipo_creador == 'I'){
                $saldo = DB::table('importador')
                            ->where('id', '=', $request->creador_id)
                            ->select('saldo')
                            ->first();

                DB::table('importador')
                    ->where('id', '=', $request->creador_id)
                    ->update([ 'saldo' => ($saldo->saldo - $request->precio) ]);
            }elseif ($request->tipo_creador == 'D'){
                $saldo = DB::table('distribuidor')
                            ->where('id', '=', $request->creador_id)
                            ->select('saldo')
                            ->first();

                DB::table('distribuidor')
                    ->where('id', '=', $request->creador_id)
                    ->update([ 'saldo' => ($saldo->saldo - $request->precio) ]);
            }
        }
        return redirect('admin/publicar-banner')->with('msj-success', 'La publicidad ha sido registrada con éxito.');
    }

    public function publicaciones_en_curso(Request $request){
        $fecha = new \DateTime();

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        $publicaciones = Impresion_Banner::entidad($request->get('tipo_entidad'), $request->get('entidad_id'))
                            ->nombre($request->get('busqueda'))
                            ->pais($request->get('pais'))
                            ->where('fecha_inicio', '<=', $fecha)
                            ->where('fecha_fin', '>=', $fecha )
                            ->orderBy('fecha_inicio', 'ASC')
                            ->paginate(20);

        $cont = 0;

        return view('adminWeb.banner.publicacionesEnCurso')->with(compact('publicaciones', 'paises', 'cont'));
    }

     public function historial_de_publicaciones(Request $request){
        $fecha = new \DateTime();

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        $publicaciones = Impresion_Banner::entidad($request->get('tipo_entidad'), $request->get('entidad_id'))
                            ->nombre($request->get('busqueda'))
                            ->pais($request->get('pais'))
                            ->orderBy('fecha_inicio', 'ASC')
                            ->paginate(20);

        $cont = 0;

        return view('adminWeb.banner.historialPublicaciones')->with(compact('publicaciones', 'paises', 'cont'));
    }
    // **** FIN DE MÉTODOS PARA EL MENÚ PUBLICIDAD **** //
    
    // *** MÉTODOS PARA LAS NOTIFICACIONES *** //
    public function notificaciones(){
        $notificaciones = DB::table('notificacion_admin')
                               ->where('user_id', '=', session('adminId'))
                               ->orderBy('created_at', 'DESC')
                               ->paginate(10);

        return view('adminWeb.notificaciones.listado')->with(compact('notificaciones'));
    }
    
    public function marcar_leida($id){
        $notificacion = DB::table('notificacion_admin')
                            ->select('url')
                            ->where('id', '=', $id)
                            ->first();

        $act = DB::table('notificacion_admin')
                ->where('id', '=', $id)
                    ->update(['leida' => '1']);

        return redirect($notificacion->url);
    }
    // **** FIN MÉTODOS PARA LAS NOTIFICACIONES **** //
    

    // *** MÉTODOS PARA LAS FINANZAS ***//
   	public function agregar_quitar_creditos(){
   		return view('adminWeb.creditos.agregarQuitarCreditos');
   	}

    public function sumar_restar_creditos(Request $request){
    	if ($request->tipo_entidad == 'P'){
    		$saldo = DB::table('productor')
    				->where('id', '=', $request->entidad_id)
    				->select('saldo')
    				->first();

    		DB::table('productor')
    			->where('id', '=', $request->entidad_id)
    			->update(['saldo' => ($saldo->saldo + $request->cantidad_creditos) ]);
    	}elseif ($request->tipo_entidad == 'I'){
    		$saldo = DB::table('importador')
    				->where('id', '=', $request->entidad_id)
    				->select('saldo')
    				->first();

    		DB::table('importador')
    			->where('id', '=', $request->entidad_id)
    			->update(['saldo' => ($saldo->saldo + $request->cantidad_creditos) ]);
    	}elseif ($request->tipo_entidad == 'D'){
    		$saldo = DB::table('distribuidor')
    				->where('id', '=', $request->entidad_id)
    				->select('saldo')
    				->first();

    		DB::table('distribuidor')
    			->where('id', '=', $request->entidad_id)
    			->update(['saldo' => ($saldo->saldo + $request->cantidad_creditos) ]);
    	}

    	return redirect('admin/agregar-quitar-creditos')->with('msj-success', 'Los créditos han sido Agregados / Quitados con éxito.');
    }
}
