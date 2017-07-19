<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca; use App\Models\Producto;
use App\Models\Productor;
use App\Models\Notificacion_P; use App\Models\Notificacion_I; use App\Models\Notificacion_D;
use DB;

class AdminController extends Controller
{
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

    public function marcas_sin_aprobar(){
        $marcas = Marca::orderBy('nombre')
                    ->where('publicada', '=', '0')
                    ->paginate(7);

        return view('adminWeb.aprobaciones.marcasSinAprobar')->with(compact('marcas'));
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
        $notificacion->creador_id = '0';
        $notificacion->tipo_creador = 'U';
        $notificacion->titulo = 'El administrador Web ha aprobado la publicación de la marca '.$marca->nombre;
        $notificacion->url='marca/'.$marca->id;
        $notificacion->descripcion = 'Nueva Marca';
        $notificacion->color = 'bg-purple';
        $notificacion->icono = 'fa fa-plus-circle';
        $notificacion->tipo ='NM';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();

        return redirect('admin/marcas-sin-aprobar')->with('msj-success', 'La marca ha sido aprobada y publicada exitosamente');
    }

    public function rechazar_marca(Request $request, $id){
       
    }

    public function productos_sin_aprobar(){
        $productos = Producto::orderBy('nombre')
                    ->where('publicado', '=', '0')
                    ->paginate(8);

        return view('adminWeb.aprobaciones.productosSinAprobar')->with(compact('productos'));
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

        //ENVIAR NOTIFICACIÓN DE APROBACIÓN
        //AL CREADOR DEL PRODUCTO
        if ($producto->tipo_creador == 'P'){
            //CREAR NOTIFICACIÓN AL PRODUCTOR
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $producto->productor_id;
            // *** //
        }elseif ($marca->tipo_creador == 'I'){
            //CREAR NOTIFICACIÓN AL IMPORTADOR
            $notificacion = new Notificacion_I();
            $notificacion->importador_id = $producto->creador_id;
            // *** //
        }elseif ($marca->tipo_creador == 'D'){
            //CREAR NOTIFICACIÓN AL DISTRIBUIDOR
            $notificacion = new Notificacion_D();
            $notificacion->distribuidor_id = $producto->creador_id;
            // *** //
        }
        $notificacion->creador_id = '0';
        $notificacion->tipo_creador = 'U';
        $notificacion->titulo = 'El administrador Web ha aprobado la publicación del producto '.$producto->nombre;
        $notificacion->url='producto/'.$producto->id;
        $notificacion->descripcion = 'Nuevo Producto';
        $notificacion->color = 'bg-yellow';
        $notificacion->icono = 'fa fa-plus-square-o';
        $notificacion->tipo ='NP';
        $notificacion->fecha = new \DateTime();
        $notificacion->leida = '0';
        $notificacion->save();
        // *** //
        
        //ENVIAR NOTIFICACIÓN AL PRODUCTOR 
        //PARA QUE CONFIRME EL NUEVO PRODUCTO
        //EN CASO DE QUE NO HAYA SIDO CREADO POR UN PRODUCTOR
        if ($producto->tipo_creador != 'P'){
            $notificacion = new Notificacion_P();
            $notificacion->productor_id = $producto->productor_id;
            $notificacion->creador_id = $producto->creador_id;
            $notificacion->tipo_creador = $producto->tipo_creador;
            $notificacion->titulo = $producto->creador_id.' ha agregado el producto '.$producto->nombre.' a tu marca';
            $notificacion->url='productor/confirmar-productos';
            $notificacion->descripcion = 'Nuevo Producto';
            $notificacion->color = 'bg-yellow';
            $notificacion->icono = 'fa fa-plus-square-o';
            $notificacion->tipo ='NP';
            $notificacion->fecha = new \DateTime();
            $notificacion->leida = '0';
            $notificacion->save();
        }

        return redirect('admin/productos-sin-aprobar')->with('msj', 'El producto ha sido aprobado y publicado exitosamente');
    }

    public function rechazar_producto(Request $request, $id){
       
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

        return redirect('admin/marcas-sin-propietario')->with('msj-success', 'Se ha asociado correctamente el productor a la marca');
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

    public function correo_invitacion(){
        $productores = Productor::where('user_id', '=', '0')
                        ->orderBy('nombre')
                        ->paginate(10);

        return view('adminWeb.perfilesSinUsuario')->with(compact('productores'));
    }
}
