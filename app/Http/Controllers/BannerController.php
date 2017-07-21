<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner; use App\Models\Impresion_Banner;
use Input; use Image; use DB;

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

        return redirect('banner-publicitario')->with('msj', 'Su banner ha sido creado exitosamente.');
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

        return redirect('banner-publicitario/'.$id)->with('msj', 'Los datos de su banner han sido actualizados correctamente. Debe esperar la revisión del Administrador.');
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

        return redirect('banner-publicitario/'.$request->id)->with('msj', 'La imagen del banner se ha actualizado exitosamente. Debe esperar la revisión del Administrador.');     
    }

    public function solicitar_publicacion($id){
        $banner = Banner::find($id);

        $paises = DB::table('pais')
                    ->orderBy('pais', 'ASC')
                    ->pluck('pais', 'id');

        return view('banner.solicitarPublicacion')->with(compact('banner', 'paises'));
    }

    public function guardar_solicitud(Request $request){
        $impresion_banner = new Impresion_Banner($request->all());
        $impresion_banner->save();

        return redirect('banner-publicitario/mis-solicitudes')->with('msj', 'Su solicitud de publicación ha sido guardada exitosamente. Debe esperar la aprobación del Administrador.');
    }

    //Ver las solicitudes de publicación de banners de la entidad loggeada
    public function solicitudes_publicacion(){
        $solicitudes = Impresion_Banner::select('impresion_banner.*')
                            ->join('banner', 'impresion_banner.banner_id', '=', 'banner.id')
                            ->where('banner.tipo_creador', '=', session('perfilTipo'))
                            ->where('banner.creador_id', '=', session('perfilId'))
                            ->paginate(10);

        return view('banner.solicitudesPublicacion')->with(compact('solicitudes'));
    }

    //Ver detalles de una solicitud
    public function detalle_solicitud($id){
        $solicitud = Impresion_Banner::find($id);

        return view('banner.detalleSolicitud')->with(compact('solicitud'));
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
