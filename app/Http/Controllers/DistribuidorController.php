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
        $paises = DB::table('pais')
                    ->orderBy('pais')
                    ->pluck('pais', 'id');

        return view('adminWeb.perfiles.crearDistribuidor')->with(compact('paises'));
    }

    public function store(Request $request)
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

        return redirect('admin')->with('msj', 'Se ha creado el Distribuidor exitosamente');
    }

    public function show($id)
    {
        $distribuidor = Distribuidor::find($id);
        return view('distribuidor.show')->with(compact('distribuidor'));
    }

    /*public function edit($id)
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

        //Notificar al productor
        $url = 'notificacion/notificar-productor/AD/'.$marca->nombre.'/'.$marca->productor_id;
        return redirect($url);
        // ... //
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
