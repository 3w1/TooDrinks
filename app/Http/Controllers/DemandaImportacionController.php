<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda_Importador;
use App\Models\Producto;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Notificacion_I;
use DB;

class DemandaImportacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //Pestaña Mis Búsquedas Activas
    public function index(Request $request)
    {
        $demandasImportadores = Demanda_Importador::where('productor_id', '=', session('perfilId'))
                                    ->where('status', '=', '1')
                                    ->marca($request->get('marca'))
                                    ->pais($request->get('pais'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        $cont = 0;
        foreach ($demandasImportadores as $d){
            $cont++;
        }

        $marcas = DB::table('marca')
                    ->where('productor_id', '=', session('perfilId'))
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id');

        $paises_posibles = DB::table('pais')
                    ->select('pais.id')
                    ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                    ->where('productor_pais.productor_id', '=', session('perfilId'))
                    ->first();

        if ($paises_posibles == null){
            $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->where('id', '<>', session('perfilPais'))
                        ->pluck('pais', 'id');
        }else{
            $paises = DB::table('pais')
                        ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                        ->where('productor_pais.productor_id', '=', session('perfilId'))
                        ->where('productor_pais.pais_id', '<>', session('perfilPais'))
                        ->orderBy('pais.pais')
                        ->pluck('pais.pais', 'pais.id');
        }

        return view('exportacion.tabs.busquedasActivas')->with(compact('demandasImportadores', 'cont', 'marcas', 'paises'));
    }

    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Demanda_Importador::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("demanda-importador")->with('msj', 'El status de su demanda ha sido actualizado con éxito. Ahora aparecerá en su Historial de Búsquedas.');
    }

    //Pestaña Productor / Exportación / Nueva Búsqueda
    public function create(){
        $marcas = DB::table('marca')
                    ->where('productor_id', '=', session('perfilId'))
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id');

        $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

        $paises_posibles = DB::table('pais')
                    ->select('pais.id')
                    ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                    ->where('productor_pais.productor_id', '=', session('perfilId'))
                    ->first();

        if ($paises_posibles == null){
            $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->where('id', '<>', session('perfilPais'))
                        ->pluck('pais', 'id');
        }else{
            $paises = DB::table('pais')
                        ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                        ->where('productor_pais.productor_id', '=', session('perfilId'))
                        ->where('productor_pais.pais_id', '<>', session('perfilPais'))
                        ->orderBy('pais.pais')
                        ->pluck('pais.pais', 'pais.id');
        }

        return view('exportacion.tabs.nuevaBusqueda')->with(compact('marcas', 'paises'));
    }

    public function store(Request $request){
        $fecha = new \DateTime();

        if ( (session('perfilSuscripcion') == 'Gratis') || (session('perfilSuscripcion') == 'Bronce') ){
            $creditos = 1;
        }else{
            $creditos = 0;
        }

        $demanda_importador = new Demanda_Importador($request->all());
        $demanda_importador->fecha = $fecha;
        $demanda_importador->save();

        $marca = DB::table('marca')
                    ->select('nombre')
                    ->where('id', '=', $request->marca_id)
                    ->first();

        $ult_demanda = DB::table('demanda_importador')
                        ->select('id')
                        ->orderBy('created_at', 'DESC')
                        ->first();

        $importadores = DB::table('importador')
                        ->select('id')
                        ->where('pais_id', '=', $request->pais_id)
                        ->get();
        $cont = 0;
        foreach ($importadores as $importador){
            $cont++;
        }

        if ($cont > 0){
            foreach ($importadores as $importador){
                $notificaciones_importador = new Notificacion_I();
                $notificaciones_importador->creador_id = session('perfilId');
                $notificaciones_importador->tipo_creador = session('perfilTipo');
                $notificaciones_importador->titulo = 'Un productor está en la búsqueda de nuevos importadores para su marca '. $marca->nombre;
                $notificaciones_importador->url='demanda-importador/'.$ult_demanda->id;
                $notificaciones_importador->importador_id = $importador->id;
                $notificaciones_importador->descripcion = 'Demanda de Importador';
                $notificaciones_importador->color = 'bg-orange';
                $notificaciones_importador->icono = 'fa fa-handshake-o';
                $notificaciones_importador->tipo ='DI';
                $notificaciones_importador->fecha = $fecha;
                $notificaciones_importador->leida ='0';
                $notificaciones_importador->save();
            }
        }
        
        if ($creditos == '1'){
            return redirect('credito/gastar-creditos-pdi/'.$ult_demanda->id); 
        }else{
            return redirect('demanda-importador')->with('msj', 'Su búsqueda de importador ha sido creada con éxito.');    
        } 
    }

    //Pestaña Productor / Exportación / Historial
    public function historial(Request $request){
        $demandasImportadores = Demanda_Importador::where('productor_id', '=', session('perfilId'))
                                    ->where('status', '=', '0')
                                    ->marca($request->get('marca'))
                                    ->pais($request->get('pais'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        $cont = 0;
        foreach ($demandasImportadores as $d){
            $cont++;
        }

        $marcas = DB::table('marca')
                    ->where('productor_id', '=', session('perfilId'))
                    ->orderBy('nombre', 'ASC')
                    ->pluck('nombre', 'id');

        $paises_posibles = DB::table('pais')
                    ->select('pais.id')
                    ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                    ->where('productor_pais.productor_id', '=', session('perfilId'))
                    ->first();

        if ($paises_posibles == null){
            $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->where('id', '<>', session('perfilPais'))
                        ->pluck('pais', 'id');
        }else{
            $paises = DB::table('pais')
                        ->join('productor_pais', 'pais.id', '=', 'productor_pais.pais_id')
                        ->where('productor_pais.productor_id', '=', session('perfilId'))
                        ->where('productor_pais.pais_id', '<>', session('perfilPais'))
                        ->orderBy('pais.pais')
                        ->pluck('pais.pais', 'pais.id');
        }

        return view('exportacion.tabs.historialBusqueda')->with(compact('demandasImportadores', 'cont', 'marcas', 'paises'));
    }

    //Pestaña Importador / Solicitudes / Importación
    public function demandas_disponibles(){
        $demandasImportadores = Demanda_Importador::orderBy('created_at', 'DESC')
                                ->where('pais_id', '=', session('perfilPais'))
                                ->where('status', '=', '1')
                                ->paginate(10);
        $cont=0;
        foreach ($demandasImportadores as $demandaImportador){
            $existe = DB::table('importador_marca')
                    ->where('importador_id', '=', session('perfilId'))
                    ->where('marca_id', '=', $demandaImportador->marca_id)
                    ->first();

            if ($existe == null){
                $relacion = DB::table('importador_demanda_importador')
                            ->select('demanda_importador_id')
                            ->where('demanda_importador_id', '=', $demandaImportador->id)
                            ->where('importador_id', '=', session('perfilId'))
                            ->first();

                if ($relacion == null){
                    $cont++;
                }
            }
        } 

        return view('solicitudes.tabsImportador.importacion')->with(compact('demandasImportadores', 'cont'));
    }

    //Ver detalles de demanda para un Importador Intereresado
    public function show($id){
        $demandaMarcada = DB::table('importador_demanda_importador')
                            ->where('importador_id', '=', session('perfilId'))
                            ->where('demanda_importador_id', '=', $id)
                            ->first();
        if ($demandaMarcada == null){
            $restringido = '1';
        }else{
            $restringido = '0';
        }
        
        $demandaImportador = Demanda_Importador::find($id);

        $visitas = $demandaImportador->cantidad_visitas + 1;

        $act = DB::table('demanda_importador')
                ->where('id', '=', $id)
                ->update(['cantidad_visitas' => $visitas ]);

        $demandaImportador->cantidad_visitas = $visitas;

        return view('demandaImportacion.show')->with(compact('demandaImportador', 'restringido'));
    }

    //Marca una demanda de importador "de interes" o "no me interesa" para la entidad loggeada 
    public function marcar_demanda($id, $check){
        $fecha = new \DateTime();

        $demanda = Demanda_Importador::find($id);
      
        //Asociar importador a la demanda
        DB::table('importador_demanda_importador')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_importador_id' => $id, 'fecha' => $fecha, 'marcada' => $check]);    
        // ... //
        
        if ($check == '1'){
            //Aumentar el contador de contactos de la demanda
            DB::table('demanda_importador')
            ->where('id', '=', $id)
            ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
            // ... //
            return redirect('demanda-importador/'.$id)->with('msj', 'Se ha agregado la demanda de importador a su historial de demandas.');
        }
        
        return redirect('demanda-importador/demandas-disponibles')->with('msj', 'Se ha eliminado la demanda de importador de los listados.');
    }

    public function edit($id){

    }

    public function update(Request $request, $id){
    
    }

    public function destroy($id){
       
    }
}
