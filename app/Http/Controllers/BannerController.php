<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner; use App\Models\Impresion_Banner; use App\Models\Banner_Diario;
use Input; use Image; use DB; use DateInterval;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::where('tipo_creador', '=', session('perfilTipo'))
                        ->where('creador_id', '=', session('perfilId'))
                        ->orderBy('created_at', 'DESC')
                        ->paginate(6);

        return view('banner.index')->with(compact('banners'));
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request)
    {
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

        return redirect('banner-publicitario')->with('msj', 'Su banner ha sido creado con éxito.');
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        return view('banner.show')->with(compact('banner'));
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

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        $banner->fill($request->all());
        $banner->aprobado = '0';
        $banner->save();

        return redirect('banner-publicitario/'.$id)->with('msj', 'Los datos de su banner han sido actualizados con éxito. Debe esperar la revisión del Administrador.');
    }

    public function updateImagen(Request $request){
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

        return redirect('banner-publicitario/'.$request->id)->with('msj', 'La imagen del banner se ha actualizado con éxito. Debe esperar la revisión del Administrador.');     
    }

    public function solicitar_publicacion($id){
        $banner = Banner::find($id);

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        return view('banner.solicitarPublicacion')->with(compact('banner', 'paises'));
    }

    public function consultar_disponibilidad($pais, $dias){
        $fecha_actual = new \DateTime();
        $ultima_fecha = DB::table('banner_diario')
                        ->select('fecha')
                        ->where('pais_id', '=', $pais)
                        ->orderBy('fecha', 'DESC')
                        ->first();

        if ($ultima_fecha != null){
            if ( $ultima_fecha->fecha < date_format($fecha_actual, 'Y-m-d') ){
                $fecha1 = date_format($fecha_actual->add(new DateInterval('P1D')), 'd-m-Y');
            }elseif ( $ultima_fecha->fecha == date_format($fecha_actual, 'Y-m-d')){
                $fecha1 = date_format($fecha_actual->add(new DateInterval('P1D')), 'd-m-Y');
            }elseif ( $ultima_fecha->fecha > date_format($fecha_actual, 'Y-m-d')) {
                $fecha1 = new \DateTime($ultima_fecha->fecha);
                $fecha1->add(new DateInterval('P1D'));
                $fecha1 = date_format($fecha1, 'd-m-Y');
            }
        }else{
            $fecha1 = date_format($fecha_actual->add(new DateInterval('P1D')), 'd-m-Y');
        }

        $cant = $dias-1;
        $dias = 'P'.$cant.'D';
        $fecha2 = new \DateTime($fecha1);
        $fecha2->add(new DateInterval($dias));
        $fecha2 = date_format($fecha2, 'd-m-Y');

        $datos[0] = $fecha1;
        $datos[1] = $fecha2;

        return response()->json(
            $datos
        );
    }

    public function guardar_solicitud(Request $request){
        $impresion_banner = new Impresion_Banner($request->all());
        $impresion_banner->save();

        $ult_Impresion = DB::table('impresion_banner')
                            ->select('id')
                            ->orderBy('created_at', 'DESC')
                            ->first();

        return redirect('banner-publicitario/confirmar-solicitud/'.$ult_Impresion->id)
        ->with('msj', 'Verifica los datos y presiona Pagar para finalizar la solicitud de publicidad');
    }

    public function confirmar_solicitud($id){
        $infoPublicidad = Impresion_Banner::orderBy('created_at', 'DESC')
                            ->first();

        return view('banner.confirmarSolicitud')->with(compact('infoPublicidad'));
    }

    public function confirmar_pago($id){
        $act = DB::table('impresion_banner')
                ->where('id', '=', $id)
                ->update(['pagado' => '1']);

        $impresion = DB::table('impresion_banner')
                        ->select('fecha_inicio', 'tiempo_publicacion', 'banner_id', 'pais_id')
                        ->first();

        $banner_diario = new Banner_Diario();
        $banner_diario->pais_id = $impresion->pais_id;
        $banner_diario->banner_id = $impresion->banner_id;
        $banner_diario->fecha = $impresion->fecha_inicio;
        $banner_diario->save();

        $fecha1 = $fecha2 = new \DateTime($impresion->fecha_inicio);
        for ($i = 1; $i < $impresion->tiempo_publicacion; $i++){
            $fecha1->add(new DateInterval('P1D'));
            $banner_diario = new Banner_Diario();
            $banner_diario->pais_id = $impresion->pais_id;
            $banner_diario->banner_id = $impresion->banner_id;
            $banner_diario->fecha = $fecha1;
            $banner_diario->save();
        }

        return redirect('banner-publicitario/mis-solicitudes')->with('msj', 'La petición de publicidad ha sido almacenada con éxito.');
    }

    //Ver las publicaciones de banners de la entidad loggeada
    public function mis_publicidades(){
        $publicidades = Impresion_Banner::select('impresion_banner.*')
                            ->join('banner', 'impresion_banner.banner_id', '=', 'banner.id')
                            ->where('banner.tipo_creador', '=', session('perfilTipo'))
                            ->where('banner.creador_id', '=', session('perfilId'))
                            ->paginate(10);

        return view('banner.impresionesBanner')->with(compact('publicidades'));
    }

    //Ver detalles de una publicación
    public function detalle_publicacion($id){
        $publicacion = Impresion_Banner::find($id);

        return view('banner.detallePublicacion')->with(compact('publicacion'));
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
