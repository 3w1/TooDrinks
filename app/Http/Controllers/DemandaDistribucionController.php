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
    
    //Pestaña Mis Búsquedas Activas
    public function index(Request $request){
        $demandasDistribuidores = Demanda_Distribuidor::where('tipo_creador', '=', session('perfilTipo')) 
                                        ->where('creador_id', '=', session('perfilId')) 
                                        ->where('status', '=', '1')
                                        ->marca($request->get('marca'))
                                        ->provincia($request->get('provincia'))
                                        ->orderBy('created_at', 'ASC')
                                        ->paginate(12);
        $cont = 0;
        foreach ($demandasDistribuidores as $d){
            $cont++;
        }

        if (session('perfilTipo') == 'P'){
            $marcas = DB::table('marca')
                    ->where('productor_id', '=', session('perfilId'))
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id');
        }elseif (session('perfilTipo') == 'I'){
            $marcas = DB::table('marca')
                    ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->where('importador_marca.status', '=', '1')
                    ->orderBy('marca.nombre', 'ASC')
                    ->pluck('marca.nombre', 'marca.id');
        }

        $provincias = DB::table('provincia_region')
                    ->where('pais_id', '=', session('perfilPais'))
                    ->orderBy('provincia', 'ASC')
                    ->pluck('provincia', 'id');

        return view('distribucion.tabs.busquedasActivas')->with(compact('demandasDistribuidores', 'cont', 'marcas', 'provincias'));
    }

    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Demanda_Distribuidor::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("demanda-distribuidor")->with('msj', 'El status de su demanda ha sido actualizado con éxito. Ahora aparecerá en su Historial de Búsqueda');
    }

    //Pestaña Nueva Búsqueda (Distribución)
    public function create(){   
        if (session('perfilTipo') == 'P'){
            $marcas = DB::table('marca')
                        ->where('productor_id', '=', session('perfilId'))
                        ->orderBy('nombre', 'ASC')
                        ->pluck('nombre', 'id');
        }elseif (session('perfilTipo') == 'I'){
            $marcas = DB::table('marca')
                        ->leftjoin('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                        ->where('importador_marca.importador_id', '=', session('perfilId'))
                        ->orderBy('marca.nombre', 'ASC')
                        ->pluck('marca.nombre', 'marca.id');
        }
       
        $provincias = DB::table('provincia_region')
                        ->where('pais_id', '=', session('perfilPais'))
                        ->orderBy('provincia', 'ASC')
                        ->pluck('provincia', 'id');

        return view('distribucion.tabs.nuevaBusqueda')->with(compact('marcas', 'provincias'));
    }

    public function store(Request $request){
        $fecha = new \DateTime();

         if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Bronce') ){
            $creditos = 1;
        }else{
            $creditos = 0;
        }
        
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

        if ($creditos == '1'){
            return redirect('credito/gastar-creditos-pdd/'.$ult_demanda->id); 
        }else{
            return redirect('demanda-distribuidor')->with('msj', 'Su búsqueda de distribuidor ha sido creada con éxito.');    
        } 
    }

    //Pestaña Historial de Búsqueda
    public function historial(Request $request){
        $demandasDistribuidores = Demanda_Distribuidor::where('tipo_creador', '=', session('perfilTipo')) 
                                        ->where('creador_id', '=', session('perfilId')) 
                                        ->where('status', '=', '0')
                                        ->marca($request->get('marca'))
                                        ->provincia($request->get('provincia'))
                                        ->orderBy('created_at', 'ASC')
                                        ->paginate(12);
        $cont = 0;
        foreach ($demandasDistribuidores as $d){
            $cont++;
        }

        if (session('perfilTipo') == 'P'){
            $marcas = DB::table('marca')
                    ->where('productor_id', '=', session('perfilId'))
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id');
        }elseif (session('perfilTipo') == 'I'){
            $marcas = DB::table('marca')
                    ->join('importador_marca', 'marca.id', '=', 'importador_marca.marca_id')
                    ->where('importador_marca.importador_id', '=', session('perfilId'))
                    ->where('importador_marca.status', '=', '1')
                    ->orderBy('marca.nombre', 'ASC')
                    ->pluck('marca.nombre', 'marca.id');
        }

        $provincias = DB::table('provincia_region')
                    ->where('pais_id', '=', session('perfilPais'))
                    ->orderBy('provincia', 'ASC')
                    ->pluck('provincia', 'id');

        return view('distribucion.tabs.historialBusqueda')->with(compact('demandasDistribuidores', 'cont', 'marcas', 'provincias'));
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

        $demandasDistribuidores = Demanda_Distribuidor::orderBy('created_at', 'DESC')
                                    ->where('provincia_region_id', '=', $provincia_origen->provincia_region_id)
                                    ->where('status', '=', '1')
                                    ->paginate(10);

        return view('demandaDistribucion.demandasDisponibles')->with(compact('demandasDistribuidores'));
    }

    public function show($id)
    {
        $demandaMarcada = DB::table('distribuidor_demanda_distribuidor')
                            ->where('distribuidor_id', '=', session('perfilId'))
                            ->where('demanda_distribuidor_id', '=', $id)
                            ->first();
        if ($demandaMarcada == null){
            $restringido = '1';
        }else{
            $restringido = '0';
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
    public function marcar_demanda($id, $check){
        $fecha = new \DateTime();

        $demanda = Demanda_Distribuidor::find($id);
      
        //Asociar distribuidor a la demanda
        DB::table('distribuidor_demanda_distribuidor')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_distribuidor_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        // ... //
        
        if ($check == '1'){
            //Aumentar el contador de contactos de la demanda
            DB::table('demanda_distribuidor')
            ->where('id', '=', $id)
            ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
            // ... //
            
            return redirect('demanda-distribuidor/'.$id)->with('msj', 'Se ha agregado la demanda de distribuidor a su sección de "Demandas De Interés"');
        }
       
        return redirect('demanda-distribuidor/demandas-disponibles')->with('msj', 'Se ha eliminado la demanda de distribuidor de los listados.');
    }

    public function demandas_interes(){
        $demandas = Demanda_Distribuidor::select('demanda_distribuidor.*')
                        ->join('distribuidor_demanda_distribuidor', 'demanda_distribuidor.id', '=', 'distribuidor_demanda_distribuidor.demanda_distribuidor_id')
                        ->where('distribuidor_demanda_distribuidor.distribuidor_id', '=', session('perfilId'))
                        ->where('distribuidor_demanda_distribuidor.marcada', '=', '1')
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);
        
        return view('demandaDistribucion.demandasDeInteres')->with(compact('demandas'));
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

        return redirect('demanda-distribuidor')->with('msj', 'Los datos de su demanda de distribución han sido actualizados con éxito.');
    }

    public function destroy($id)
    {

    }
}
