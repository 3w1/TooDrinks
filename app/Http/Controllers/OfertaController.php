<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Destino_Oferta;
use DB;


class OfertaController extends Controller
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
        $oferta = new Oferta($request->all());
        $oferta->save();

        $ult_oferta = DB::table('oferta')
                        ->select('id')
                        ->orderBy('id', 'DESC')
                        ->get()
                        ->first();

        if ( $request->opciones == "P"){
            for ($i=0; $i<count($request->provincias); $i++){
                $destino = new Destino_Oferta();
                $destino->oferta_id = $ult_oferta->id;
                $destino->pais_id = $request->pais_id;
                $destino->provincia_region_id = $request->provincias[$i];
                $destino->save();
            }
        }else{
            $provincias = DB::table('provincia_region')
                            ->select('id')
                            ->where('pais_id', '=', $request->pais_id)
                            ->get();

            foreach ($provincias as $provincia){
                $destino = new Destino_Oferta();
                $destino->oferta_id = $ult_oferta->id;
                $destino->pais_id = $request->pais_id;
                $destino->provincia_region_id = $provincia->id;
                $destino->save();
            }
        }
        
        if ($request->who == 'P'){
            return redirect('productor/mis-ofertas')->with('msj', 'Su oferta ha sido registrada con éxito');
        }elseif ($request->who == 'I'){
            return redirect('importador/mis-ofertas')->with('msj', 'Su oferta ha sido registrada con éxito');
        }elseif ($request->who == 'D'){
            return redirect('distribuidor/mis-ofertas')->with('msj', 'Su oferta ha sido registrada con éxito');
        }
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {   
        $oferta = Oferta::find($id);
        $oferta->fill($request->all());
        $oferta->save();

        if ($request->who == 'P'){
            $url = 'productor/ver-oferta/'.$id;
            return redirect($url)->with('msj', 'Los datos de la oferta han sido actualizados exitosamente');
        }elseif ($request->who == 'I'){
            $url = 'importador/ver-oferta/'.$id;
            return redirect($url)->with('msj', 'Los datos de la oferta han sido actualizados exitosamente');
        }elseif ($request->who == 'D'){
            $url = 'distribuidor/ver-oferta/'.$id;
            return redirect($url)->with('msj', 'Los datos de la oferta han sido actualizados exitosamente');
        }
    }

    public function destroy($id)
    {

    }
}
