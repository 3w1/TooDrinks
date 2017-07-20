<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Distribuidor;
use App\Models\Producto;
use App\Models\Pais; use App\Models\Provincia_Region;
use App\Models\Notificacion_D;
use DB;

class DemandaDistribucionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $cont = 0;

        $demandasDistribuidores = Demanda_Distribuidor::where([ 
                                        ['tipo_creador', '=', session('perfilTipo')], 
                                        ['creador_id', '=', session('perfilId')], 
                                    ])
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('demandaDistribucion.index')->with(compact('demandasDistribuidores', 'cont'));
    }

    public function demandas_disponibles(){
        $notificaciones_pendientes_DD = DB::table('notificacion_d')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DD')
                                        ->get();

        foreach ($notificaciones_pendientes_DD as $notificacion){
            $act = DB::table('notificacion_d')
                    ->where('id', '=', $notificacion->id)
                    ->update(['leida' => '1']);
        }

        $provincia_origen = DB::table('distribuidor')
                        ->where('id', '=', session('perfilId'))
                        ->select('provincia_region_id')
                        ->get()
                        ->first();

        $demandasDistribuidores = DB::table('demanda_distribuidor')
                                    ->orderBy('created_at', 'DESC')
                                    ->where('provincia_region_id', '=', $provincia_origen->provincia_region_id)
                                    ->where('status', '=', '1')
                                    ->paginate(10);

        return view('demandaDistribucion.demandasDisponibles')->with(compact('demandasDistribuidores'));
    }


    public function create()
    {   
        if (session('perfilTipo') == 'P'){
            $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

            $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
        }else{
            $pais_origen = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('perfilId'))
                            ->get()
                            ->first();

            $marcas = DB::table('marca')
                        ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->pluck('marca.nombre', 'marca.id');
        }
       
        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_origen->pais_id)
                        ->pluck('provincia', 'id');

        return view('demandaDistribucion.create')->with(compact('marcas', 'provincias'));
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();
        
        $demanda_distribuidor  = new Demanda_Distribuidor($request->all());
        $demanda_distribuidor->fecha = $fecha;
        $demanda_distribuidor->save();

        $marca = DB::table('marca')
                    ->select('nombre')
                    ->where('id', '=', $request->marca_id)
                    ->first();

        $ult_demanda = DB::table('demanda_distribuidor')
                        ->select('id')
                        ->orderBy('created_at', 'DESC')
                        ->first();

        $distribuidores = DB::table('distribuidor')
                        ->select('id')
                        ->where('provincia_region_id', '=', $request->provincia_region_id)
                        ->get();
        $cont = 0;
        foreach ($distribuidores as $distribuidor){
            $cont++;
        }

        if ($cont > 0){
            foreach ($distribuidores as $distribuidor){
                $notificaciones_distribuidor = new Notificacion_D();
                $notificaciones_distribuidor->creador_id = session('perfilId');
                $notificaciones_distribuidor->tipo_creador = session('perfilTipo');
                $notificaciones_distribuidor->distribuidor_id = $distribuidor->id;
                $notificaciones_distribuidor->tipo = 'DD';
                if (session('perfilTipo') == 'P'){
                    $notificaciones_distribuidor->titulo = 'Un productor está en la búsqueda de nuevos distribuidores para su marca '. $marca->nombre;
                }else{
                    $notificaciones_distribuidor->titulo = 'Un importador está en la búsqueda de nuevos distribuidores para su marca '. $marca->nombre;
                }
                
                $notificaciones_distribuidor->url='demanda-distribuidor/'.$ult_demanda->id;
                
                $notificaciones_distribuidor->descripcion = 'Demanda de Distribuidor';
                $notificaciones_distribuidor->color = 'bg-green';
                $notificaciones_distribuidor->icono = 'fa fa-handshake-o';
                $notificaciones_distribuidor->fecha = $fecha;
                $notificaciones_distribuidor->leida ='0';
                $notificaciones_distribuidor->save();
            }
        }

        return redirect('demanda-distribuidor')->with('msj', 'Su demanda de distribuidor ha sido creada exitosamente');
    }

    public function show($id)
    {
        if (session('perfilSuscripcion') != 'Premium'){
            $deduccion = DB::table('deduccion_credito_distribuidor')
                            ->where('distribuidor_id', '=', session('perfilId'))
                            ->where('tipo_deduccion', '=', 'DD')
                            ->where('accion_id', '=', $id)
                            ->first();
            
            if ($deduccion == null){
                $restringido = '1';
            }else{
                $restringido = '0';
            }
        }else{
            $demandaMarcada = DB::table('distribuidor_demanda_distribuidor')
                                ->where('distribuidor_id', '=', session('perfilId'))
                                ->where('demanda_distribuidor_id', '=', $id)
                                ->first();
            if ($demandaMarcada == null){
                $restringido = '1';
            }else{
                $restringido = '0';
            }
        }

        $demandaDistribuidor = Demanda_Distribuidor::find($id);

        $visitas = $demandaDistribuidor->cantidad_visitas + 1;

        $act = DB::table('demanda_distribuidor')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $demandaDistribuidor->cantidad_visitas = $visitas;

        return view('demandaDistribucion.show')->with(compact('demandaDistribuidor', 'restringido'));
    }

    //Marca una demanda de distribuidor "de interes" para la entidad loggeada 
    public function marcar_demanda($id){
        $fecha = new \DateTime();

        $demanda = Demanda_Distribuidor::find($id);
      
        //Asociar distribuidor a la demanda
        DB::table('distribuidor_demanda_distribuidor')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_distribuidor_id' => $id, 'fecha' => $fecha]);    
        // ... //
        
        //Aumentar el contador de contactos de la demanda
        DB::table('demanda_distribuidor')
        ->where('id', '=', $id)
        ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
        // ... //

        return redirect('demanda-distribuidor/'.$id)->with('msj', 'Se ha agregado la demanda de distribuidor a su sección de "Demandas De Interés"');
    }

    public function edit($id)
    {
        $demandaDistribuidor = Demanda_Distribuidor::find($id);

        if (session('perfilTipo') == 'P'){
            $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

            $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->pluck('nombre', 'id');
        }else{
            $pais_origen = DB::table('importador')
                            ->select('pais_id')
                            ->where('id', '=', session('perfilId'))
                            ->get()
                            ->first();

            $marcas = DB::table('marca')
                        ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->pluck('marca.nombre', 'marca.id');
        }

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $pais_origen->pais_id)
                        ->pluck('provincia', 'id');

        return view('demandaDistribucion.edit')->with(compact('demandaDistribuidor', 'marcas', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $demanda_distribuidor = Demanda_Distribuidor::find($id);
       	$demanda_distribuidor->fill($request->all());
        $demanda_distribuidor->save();

        return redirect('demanda-distribuidor')->with('msj', 'Los datos de su demanda de distribución han sido actualizados exitosamente');
    }

    public function destroy($id)
    {

    }
}
