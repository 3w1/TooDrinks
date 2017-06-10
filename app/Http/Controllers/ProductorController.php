<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;
use App\Models\Pais;
use App\Models\Telefono_Productor;
use App\Models\Marca;
use App\Models\Bebida;
use App\Models\Clase_Bebida;
use App\Models\Producto;
use App\Models\Oferta;
use App\Models\Destino_Oferta;
use App\Models\Demanda_Importador; use App\Models\Demanda_Distribuidor;
use DB; use Auth; use Session; use Redirect; use Input; use Image;

class ProductorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $productores = Productor::paginate(1);
        return view('productor.index')->with(compact('productores'));
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

        return view('productor.create')->with(compact('paises', 'provincias'));
    }

    public function store(Request $request)
    {  
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/productores/';
        $path2 = public_path().'/imagenes/productores/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

        $productor = new Productor($request->all());
        $productor->logo = $nombre; 
        $productor->save();

        return redirect('usuario')->with('msj', 'Su productor se ha agregado con éxito');
    }

    public function show($id)
    {
        $productor = Productor::find($id);

        $ofertas = DB::table('oferta')
                    ->select('id')
                    ->where([
                        ['tipo_creador', '=', 'P'],
                        ['creador_id', '=', $id]
                    ])->get();
        $cont=0;
        $cont2=0;
        $cont3=0;
        $cont4=0;

        foreach($productor->marcas as $marca)
            $cont++;
        foreach($productor->importadores as $importador)
            $cont2++;
        foreach($productor->distribuidores as $distribuidor)
            $cont3++;
        foreach($ofertas as $oferta)
            $cont4++;

        session(['productorId' => $id]);
        session(['productorNombre' => $productor->nombre]);
        session(['productorLogo' => $productor->logo]);

        return view('productor.show')->with(compact('productor', 'cont', 'cont2', 'cont3', 'cont4'));
    }

    public function edit($id)
    {
       $productor = Productor::find($id);
       
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

       return view('productor.edit')->with(compact('productor','paises', 'provincias'));

    }

    public function update(Request $request, $id)
    {
        $productor = Productor::find($id);
        $productor->fill($request->all());
        $productor->save();

        $url = 'productor/'.$id.'/edit';
        return redirect($url)->with('msj', 'Sus datos se han actualizado con éxito');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        //Ruta donde queremos guardar las imagenes
        $path = public_path().'/imagenes/productores/';
        $path2 = public_path().'/imagenes/productores/thumbnails/';
        
        //Nombre en el sistema de la imagen
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();
        // Guardar Original
        $image->save($path.$nombre);
        // Cambiar de tamaño
        $image->resize(240,200);
        // Guardar Thumbnail
        $image->save($path2.$nombre);

        $actualizacion = DB::table('productor')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'productor/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {
        $productor = Productor::find($id);
        $productor->delete();

        return redirect()->action('ProductorController@index');
    }

    //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN IMPORTADOR DE SU PROPIEDAD
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

        return view('productor.registrarPerfil')->with(compact('perfil', 'paises', 'provincias'));
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
    }

    //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN DISTRIBUIDOR DE SU PROPIEDAD
    public function registrar_marca(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('productor.registrarMarca')->with(compact('paises', 'provincias'));
    }
    
     //FUNCION QUE PERMITE VER LAS MARCAS DE UN PRODUCTOR
    public function ver_marcas(){
        $marcas = Productor::find(session('productorId'))
                                    ->marcas()
                                    ->paginate(8);

        return view('productor.listados.marcas')->with(compact('marcas'));
    }

    public function ver_detalle_marca($id, $nombre){
        $marca = Marca::find($id);

        return view('productor.detalleMarca')->with(compact('marca'));
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
        $producto = Producto::find($id);
        
        $bebida = Bebida::find($producto->clase_bebida->bebida_id)
                        ->select('nombre', 'caracteristicas')
                        ->get()
                        ->first();

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('productor.detalleProducto')->with(compact('producto', 'bebida', 'productor'));
    }

    public function registrar_oferta($id, $producto){
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('productor.registrarOferta')->with(compact('id', 'producto', 'paises', 'provincias'));
    }

     //FUNCION QUE PERMITE VER LAS OFERTAS DE UN PRODUCTOR
    public function ver_ofertas(){
        $ofertas = DB::table('oferta')
                    ->where([
                        ['tipo_creador', '=', 'P'],
                        ['creador_id', '=', session('productorId')],
                    ])
                    ->paginate(6);

        return view('productor.listados.ofertas')->with(compact('ofertas'));
    }

    public function ver_detalle_oferta($id){
        $oferta = Oferta::find($id);

        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('productor.detalleOferta')->with(compact('oferta', 'destinos'));
    }

    public function solicitar_importador(){
        $tipo = 'I';

        $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->pluck('nombre', 'id');

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('productorId'))
                        ->get()
                        ->first();

        return view('productor.solicitarDemanda')->with(compact('tipo', 'marcas', 'paises', 'pais_origen'));
    }

    public function solicitar_distribuidor(){
        $tipo = 'D';

        $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->select('id', 'nombre')
                    ->get();

        $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('productorId'))
                        ->get()
                        ->first();

        $provincias = DB::table('provincia_region')
                        ->select('id', 'provincia')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_origen->pais_id)
                        ->get();

        return view('productor.solicitarDemanda')->with(compact('tipo', 'marcas', 'provincias'));
    }

    public function ver_demandas_importadores(){

        $cont = 0;

        $demandasImportadores = Demanda_Importador::where('productor_id', '=', session('productorId'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('productor.listados.demandasImportadores')->with(compact('demandasImportadores', 'cont'));

    }

    public function ver_demandas_distribuidores(){

        $cont = 0;

        $demandasDistribuidores = Demanda_Distribuidor::where([
                                        ['tipo_creador', '=', 'P'], 
                                        ['creador_id', '=', session('productorId')]
                                    ])->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('productor.listados.demandasDistribuidores')->with(compact('demandasDistribuidores', 'cont'));
    }

    public function editar_demanda_distribucion($id){
        $demandaDistribuidor = Demanda_Distribuidor::find($id);

        $pais_productor = Productor::where('id', '=', session('productorId'))
                                    ->select('pais_id')
                                    ->get()
                                    ->first();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_productor->pais_id)
                        ->pluck('provincia', 'id');
        
        $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        return view('productor.editDemandaDist')->with(compact('demandaDistribuidor','marcas', 'provincias'));
    }
}
