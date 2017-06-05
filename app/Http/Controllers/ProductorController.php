<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;
use App\Models\Pais;
use App\Models\Telefono_Productor;
use App\Models\Marca;
use DB;
use Auth;
use Session;
use Redirect;

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
        $file = $request->file('logo');
        $nombre = 'productor_'.time().'.'.$file->getClientOriginalExtension();
        $path = public_path() . '/imagenes/productores';
        $file->move($path, $nombre);

        $productor = new Productor($request->all());
        $productor->logo = $nombre; 
        $productor->save();

        return redirect('usuario')->with('msj', 'Su productor se ha agregado con éxito');
    }

    public function show($id)
    {
        $productor = Productor::find($id);
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
        foreach($productor->demandas_importadores as $demandaImportador)
            $cont4++;
        foreach($productor->demandas_distribuidores as $demandasDistribuidor)
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
        $imagen = $request->file('logo');

        $nombre = 'productor_'.time().'.'.$imagen->getClientOriginalExtension();
        $path = public_path() . '/imagenes/productores';
        $imagen->move($path, $nombre);

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
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('productor.registrarPerfil')->with(compact('perfil', 'paises', 'provincias'));
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
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        return view('productor.registrarMarca')->with(compact('paises', 'provincias'));
    }
    
     //FUNCION QUE PERMITE VER LAS MARCAS DE UN PRODUCTOR
    public function ver_marcas(){
        $marcas = Productor::find(session('productorId'))
                                    ->marcas()
                                    ->paginate(8);

        return view('productor.listados.marcas')->with(compact('marcas'));
    }

     //FUNCION QUE LE PERMITE AL PRODUCTOR REGISTRAR UN PRODUCTO ASOCIADO A SU MARCA 
    public function registrar_producto($id, $marca){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->select('id', 'pais')
                        ->get();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->select('id', 'provincia')
                        ->get();

        $bebidas = DB::table('clase_bebida')
                        ->orderBy('clase')
                        ->select('id', 'clase')
                        ->get();

        return view('productor.registrarProducto')->with(compact('id', 'marca', 'paises', 'provincias', 'bebidas'));
    }

    //FUNCION QUE PERMITE VER LOS IMPORTADORES ASOCIADOS A UN PRODUCTOR
    public function ver_productos($id, $marca){
        
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('productor.listados.productos')->with(compact('productos', 'marca'));
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

}
