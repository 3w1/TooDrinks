<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner; use App\Models\Impresion_Banner; use App\Models\Banner_Diario;
use App\Models\Notificacion_Admin;
use Input; use Image; use DB; use DateInterval; use Carbon\Carbon;

class BannerController extends Controller
{
    //Pestaña Publicidad / Mis Banners
    public function index(Request $request){
        $banners = Banner::where('tipo_creador', '=', session('perfilTipo'))
                        ->where('creador_id', '=', session('perfilId'))
                        ->nombre($request->get('busqueda'))
                        ->status($request->get('status'))
                        ->orderBy('created_at', 'DESC')
                        ->paginate(9);

        $cont=0;
        foreach ($banners as $b){
            $cont++;
        }

        return view('publicidad.tabs.misBanners')->with(compact('banners', 'cont'));
    }

    //Mostrar detalles del banner para su creador
    public function show($id){
        $banner = Banner::find($id);

        return view('banner.show')->with(compact('banner'));
    }

    public function update(Request $request, $id){
        $fecha = new \DateTime();
        
        $banner = Banner::find($id);
        $banner->fill($request->all());
        $banner->aprobado = '0';
        $banner->save();

        $notificacion_admin = new Notificacion_Admin();
        $notificacion_admin->creador_id = session('perfilId');
        $notificacion_admin->tipo_creador = session('perfilTipo');
        $notificacion_admin->titulo = session('perfilNombre') . ' ha modificado su banner '.$banner->titulo;
        $notificacion_admin->url= 'admin/aprobar-banners';
        $notificacion_admin->admin_id = 0;
        $notificacion_admin->descripcion = 'Banner Modificado';
        $notificacion_admin->color = 'bg-blue';
        $notificacion_admin->icono = 'fa fa-flag';
        $notificacion_admin->fecha = $fecha;
        $notificacion_admin->tipo = 'BM';
        $notificacion_admin->leida = '0';
        $notificacion_admin->save();

        return redirect('banner-publicitario/'.$id)->with('msj', 'Los datos de su banner han sido actualizados con éxito. Debe esperar la revisión del Administrador.');
    }

    public function updateImagen(Request $request){
        $fecha = new \DateTime();

        $file = Input::file('imagen');   
        $image = Image::make(Input::file('imagen'));

        $path = public_path().'/imagenes/banners/';
        $path2 = public_path().'/imagenes/banners/thumbnails/';      
        $nombre = 'banner_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('banner')
                            ->where('id', '=', $request->id)
                            ->update(['imagen' => $nombre,
                                      'aprobado' => '0']);

        $notificacion_admin = new Notificacion_Admin();
        $notificacion_admin->creador_id = session('perfilId');
        $notificacion_admin->tipo_creador = session('perfilTipo');
        $notificacion_admin->titulo = session('perfilNombre') . ' ha modificado la imagen de su banner '.$banner->titulo;
        $notificacion_admin->url= 'admin/aprobar-banners';
        $notificacion_admin->user_id = 0;
        $notificacion_admin->descripcion = 'Banner Modificado';
        $notificacion_admin->color = 'bg-blue';
        $notificacion_admin->icono = 'fa fa-flag';
        $notificacion_admin->fecha = $fecha;
        $notificacion_admin->tipo = 'BM';
        $notificacion_admin->leida = '0';
        $notificacion_admin->save();

        return redirect('banner-publicitario/'.$request->id)->with('msj', 'La imagen de su banner ha sido actualizada con éxito. Debe esperar la revisión del Administrador.');     
    }

    //Pestaña Publicidad / Nuevo Banner
    public function create(){
        return view('publicidad.tabs.nuevoBanner');
    }

    public function store(Request $request){
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
        $banner->admin = 0;
        $banner->save();

        $notificacion_admin = new Notificacion_Admin();
        $notificacion_admin->creador_id = session('perfilId');
        $notificacion_admin->tipo_creador = session('perfilTipo');
        $notificacion_admin->titulo = session('perfilNombre') . ' ha creado un nuevo banner.';
        $notificacion_admin->url= 'admin/aprobar-banners';
        $notificacion_admin->admin_id = 0;
        $notificacion_admin->descripcion = 'Nuevo Banner';
        $notificacion_admin->color = 'bg-purple';
        $notificacion_admin->icono = 'fa fa-flag';
        $notificacion_admin->fecha = $fecha;
        $notificacion_admin->tipo = 'NB';
        $notificacion_admin->leida = '0';
        $notificacion_admin->save();

        return redirect('banner-publicitario')->with('msj', 'Su banner ha sido creado con éxito. Debe esperar la aprobación del Administrador para publicarlo.');
    }

    //Pestña Publicidad / Nueva Publicación
    public function nueva_publicacion(){
        $banners = DB::table('banner')
                    ->where('tipo_creador', '=', session('perfilTipo'))
                    ->where('creador_id', '=', session('perfilId'))
                    ->where('aprobado', '=','1')
                    ->orderBy('titulo')
                    ->pluck('titulo', 'id');

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        return view('publicidad.tabs.nuevaPublicacion')->with(compact('banners', 'paises'));
    }

    public function confirmar_pago($id){
        $act = DB::table('impresion_banner')
                ->where('id', '=', $id)
                ->update(['pagado' => '1']);

        $impresion = Impresion_Banner::select('fecha_inicio', 'tiempo_publicacion', 'banner_id', 'pais_id')
                        ->where('id', '=', $id)
                        ->first();

        $banner_diario = new Banner_Diario();
        $banner_diario->pais_id = $impresion->pais_id;
        $banner_diario->banner_id = $impresion->banner_id;
        $banner_diario->fecha = $impresion->fecha_inicio;
        $banner_diario->imagen = $impresion->banner->imagen;
        $banner_diario->save();

        $fecha1 = new \DateTime($impresion->fecha_inicio);
        $tiempo = ($impresion->tiempo_publicacion * 7);

        for ($i = 1; $i < $tiempo; $i++){
            $fecha1->add(new DateInterval('P1D'));
            $banner_diario = new Banner_Diario();
            $banner_diario->pais_id = $impresion->pais_id;
            $banner_diario->banner_id = $impresion->banner_id;
            $banner_diario->fecha = $fecha1;
            $banner_diario->imagen = $impresion->banner->imagen;
            $banner_diario->save();
        }

        return redirect('banner-publicitario/mis-publicidades')->with('msj', 'Su publicidad ha sido registrada con éxito.');
    }

    //Pestaña Publicidad / Publicaciones en Curso
    public function publicaciones_en_curso(Request $request){
        $fecha = new \DateTime();

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        $publicaciones = Impresion_Banner::select('impresion_banner.*')
                            ->join('banner', 'impresion_banner.banner_id', '=', 'banner.id')
                            ->where('banner.tipo_creador', '=', session('perfilTipo'))
                            ->where('banner.creador_id', '=', session('perfilId'))
                            ->where('impresion_banner.fecha_inicio', '<=', $fecha)
                            ->where('impresion_banner.fecha_fin', '>=', $fecha )
                            ->pais($request->get('pais'))
                            ->orderBy('fecha_inicio', 'ASC')
                            ->paginate(20);
        $cont = 0;
        foreach ($publicaciones as $p){
            $cont++;
        }

        return view('publicidad.tabs.publicacionesEnCurso')->with(compact('publicaciones', 'paises', 'cont'));
    }

     public function historial(Request $request){
        $fecha = new \DateTime();

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        $publicaciones = Impresion_Banner::select('impresion_banner.*')
                            ->join('banner', 'impresion_banner.banner_id', '=', 'banner.id')
                            ->where('banner.tipo_creador', '=', session('perfilTipo'))
                            ->where('banner.creador_id', '=', session('perfilId'))
                            ->pais($request->get('pais'))
                            ->orderBy('fecha_inicio', 'ASC')
                            ->paginate(20);

        $cont = 0;
        foreach ($publicaciones as $p){
            $cont++;
        }

        return view('publicidad.tabs.historialPublicaciones')->with(compact('publicaciones', 'paises', 'cont'));
    }

    //Método para los detalles del Banner en el Módulo del AdminWeb (Aprobar Banner)
    public function detalles($id){
        $banner = Banner::find($id);

        $banner->toArray();

        if ($banner->tipo_creador == 'P'){
           $creador = DB::table('productor')
                        ->select('nombre')
                        ->where('id', '=', $banner->creador_id)
                        ->first(); 
        }elseif ($banner->tipo_creador == 'I'){
            $creador = DB::table('importador')
                        ->select('nombre')
                        ->where('id', '=', $banner->creador_id)
                        ->first(); 
        }elseif ($banner->tipo_creador == 'D'){
            $creador = DB::table('distribuidor')
                        ->select('nombre')
                        ->where('id', '=', $banner->creador_id)
                        ->first(); 
        }elseif ($banner->tipo_creador == 'H'){
            $creador = DB::table('horeca')
                        ->select('nombre')
                        ->where('id', '=', $banner->creador_id)
                        ->first(); 
        }

        $banner['creador'] = $creador->nombre;

        return response()->json(
            $banner
        );
    }

    //Método para los detalles de la solicitud de publicación de un banner 
    //en el Módulo del AdminWeb (Publicar Impresión de Banner)
    public function detalles_solicitud($id){
        $solicitud = Impresion_Banner::find($id);

        $solicitud->toArray();

        return response()->json(
            $solicitud
        );
    }

    public function edit($id)
    {
        
    }

    //Método para cargar las correcciones de una solicitud
    public function cargar_correcciones($id){
        $correcciones = Impresion_Banner::find($id)
                            ->select('banner_id', 'correcciones')
                            ->first();

        return response()->json(
            $correcciones
        ); 
    }

    public function destroy($id)
    {
        //
    }
}
