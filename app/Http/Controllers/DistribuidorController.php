<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribuidor;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta;
use App\Models\Destino_Oferta;
use DB; use Auth; use Input; use Image;

class DistribuidorController extends Controller
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

   /* public function store(Request $request)
    {
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/distribuidores/';
        $path2 = public_path().'/imagenes/distribuidores/thumbnails/';
        $nombre = 'distribuidor_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $distribuidor = new Distribuidor($request->all());
        $distribuidor->logo = $nombre;
        $distribuidor->save();

        if ($request->who == 'U'){
             return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su distribuidor');
        }elseif ($request->who == 'P'){
            $distribuidor->productores()->attach(session('productorId'));
            $url = 'productor/'.session('productorId');
            return redirect($url)->with('msj', 'Se ha registrado exitosamente su distribuidor');
        }elseif ($request->who == 'I'){
            $distribuidor->importadores()->attach(session('importadorId'));
            $url = 'importador/'.session('importadorId');
            return redirect($url)->with('msj', 'Se ha registrado exitosamente su distribuidor');   
        }
    }

    public function show($id)
    {
        $distribuidor = Distribuidor::find($id);
        $cont=0;
        $cont2=0;

        session(['distribuidorId' => $id]);
        session(['distribuidorNombre' => $distribuidor->nombre]);
        session(['distribuidorLogo' => $distribuidor->logo]);

        foreach($distribuidor->marcas as $marca)
            $cont++;

        $ofertas = DB::table('oferta')
                        ->orderBy('titulo')
                        ->select('id')
                        ->where([
                            ['tipo_creador', 'D'],
                            ['creador_id', $id],
                        ])->get();

        foreach($ofertas as $oferta)
            $cont2++;

        return view('distribuidor.show')->with(compact('distribuidor', 'cont', 'cont2'));
    }

    public function edit($id)
    {
        $distribuidor = Distribuidor::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $distribuidor->pais_id)
                        ->pluck('provincia', 'id');

       return view('distribuidor.edit')->with(compact('distribuidor', 'paises', 'provincias')); 
    }

    public function update(Request $request, $id)
    {
        $distribuidor = Distribuidor::find($id);
        $distribuidor->fill($request->all());
        $distribuidor->save();

        $url = 'distribuidor/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
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
       
       $url = 'distribuidor/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {
         
    }*/

    //FUNCION QUE LE PERMITE AL DISTRIBUIDOR REGISTRAR UNA MARCA
   /* public function registrar_marca(){

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('distribuidor.registrarMarca')->with(compact('paises'));
    }*/
    
     //FUNCION QUE PERMITE VER LAS MARCAS QUE MANEJA UN IMPORTADOR
    public function ver_marcas(){
        $marcas = Distribuidor::find(session('perfilId'))
                                    ->marcas()
                                    ->paginate(6);

        return view('distribuidor.listados.marcas')->with(compact('marcas'));
    }

    public function ver_detalle_marca($id, $nombre){
        $perfil = 'D';

        $marca = Marca::find($id);

        return view('distribuidor.detalleMarca')->with(compact('marca', 'perfil'));
    }

     public function listado_marcas(){
        $marcas = DB::table('marca')
                    ->select('marca.*')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '!=', session('perfilId'))
                    ->orwhere('distribuidor_marca.marca_id', '=', null)
                    ->paginate(6);

        return view('distribuidor.listados.marcasDisponibles')->with(compact('marcas'));
    }

    public function asociar_marca($id){
        $marca = Marca::find($id);

        $marca->distribuidores()->attach(session('perfilId'), ['status' => '0']);

        $url = ('distribuidor/mis-marcas');
        return redirect($url)->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');

    }

     //FUNCION QUE LE PERMITE AL DISTRIBUIDOR REGISTRAR UN PRODUCTO ASOCIADO A SU MARCA 
   /* public function registrar_producto($id, $marca){

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $clases_bebidas = DB::table('clase_bebida')
                    ->orderBy('clase')
                    ->pluck('clase', 'id');

        return view('distribuidor.registrarProducto')->with(compact('id', 'marca', 'paises', 'clases_bebidas'));
    }*/

    //FUNCION QUE LE PERMITE AL IMPORTADOR VER EL LISTADO DE PRODUCTOS ASOCIADOS A UNA MARCA
    public function ver_productos($id, $marca){
        
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('distribuidor.listados.productos')->with(compact('productos', 'marca'));
    }

    public function ver_detalle_producto($id, $producto){
        $perfil = 'D';

        $producto = Producto::find($id);
        
        $bebida = Bebida::find($producto->clase_bebida->bebida_id)
                        ->select('nombre', 'caracteristicas')
                        ->get()
                        ->first();

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('distribuidor.detalleProducto')->with(compact('producto', 'bebida', 'productor', 'perfil'));
    }

    public function registrar_oferta($id, $producto){
        if ($id != '0'){
            $tipo = '1';
        }else{
            $tipo = '2';
        }

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

         $marcas = DB::table('marca')
                    ->leftjoin('distribuidor_marca', 'marca.id', '=', 'distribuidor_marca.marca_id')
                    ->where('distribuidor_marca.distribuidor_id', '=', session('perfilId'))
                    ->pluck('marca.nombre', 'marca.id');

        return view('distribuidor.registrarOferta')->with(compact('id', 'producto', 'paises', 'marcas', 'tipo'));
    }

     //FUNCION QUE PERMITE VER LAS OFERTAS DE UN PRODUCTOR
    public function mis_ofertas(){
        $ofertas = DB::table('oferta')
                    ->where([
                        ['tipo_creador', '=', 'D'],
                        ['creador_id', '=', session('perfilId')],
                    ])
                    ->paginate(6);

        return view('distribuidor.listados.ofertas')->with(compact('ofertas'));
    }

    public function ver_detalle_oferta($id){
        $oferta = Oferta::find($id);

        $destinos = Destino_Oferta::where('oferta_id', '=', $id)
                                ->orderBy('provincia_region_id')
                                ->select('pais_id', 'provincia_region_id')
                                ->get();

        return view('distribuidor.detalleOferta')->with(compact('oferta', 'destinos'));
    }

    public function listado_ofertas(){
        $distribuidor = DB::table('distribuidor')
                            ->where('id', '=', session('perfilId') )
                            ->select('pais_id', 'provincia_region_id')
                            ->get()
                            ->first();

        $ofertas = DB::table('oferta')
                    ->select('oferta.*')
                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                    ->where('oferta.visible_distribuidores', '=', '1')
                    ->where('destino_oferta.provincia_region_id', '=', $distribuidor->provincia_region_id)
                    ->paginate(6);

        return view('distribuidor.listados.ofertasDisponibles')->with(compact('ofertas'));
    }

}
