<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Producto;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Clase_Bedida;
use App\Models\Bebida;
use DB;

class DemandaProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cont = 0;

        $demandasProductos = Demanda_Producto::where([
                                        ['tipo_creador', '=', session('perfilTipo')], 
                                        ['creador_id', '=', session('perfilId')]
                                    ])->orderBy('created_at', 'ASC')
                                    ->paginate(10);

        return view('demandaProducto.index')->with(compact('demandasProductos', 'cont'));
    }

    public function create()
    {
        $productos = DB::table('producto')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        $bebidas = DB::table('bebida')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        return view('demandaProducto.create')->with(compact('productos', 'bebidas', 'paises'));
    }


    public function store(Request $request)
    {
        $demanda_producto  = new Demanda_Producto($request->all());

        if ($request->tipo_producto == 'P'){
            $destino = DB::table('producto')
                    ->select('pais_id', 'provincia_region_id', 'bebida_id')
                    ->where('id', '=', $request->producto_id)
                    ->get()
                    ->first();

            $demanda_producto->pais_id = $destino->pais_id;
            $demanda_producto->provincia_region_id = $destino->provincia_region_id;
            $demanda_producto->bebida_id = $destino->bebida_id;
        }else{
            $demanda_producto->producto_id = '0';
        }
               
        $demanda_producto->status = '1';
        $demanda_producto ->save();

        return redirect('demanda-producto')->with('msj', 'Se ha creado su solicitud exitosamente.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
       $solicitudProducto = Demanda_Producto::find($id);

        return view('demandaProducto.edit')->with(compact('solicitudProducto')); 
    }

    public function update(Request $request, $id)
    {
        $demanda_producto  = Demanda_Producto::find($id);
        $demanda_producto ->fill($request->all());
        $demanda_producto ->save();

        return redirect('demanda-producto')->with('msj', 'Se han actualizado los datos de tu solicitud exitosamente.');
    }

    public function solicitudes_producto(){

    }
        
    public function destroy($id)
    {

    }
}
