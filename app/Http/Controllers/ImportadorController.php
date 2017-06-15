<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Importador; use App\Models\Distribuidor; use App\Models\User;
use App\Models\Pais; use App\Models\Provincia_Region; use App\Models\Marca;
use App\Models\Producto;
use App\Models\Bebida;
use App\Models\Productor;
use App\Models\Oferta;
use App\Models\Destino_Oferta;
use App\Models\Demanda_Distribuidor;
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
    /*public function registrar_distribuidor(){

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
    }*/
    
     //FUNCION QUE PERMITE VER LAS MARCAS QUE MANEJA UN IMPORTADOR
    public function mis_marcas(){
        $marcas = Importador::find(session('importadorId'))
                                    ->marcas()
                                    ->paginate(6);

        return view('importador.listados.marcas')->with(compact('marcas'));
    }

    public function ver_detalle_marca($id, $nombre){
        $perfil = 'I';

        $marca = Marca::find($id);

        return view('importador.detalleMarca')->with(compact('marca', 'perfil'));
    }

    public function listado_marcas(){
        $marcas = DB::table('marca')
                    ->select('marca.*')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '!=', session('importadorId'))
                    ->orwhere('importador_marca.marca_id', '=', null)
                    ->paginate(6);

        return view('importador.listados.marcasDisponibles')->with(compact('marcas'));
    }

    public function asociar_marca($id){
        $marca = Marca::find($id);

        $marca->importadores()->attach(session('importadorId'), ['status' => '0']);

        $url = ('importador/mis-marcas');
        return redirect($url)->with('msj', 'Se ha agregado la marca a su lista. Debe esperar la confirmación del productor.');

    }

    /*//FUNCION QUE LE PERMITE AL IMPORTADOR REGISTRAR UN PRODUCTO ASOCIADO A SU MARCA 
    public function registrar_producto($id, $marca){

        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        $clases_bebidas = DB::table('clase_bebida')
                    ->orderBy('clase')
                    ->pluck('clase', 'id');

        return view('importador.registrarProducto')->with(compact('id', 'marca', 'paises', 'clases_bebidas'));
    }*/

    //FUNCION QUE LE PERMITE AL IMPORTADOR VER EL LISTADO DE PRODUCTOS ASOCIADOS A UNA MARCA
    public function ver_productos($id, $marca){
        
        $productos = Marca::find($id)
                            ->productos()
                            ->paginate(8);

        return view('importador.listados.productos')->with(compact('productos', 'marca'));
    }

    public function ver_detalle_producto($id, $producto){
        $perfil = 'I';

        $producto = Producto::find($id);
        
        $bebida = Bebida::find($producto->clase_bebida->bebida_id)
                        ->select('nombre', 'caracteristicas')
                        ->get()
                        ->first();

        $productor = Productor::find($producto->marca->productor_id)
                        ->select('nombre')
                        ->get()
                        ->first();

        return view('importador.detalleProducto')->with(compact('producto', 'bebida', 'productor', 'perfil'));
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
                        ->orderBy('nombre')
                        ->where('productor_id', '=', session('productorId'))
                        ->pluck('nombre', 'id');

        return view('importador.registrarOferta')->with(compact('id', 'producto', 'paises', 'marcas', 'tipo'));
    }

     //FUNCION QUE PERMITE VER LAS OFERTAS DE UN PRODUCTOR
    public function mis_ofertas(){
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

    public function listado_ofertas(){
        $importador = DB::table('importador')
                            ->where('id', '=', session('importadorId') )
                            ->select('pais_id')
                            ->get()
                            ->first();

        $ofertas = DB::table('oferta')
                    ->select('oferta.*')
                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                    ->where('oferta.visible_importadores', '=', '1')
                    ->where('destino_oferta.pais_id', '=', $importador->pais_id)
                    ->groupBy('oferta.id')
                    ->paginate(6);

        return view('importador.listados.ofertasDisponibles')->with(compact('ofertas'));
    }

     public function solicitar_distribuidor(){
        $tipo = 'D';

        $marcas = DB::table('marca')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('importadorId'))
                    ->pluck('marca.nombre', 'marca.id');

        $pais_origen = DB::table('importador')
                        ->select('pais_id')
                        ->where('id', '=', session('importadorId'))
                        ->get()
                        ->first();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_origen->pais_id)
                        ->pluck('provincia', 'id');

        return view('importador.solicitarDemanda')->with(compact('tipo', 'marcas', 'provincias'));
    }

    public function ver_demandas_distribuidores(){
        $cont = 0;

        $demandasDistribuidores = Demanda_Distribuidor::where([
                                        ['tipo_creador', '=', 'I'], 
                                        ['creador_id', '=', session('importadorId')]
                                    ])->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('importador.listados.demandasDistribuidores')->with(compact('demandasDistribuidores', 'cont'));
    }

    public function editar_demanda_distribucion($id){
        $demandaDistribuidor = Demanda_Distribuidor::find($id);

        $pais_importador = Importador::where('id', '=', session('importadorId'))
                                    ->select('pais_id')
                                    ->get()
                                    ->first();

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_importador->pais_id)
                        ->pluck('provincia', 'id');
        
        $marcas = DB::table('marca')
                    ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('importadorId'))
                    ->pluck('marca.nombre', 'marca.id');

        return view('importador.editDemandaDist')->with(compact('demandaDistribuidor','marcas', 'provincias'));
    }

    public function listado_distribuidores(){
        $pais_importador = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('importadorId'))
                            ->get()
                            ->first();

        $distribuidores = Distribuidor::orderBy('nombre')
                            ->select('nombre', 'pais_id', 'provincia_region_id', 'logo', 'persona_contacto')
                            ->where('pais_id', '=', $pais_importador->pais_id)
                            ->paginate(6);

        return view('importador.listados.distribuidoresPais')->with(compact('distribuidores'));
    }

}
