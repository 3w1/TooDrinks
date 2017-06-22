<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor; use App\Models\Pais; use App\Models\Marca; use App\Models\Bebida;
use App\Models\Clase_Bebida; use App\Models\Producto; use App\Models\Oferta;
use App\Models\Destino_Oferta; use App\Models\Demanda_Importador; use App\Models\Demanda_Distribuidor;
use App\Models\Importador; use App\Models\Importador_Marca;
use DB; use Auth; use Session; use Redirect; use Input; use Image;

class ProductorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
       
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {  
        /*$file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/productores/';
        $path2 = public_path().'/imagenes/productores/thumbnails/';
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $productor = new Productor($request->all());
        $productor->logo = $nombre; 
        $productor->save();

        return redirect('usuario')->with('msj', 'Su productor se ha agregado con éxito');*/
    }

    public function show($id)
    {
        $productor = Productor::find($id);
        return view('productor.show')->with(compact('productor'));
    }

    public function edit($id)
    {
       /* $productor = Productor::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $productor->pais_id)
                        ->pluck('provincia', 'id');

       return view('productor.edit')->with(compact('productor','paises', 'provincias'));*/

    }

    public function update(Request $request, $id)
    {
        /*$productor = Productor::find($id);
        $productor->fill($request->all());
        $productor->save();

        $url = 'productor/'.$id.'/edit';
        return redirect($url)->with('msj', 'Sus datos se han actualizado con éxito');*/
    }

    public function updateAvatar(Request $request){
        /*$file = Input::file('logo');   
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
       
       $url = 'productor/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');*/
    }

    public function destroy($id)
    {

    }

    //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN IMPORTADOR DE SU PROPIEDAD
    /*public function registrar_importador(){
        $perfil = 'I';

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('productor.registrarPerfil')->with(compact('perfil', 'paises'));
    }

    //FUNCION QUE PERMITE VER LOS IMPORTADORES ASOCIADOS A UN PRODUCTOR
    public function ver_importadores(){
        
        $importadores = Productor::find(session('productorId'))
                                    ->importadores()
                                    ->paginate(8);

        return view('productor.listados.importadores')->with(compact('importadores'));
    }

    //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN DISTRIBUIDOR DE SU PROPIEDAD
    public function registrar_distribuidor(){
        $perfil = 'D';

       $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('productor.registrarPerfil')->with(compact('perfil', 'paises'));
    }

    //FUNCION QUE PERMITE VER LOS DISTRIBUIDORES ASOCIADOS A UN PRODUCTOR
    public function ver_distribuidores(){
        $distribuidores = Productor::find(session('productorId'))
                                    ->distribuidores()
                                    ->paginate(8);

        return view('productor.listados.distribuidores')->with(compact('distribuidores'));
    }*/

    //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN DISTRIBUIDOR DE SU PROPIEDAD
    public function registrar_marca(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('productor.registrarMarca')->with(compact('paises', 'provincias'));
    }
    
     //FUNCION QUE PERMITE VER LAS MARCAS DE UN PRODUCTOR
    public function ver_marcas(){
        $marcas = Productor::find(session('perfilId'))
                                    ->marcas()
                                    ->paginate(8);

        return view('productor.listados.marcas')->with(compact('marcas'));
    }

    public function ver_detalle_marca($id, $nombre){
        $perfil = 'P';

        $marca = Marca::find($id);

        return view('productor.detalleMarca')->with(compact('marca', 'perfil'));
    }

    public function listado_marcas(){
        $marcas = Marca::orderBy('nombre', 'ASC')
                        ->where('productor_id', '=', '0')
                        ->paginate(6);

        return view('productor.listados.marcasDisponibles')->with(compact('marcas'));
    }

    public function reclamar_marca($id){
        $actualizacion = DB::table('marca')
                            ->where('id', '=', $id)
                            ->update(['productor_id' => session('perfilId'), 'reclamada' => '1' ]);

        return redirect('productor/mis-marcas')->with('msj', 'Se ha agregado exitosamente una marca a su propiedad');
    }

     //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN PRODUCTO ASOCIADO A SU MARCA 
    public function registrar_producto($id, $marca){

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $clases_bebidas = DB::table('clase_bebida')
                    ->orderBy('clase')
                    ->pluck('clase', 'id');


        return view('productor.registrarProducto')->with(compact('id', 'marca', 'paises', 'clases_bebidas'));
    }

    //FUNCION QUE PERMITE VER LOS IMPORTADORES ASOCIADOS A UN PRODUCTOR
    public function ver_productos($id, $marca){
        
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('productor.listados.productos')->with(compact('productos', 'marca'));
    }

    public function ver_detalle_producto($id, $producto){
        $perfil = 'P';

        $producto = Producto::find($id);
        
        $bebida = Bebida::find($producto->clase_bebida->bebida_id)
                        ->select('nombre', 'caracteristicas')
                        ->get()
                        ->first();

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('productor.detalleProducto')->with(compact('producto', 'bebida', 'productor', 'perfil'));
    }

    public function listado_importadores(){
        if ( session('perfilSuscripcion') != 'G'){
            $check = 1;
        }else{
            $check = 0;
        }

        $importadores = Importador::orderBy('nombre')
                            ->select('nombre', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto')
                            ->paginate(6);

        return view('productor.listados.importadoresMundiales')->with(compact('importadores', 'check'));
    }

    public function confirmar_importadores(){
        $solicitudes = DB::table('importador_marca')
                    ->select('importador_marca.*')
                    ->join('marca', 'importador_marca.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', session('perfilId'))
                    ->where('importador_marca.status', '=', '0')
                    ->get();

        return view('productor.solicitudes.importadores')->with(compact('solicitudes'));
    }

    public function confirmar_importador($id, $tipo, $imp){
        if ($tipo == 'S'){
            $actualizacion = DB::table('importador_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);

            $productor = Productor::find(session('perfilId'));

            $productor->importadores()->attach($imp);

            return redirect('productor/confirmar-importadores')->with('msj', 'Solicitud aprobada exitosamente');
        }else{
            DB::table('importador_marca')->where('id', '=', $id)->delete();

            return redirect('productor/confirmar-importadores')->with('msj', 'Solicitud denegada exitosamente');
        }
    }

    public function confirmar_distribuidores(){
        $solicitudes = DB::table('distribuidor_marca')
                    ->select('distribuidor_marca.*')
                    ->join('marca', 'distribuidor_marca.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', session('perfilId'))
                    ->where('distribuidor_marca.status', '=', '0')
                    ->get();

        return view('productor.solicitudes.distribuidores')->with(compact('solicitudes'));
    }

    public function confirmar_distribuidor($id, $tipo, $dist){
        if ($tipo == 'S'){
            $actualizacion = DB::table('distribuidor_marca')
                                ->where('id', '=', $id)
                                ->update(['status' => '1']);

            $productor = Productor::find(session('perfilId'));

            $productor->distribuidores()->attach($dist);

            return redirect('productor/confirmar-distribuidores')->with('msj', 'Solicitud aprobada exitosamente');
        }else{
            DB::table('distribuidor_marca')->where('id', '=', $id)->delete();

            return redirect('productor/confirmar-distribuidores')->with('msj', 'Solicitud denegada exitosamente');
        }
    }

     public function confirmar_productos(){
        $productos = DB::table('producto')
                    ->select('producto.*')
                    ->join('marca', 'producto.marca_id', '=', 'marca.id')
                    ->where('marca.productor_id', '=', session('perfilId'))
                    ->where('producto.confirmado', '=', '0')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);

        return view('productor.solicitudes.productos')->with(compact('productos'));
    }

    public function confirmar_producto($id, $tipo){
        if ($tipo == 'S'){
            $actualizacion = DB::table('producto')
                                ->where('id', '=', $id)
                                ->update(['confirmado' => '1']);

            return redirect('productor/confirmar-productos')->with('msj', 'Producto aprobado exitosamente');
        }else{
            DB::table('producto')->where('id', '=', $id)->delete();

            return redirect('productor/confirmar-productos')->with('msj', 'Producto eliminado exitosamente');
        }
    }
}
