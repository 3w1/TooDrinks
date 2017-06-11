<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador;
use App\Models\User;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta;
use App\Models\Destino_Oferta;
use DB; use Auth; use Input; use Image;

class ImportadorController extends Controller
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
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/importadores/';
        $path2 = public_path().'/imagenes/importadores/thumbnails/';
        $nombre = 'importador_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $importador = new Importador($request->all());
        $importador->logo = $nombre;
        $importador->save();

        if ( $request->who == 'U'){
             return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su Importador');
        }else{
            $importador->productores()->attach(session('productorId'));
            $url = 'productor/'.session('productorId');
            return redirect($url)->with('msj', 'Se ha registrado exitosamente su Importador');
        }
    }

    public function show($id)
    {
        $importador = Importador::find($id);
        $cont=0;
        $cont2=0;
        $cont3=0;
        $cont4=0;

        foreach($importador->marcas as $marca)
            $cont++;
        foreach($importador->distribuidores as $distribuidor)
            $cont2++;

        session(['importadorId' => $id]);
        session(['importadorNombre' => $importador->nombre]);
        session(['importadorLogo' => $importador->logo]);

        $ofertas = DB::table('oferta')
                        ->orderBy('titulo')
                        ->select('id')
                        ->where([
                            ['tipo_creador', 'I'],
                            ['creador_id', $id],
                        ])->get();

        foreach($ofertas as $oferta)
            $cont3++;

        $demandas = DB::table('demanda_producto')
                        ->select('id')
                        ->where([
                            ['tipo_creador', 'I'],
                            ['creador_id', $id],
                        ])->get();

        foreach($demandas as $demanda)
            $cont4++;

        return view('importador.show')->with(compact('importador', 'cont', 'cont2', 'cont3', 'cont4'));
    }

    public function edit($id)
    {
        $importador = Importador::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $importador->pais_id)
                        ->pluck('provincia', 'id');

       return view('importador.edit')->with(compact('importador', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $importador = Importador::find($id);
        $importador->fill($request->all());
        $importador->save();

        $url = 'importador/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
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
       
       $url = 'importador/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {

    }

     //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UN DISTRIBUIDOR ASOCIADO
    public function registrar_distribuidor(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarDistribuidor')->with(compact('paises'));
    }

    //FUNCION QUE PERMITE VER LOS DISTRIBUIDORES ASOCIADOS A UN IMPORTADOR
    public function ver_distribuidores(){
        $distribuidores = Importador::find(session('importadorId'))
                                    ->distribuidores()
                                    ->paginate(6);

        return view('importador.listados.distribuidores')->with(compact('distribuidores'));
    }

    //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UNA MARCA
    public function registrar_marca(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarMarca')->with(compact('paises'));
    }
    
     //FUNCION QUE PERMITE VER LAS MARCAS QUE MANEJA UN IMPORTADOR
    public function ver_marcas(){
        $marcas = Importador::find(session('importadorId'))
                                    ->marcas()
                                    ->paginate(6);

        return view('importador.listados.marcas')->with(compact('marcas'));
    }

    public function ver_detalle_marca($id, $nombre){
        $marca = Marca::find($id);

        return view('importador.detalleMarca')->with(compact('marca'));
    }

    //FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UN PRODUCTO ASOCIADO A SU MARCA 
    public function registrar_producto($id, $marca){

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $clases_bebidas = DB::table('clase_bebida')
                    ->orderBy('clase')
                    ->pluck('clase', 'id');

        return view('importador.registrarProducto')->with(compact('id', 'marca', 'paises', 'clases_bebidas'));
    }

    //FUNCION QUE LE PERMITE AL IMPORTADOR VER EL LISTADO DE PRODUCTOS ASOCIADOS A UNA MARCA
    public function ver_productos($id, $marca){
        
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('importador.listados.productos')->with(compact('productos', 'marca'));
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

        return view('importador.detalleProducto')->with(compact('producto', 'bebida', 'productor'));
    }

    public function registrar_oferta($id, $producto){
        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('importador.registrarOferta')->with(compact('id', 'producto', 'paises'));
    }

     //FUNCION QUE PERMITE VER LAS OFERTAS DE UN PRODUCTOR
    public function ver_ofertas(){
        $ofertas = DB::table('oferta')
                    ->where([
                        ['tipo_creador', '=', 'I'],
                        ['creador_id', '=', session('importadorId')],
                    ])
                    ->paginate(6);

        return view('importador.listados.ofertas')->with(compact('ofertas'));
    }

    public function ver_detalle_oferta($id){
        $oferta = Oferta::find($id);

        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('importador.detalleOferta')->with(compact('oferta', 'destinos'));
    }

}
