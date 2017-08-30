<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Marca; use App\Models\Producto;
use App\Models\Productor; use App\Models\Banner; use App\Models\Impresion_Banner;
use App\Models\Notificacion_P; use App\Models\Notificacion_I; use App\Models\Notificacion_D;
use DB; use Input; use Image;

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
                            ->update([ 'productor_id' => $request->productor_id,
                                       'reclamada' => '1'
                                    ]);

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
                    ->pluck('nombre', 'id');

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

    public function listado_productos(){
        $productos = Producto::orderBy('nombre')
                        ->where('id', '<>', '0')
                        ->paginate(7);

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
                        ->select('producto.tipo_creador', 'producto.creador_id', 'producto.nombre', 'producto.id', 'marca.productor_id')
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
        
        //ENVIAR NOTIFICACIÓN AL PRODUCTOR 
        //PARA QUE CONFIRME EL NUEVO PRODUCTO
        //EN CASO DE QUE NO HAYA SIDO CREADO POR UN PRODUCTOR
        if ($producto->tipo_creador != 'P'){
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

    public function confirmar_importadores(){
        $solicitudes = DB::table('importador_marca')
                    ->select('importador_marca.*')
                    ->orderBy('created_at', 'DESC')
                    ->join('marca', 'importador_marca.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', '0')
                    ->where('importador_marca.status', '=', '0')
                    ->paginate(8);

        return view('adminWeb.confirmaciones.confirmarImportadores')->with(compact('solicitudes'));
    }

    public function confirmar_importador($id, $tipo){
        $marca= DB::table('importador_marca')
                ->select('marca.nombre', 'importador_marca.importador_id')
                ->join('marca', 'importador_marca.marca_id', '=', 'marca.id')
                ->where('importador_marca.id','=', $id)
                ->first();

        if ($tipo == 'S'){
            $actualizacion = DB::table('importador_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);

            $productor = Productor::find(0);
            $productor->importadores()->attach($marca->importador_id);

            //NOTIFICAR AL IMPORTADOR
            $notificaciones_importador = new Notificacion_I();
            $notificaciones_importador->creador_id = '0';
            $notificaciones_importador->tipo_creador = 'U';
            $notificaciones_importador->titulo = 'El administrador Web lo ha confirmado como importador de la marca: '. $marca->nombre;
            $notificaciones_importador->url='marca/'.$id;
            $notificaciones_importador->importador_id = $marca->importador_id;
            $notificaciones_importador->descripcion = "Confirmación de Importador";
            $notificaciones_importador->color = 'bg-blue';
            $notificaciones_importador->icono = 'fa fa-thumbs-o-up';
            $notificaciones_importador->fecha = new \DateTime();
            $notificaciones_importador->tipo = 'CI';
            $notificaciones_importador->leida = '0';
            $notificaciones_importador->save();
            // *** //

            return redirect('admin/confirmar-importadores-marcas')->with('msj-success', 'La relación Importador / Marca ha sido confirmada exitosamente');
        }else{
            DB::table('importador_marca')->where('id', '=', $id)->delete();

             //NOTIFICAR AL IMPORTADOR
            $notificaciones_importador = new Notificacion_I();
            $notificaciones_importador->creador_id = '0';
            $notificaciones_importador->tipo_creador = 'U';
            $notificaciones_importador->titulo = 'El administrador Web lo ha denegado como importador de la marca: '. $marca->nombre;
            $notificaciones_importador->url='marca';
            $notificaciones_importador->importador_id = $marca->importador_id;
            $notificaciones_importador->descripcion = "Denegación de Importador";
            $notificaciones_importador->color = 'bg-red';
            $notificaciones_importador->icono = 'fa fa-thumbs-o-down';
            $notificaciones_importador->fecha = new \DateTime();
            $notificaciones_importador->tipo = 'CI';
            $notificaciones_importador->leida = '0';
            $notificaciones_importador->save();
            // *** //

            return redirect('admin/confirmar-importadores-marcas')->with('msj-success', 'La relación Importador / Marca ha sido eliminada exitosamente');
        }
    }

     public function confirmar_distribuidores(){
        $solicitudes = DB::table('distribuidor_marca')
                    ->select('distribuidor_marca.*')
                    ->orderBy('created_at', 'DESC')
                    ->join('marca', 'distribuidor_marca.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', '0')
                    ->where('distribuidor_marca.status', '=', '0')
                    ->paginate(9);

        return view('adminWeb.confirmaciones.confirmarDistribuidores')->with(compact('solicitudes'));
    }

    public function confirmar_distribuidor($id, $tipo){
         $marca= DB::table('distribuidor_marca')
                ->select('marca.nombre', 'distribuidor_marca.distribuidor_id')
                ->join('marca', 'distribuidor_marca.marca_id', '=', 'marca.id')
                ->where('distribuidor_marca.id','=', $id)
                ->first();

        if ($tipo == 'S'){
            $actualizacion = DB::table('distribuidor_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);

            Productor::find(0)->distribuidores()->attach($marca->distribuidor_id);

            //NOTIFICAR AL DISTRIBUIDOR
            $notificaciones_distribuidor = new Notificacion_D();
            $notificaciones_distribuidor->creador_id = '0';
            $notificaciones_distribuidor->tipo_creador = 'U';
            $notificaciones_distribuidor->titulo = 'El administrador Web lo ha confirmado como importador de la marca: '. $marca->nombre;
            $notificaciones_distribuidor->url='marca';
            $notificaciones_distribuidor->distribuidor_id = $marca->distribuidor_id;
            $notificaciones_distribuidor->descripcion = "Confirmación de Distribuidor";
            $notificaciones_distribuidor->color = 'bg-blue';
            $notificaciones_distribuidor->icono = 'fa fa-thumbs-o-up';
            $notificaciones_distribuidor->fecha = new \DateTime();
            $notificaciones_distribuidor->tipo = 'CD';
            $notificaciones_distribuidor->leida = '0';
            $notificaciones_distribuidor->save();
            // *** //

            return redirect('admin/confirmar-distribuidores-marcas')->with('msj-success', 'La relación Distribuidor / Marca ha sido confirmada exitosamente');
        }else{
            DB::table('distribuidor_marca')->where('id', '=', $id)->delete();

            //NOTIFICAR AL DISTRIBUIDOR
            $notificaciones_distribuidor = new Notificacion_D();
            $notificaciones_distribuidor->creador_id = '0';
            $notificaciones_distribuidor->tipo_creador = 'U';
            $notificaciones_distribuidor->titulo = 'El administrador Web lo ha denegado como importador de la marca: '. $marca->nombre;
            $notificaciones_distribuidor->url='marca';
            $notificaciones_distribuidor->distribuidor_id = $marca->distribuidor_id;
            $notificaciones_distribuidor->descripcion = "Denegación de Distribuidor";
            $notificaciones_distribuidor->color = 'bg-red';
            $notificaciones_distribuidor->icono = 'fa fa-thumbs-o-down';
            $notificaciones_distribuidor->fecha = new \DateTime();
            $notificaciones_distribuidor->tipo = 'CD';
            $notificaciones_distribuidor->leida = '0';
            $notificaciones_distribuidor->save();
            // *** //

            return redirect('admin/confirmar-distribuidores-marcas')->with('msj-success', 'La relación Distribuidor / Marca ha sido eliminada exitosamente');
        }
    }

    public function banners_sin_aprobar(){
        $banners = Banner::where('aprobado', '=', '0')
                    ->orderBy('created_at', 'ASC')
                    ->paginate(10);

        return view('adminWeb.aprobaciones.bannersSinAprobar')->with(compact('banners'));
    }

    public function aprobar_banner($id, Request $request){
        //Aprobar Banner desde la página general
        if ($id != '0'){
            $actualizacion = DB::table('banner')
                            ->where('id', '=', $id)
                            ->update(['aprobado' => '1',
                                      'correcciones' => null]);

            $banner = DB::table('banner')
                        ->select('id', 'tipo_creador', 'creador_id', 'titulo')
                        ->where('id', '=', $id)
                        ->first();
        }else{
            //Aprobar Banner desde la modal
            $actualizacion = DB::table('banner')
                            ->where('id', '=', $request->banner_id)
                            ->update(['aprobado' => '1',
                                      'correcciones' => null]);

            $banner = DB::table('banner')
                        ->select('id', 'tipo_creador', 'creador_id', 'titulo')
                        ->where('id', '=', $request->banner_id)
                        ->first();
        }

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

        $notificacion->creador_id = '0';
        $notificacion->tipo_creador = 'U';
        $notificacion->titulo = 'El administrador Web ha aprobado el contenido de tu banner '.$banner->titulo;
        $notificacion->url='banner-publicitario/'.$banner->id;
        $notificacion->descripcion = 'Aprobación de Banner';
        $notificacion->color = 'bg-aqua';
        $notificacion->icono = 'fa fa-plus-circle';
        $notificacion->tipo ='AB';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();

        return redirect('admin/banners-sin-aprobar')->with('msj-success', 'El banner ha sido aprobado exitosamente');
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
        }elseif ($banner->tipo_creador == 'H'){
            //CREAR NOTIFICACIÓN AL HORECA
            $notificacion = new Notificacion_H();
            $notificacion->horeca_id = $banner->creador_id;
            // *** //
        }

        $notificacion->creador_id = '0';
        $notificacion->tipo_creador = 'U';
        $notificacion->titulo = 'El administrador Web ha sugerido cambios para el contenido de tu banner '.$banner->titulo;
        $notificacion->url='banner-publicitario/'.$banner->id;
        $notificacion->descripcion = 'Sugerencias de Banner';
        $notificacion->color = 'bg-orange';
        $notificacion->icono = 'fa fa-edit';
        $notificacion->tipo ='CB';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();

        return redirect('admin/banners-sin-aprobar')->with('msj-success', 'El banner ha sido puesto en revisión. Se ha enviado una notificación a su creador.');
    }

    //Solicitudes de publicación de banners que no han sido programados en el calendario
    public function banners_sin_publicar(){
        $solicitudes = Impresion_Banner::where('publicado', '=', '0')
                    ->orderBy('created_at', 'ASC')
                    ->paginate(10);

        return view('adminWeb.banner.bannersSinPublicar')->with(compact('solicitudes'));
    }

    public function asignar_fecha($id){
        $solicitud = Impresion_Banner::find($id);

        // Establecer el idioma al Español para strftime().
        setlocale( LC_TIME, 'spanish' );
        // Obtenemos el mes actual
        $month = date( 'Y-n' );
        $week = 1;
        for ( $i=1;$i<=date( 't', strtotime( $month ) );$i++ ) {
            $day_week = date( 'N', strtotime( $month.'-'.$i )  );
            $calendar[ $week ][ $day_week ] = date('Y')."-".date('m')."-".$i;
            if ( $day_week == 7 )
                $week++;
        }

        return view('adminWeb.banner.asignarFechas')->with(compact('calendar', 'month', 'solicitud'));
    }

    public function guardar_fechas(Request $request){
        $fin = count($request->fechas)-1;

        $impresion = Impresion_Banner::find($request->solicitud_id);
        $impresion->fecha_inicio = $request->fechas[0];
        $impresion->fecha_fin = $request->fechas[$fin];
        $impresion->publicado = 2;
        $impresion->save();

        $banner = DB::table('banner')
                        ->select('id', 'tipo_creador', 'creador_id', 'titulo')
                        ->where('id', '=', $impresion->banner_id)
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

        $notificacion->creador_id = '0';
        $notificacion->tipo_creador = 'U';
        $notificacion->titulo = 'El administrador Web le ha asignado fechas de publicación a tu banner '.$banner->titulo;
        $notificacion->url='banner-publicitario/detalle-solicitud/'.$request->solicitud_id;
        $notificacion->descripcion = 'Publicación de Banner';
        $notificacion->color = 'bg-green';
        $notificacion->icono = 'fa fa-check';
        $notificacion->tipo ='PB';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();

        return redirect('admin/banners-sin-publicar')->with('msj-success', 'Las fechas para la solicitud de publicación han sido asignadas exitosamente. Se ha enviado una notificación a su creador.');
    }

    //Enviar Correos de Invitación
    public function correo_invitacion(){
        $productores = Productor::where('user_id', '=', '0')
                        ->orderBy('nombre')
                        ->paginate(10);

        return view('adminWeb.perfilesSinUsuario')->with(compact('productores'));
    }
}
