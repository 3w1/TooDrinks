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
    
    public function index(Request $request)
    {
        $cont = 0;

        $demandasImportadores = Demanda_Importador::where('productor_id', '=', session('perfilId'))
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(8);

        return view('demandaImportacion.index')->with(compact('demandasImportadores', 'cont'));
    }

    public function demandas_disponibles(){
        $notificaciones_pendientes_DI = DB::table('notificacion_i')
                                        ->where('leida', '=', '0')
                                        ->where('tipo', '=', 'DI')
                                        ->get();

        foreach ($notificaciones_pendientes_DI as $notificacion){
            $act = DB::table('notificacion_i')
                    ->where('id', '=', $notificacion->id)
                    ->update(['leida' => '1']);
        }

        $demandasImportadores = Demanda_Importador::orderBy('created_at', 'DESC')
                                ->where('pais_id', '=', session('perfilPais'))
                                ->where('status', '=', '1')
                                ->paginate(10);

        return view('demandaImportacion.demandasDisponibles')->with(compact('demandasImportadores'));
    }

    public function create()
    {
        $marcas = DB::table('marca')
                    ->orderBy('nombre')
                    ->where('productor_id', '=', session('perfilId'))
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

        return view('demandaImportacion.create')->with(compact('marcas', 'paises'));
    }

    public function store(Request $request)
    {
        $fecha = new \DateTime();
        
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
        
        return redirect('demanda-importador')->with('msj', 'Su demanda de importador ha sido creada exitosamente');    
    }

    public function show($id)
    {
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

     //Marca una demanda de importador "de interes" para la entidad loggeada 
    public function marcar_demanda($id){
        $fecha = new \DateTime();

        $demanda = Demanda_Importador::find($id);
      
        //Asociar importador a la demanda
        DB::table('importador_demanda_importador')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_importador_id' => $id, 'fecha' => $fecha]);    
        // ... //
        
        //Aumentar el contador de contactos de la demanda
        DB::table('demanda_importador')
        ->where('id', '=', $id)
        ->update(['cantidad_contactos' => ($demanda->cantidad_contactos + 1) ]); 
        // ... //

        return redirect('demanda-importador/'.$id)->with('msj', 'Se ha agregado la demanda de importador a su sección de "Demandas De Interés"');
    }

    public function demandas_interes(){
        $demandas = Demanda_Importador::select('demanda_importador.*')
                        ->join('importador_demanda_importador', 'demanda_importador.id', '=', 'importador_demanda_importador.demanda_importador_id')
                        ->where('importador_demanda_importador.importador_id', '=', session('perfilId'))
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);    

        return view('demandaImportacion.demandasDeInteres')->with(compact('demandas'));
    }

    public function edit($id)
    {
        $demandaImportador = Demanda_Importador::find($id);
        
        $marcas = DB::table('marca')
                        ->orderBy('nombre')
                        ->pluck('nombre', 'id');

        $pais_origen = DB::table('productor')
                        ->select('pais_id')
                        ->where('id', '=', session('perfilId'))
                        ->get()
                        ->first();

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->where('id', '<>', $pais_origen->pais_id)
                        ->pluck('pais', 'id');

        return view('demandaImportacion.edit')->with(compact('demandaImportador','marcas', 'paises'));
    }

    public function update(Request $request, $id)
    {
        $demanda_importador = Demanda_Importador::find($id);
        $demanda_importador->fill($request->all());
        $demanda_importador->save();

        return redirect('demanda-importador')->with('msj', 'Los datos de su demanda se han actualizado exitosamente');
    }

    //Cambia el status de una demanda
    public function cambiar_status(Request $request){
        Demanda_Importador::find($request->id)
            ->update(['status' => $request->status]);

        return redirect("demanda-importador")->with('msj', 'El status de su demanda ha sido actualizado exitosamente');
    }

    public function destroy($id)
    {
       
    }
}
