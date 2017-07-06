<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca; use App\Models\Producto;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminWeb.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function marcas_sin_aprobar(){
        $marcas = Marca::orderBy('nombre')
                    ->where('publicada', '=', '0')
                    ->paginate(9);

        return view('adminWeb.marcasSinAprobar')->with(compact('marcas'));
    }

    public function aprobar_marca($id, Request $request){
        if ($id != '0'){
            $actualizacion = DB::table('marca')
                            ->where('id', '=', $id)
                            ->update(['publicada' => '1']);
        }else{
            $actualizacion = DB::table('marca')
                            ->where('id', '=', $request->marca_id)
                            ->update(['publicada' => '1']);
        }

        return redirect('admin/marcas-sin-aprobar')->with('msj', 'La marca ha sido aprobada y publicada exitosamente');
    }

    public function rechazar_marca(Request $request, $id){
       
    }

    public function productos_sin_aprobar(){
        $productos = Producto::orderBy('nombre')
                    ->where('publicado', '=', '0')
                    ->paginate(8);

        return view('adminWeb.productosSinAprobar')->with(compact('productos'));
    }

    public function aprobar_producto($id, Request $request){
        if ($id != '0'){
            $actualizacion = DB::table('producto')
                            ->where('id', '=', $id)
                            ->update(['publicado' => '1']);
        }else{
            $actualizacion = DB::table('producto')
                            ->where('id', '=', $request->producto_id)
                            ->update(['publicado' => '1']);
        }

        return redirect('admin/productos-sin-aprobar')->with('msj', 'El producto ha sido aprobado y publicado exitosamente');
    }

    public function rechazar_producto(Request $request, $id){
       
    }

    public function marcas_sin_propietario(){
        $marcas = Marca::orderBy('nombre')
                    ->where('productor_id', '=', '0')
                    ->where('publicada', '=', '1')
                    ->paginate(9);

        return view('adminWeb.marcasSinPropietario')->with(compact('marcas'));
    }

    public function asociar_marca_productor(Request $request){
        $actualizacion = DB::table('marca')
                            ->where('id', '=', $request->marca_id)
                            ->update([ 'productor_id' => $request->productor_id,
                                       'reclamada' => '1'
                                    ]);

        return redirect('admin/marcas-sin-propietario')->with('msj', 'Se ha asociado correctamente el productor a la marca');
    }
}
