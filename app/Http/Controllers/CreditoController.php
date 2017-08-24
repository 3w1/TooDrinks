<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreditoCreateRequest;
use App\Http\Requests\CreditoUpdateRequest;
use App\Models\Credito; use App\Models\User;
use App\Models\Deduccion_Credito_Productor; use App\Models\Deduccion_Credito_Importador;
use App\Models\Deduccion_Credito_Distribuidor; use App\Models\Deduccion_Credito_Horeca;
use App\Models\Deduccion_Credito_Multinacional;
use DB;
use PDF;

class CreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $creditos=Credito::orderBy('cantidad_creditos')->paginate(9);

        if (session('perfilTipo') == 'AD'){
            return view('adminWeb.listados.creditos')->with(compact('creditos'));
        }else{
            return view('credito.index')->with(compact('creditos'));
        }
        
    }

    public function create()
    {
        return view ('credito.create');
    }

    public function store(CreditoCreateRequest $request)
    {
        $credito=new Credito($request->all());
        $credito->save();
        return redirect('credito')->with('msj', 'El plan de crédito ha sido creado con éxito.');
    }


    public function show($id)
    {
        $credito = Credito::all();
        return view ('credito.show')->with(compact('credito'));
    }

    public function edit($id)
    {
        $credito = Credito::find($id);

        return view('credito.edit')->with(compact('credito'));
    }

    public function update(CreditoUpdateRequest $request, $id)
    {
        $credito = Credito::find($id);
        $credito->fill($request->all());
        $credito->save();

        return redirect('credito')->with('msj', 'El plan de crédito ha sido modificado con éxito.');
    }

    public function destroy($id)
    {
       
    }

    public function compra($id)
    {  
        $fecha = new \Datetime();

        $credito = DB::table('credito')
                          ->where('id', $id)
                          ->first();

        if (session('perfilTipo') == 'P'){
            $saldo = DB::table('productor')
                            ->select('saldo')
                            ->where('id', '=', session('perfilId'))
                            ->first();

            $saldoNuevo = $saldo->saldo + $credito->cantidad_creditos;

            $actualizacion_saldo = DB::table('productor')
                                    ->where('id', '=', session('perfilId'))
                                    ->update(['saldo' => $saldoNuevo]);

            session(['perfilSaldo' => $saldoNuevo]);

            //Insertar en la tabla relacion
            $historial_compras = DB::table('productor_credito')->insertGetId(
                                        ['credito_id' => $id, 'productor_id' => session('perfilId'), 'total' => $credito->precio, 'fecha_compra' => $fecha]);    
            // ... //
        }elseif (session('perfilTipo') == 'I'){
            $saldo = DB::table('importador')
                            ->select('saldo')
                            ->where('id', '=', session('perfilId'))
                            ->first();

            $saldoNuevo = $saldo->saldo + $credito->cantidad_creditos;

            $actualizacion_saldo = DB::table('importador')
                                    ->where('id', '=', session('perfilId'))
                                    ->update(['saldo' => $saldoNuevo]);

            session(['perfilSaldo' => $saldoNuevo]);

            //Insertar en la tabla relacion
            $historial_compras = DB::table('importador_credito')->insertGetId(
                                        ['credito_id' => $id, 'importador_id' => session('perfilId'), 'total' => $credito->precio, 'fecha_compra' => $fecha]);    
            // ... //
        }elseif (session('perfilTipo') == 'M'){
            $saldo = DB::table('multinacional')
                            ->select('saldo')
                            ->where('id', '=', session('perfilId'))
                            ->first();

            $saldoNuevo = $saldo->saldo + $credito->cantidad_creditos;

            $actualizacion_saldo = DB::table('multinacional')
                                    ->where('id', '=', session('perfilId'))
                                    ->update(['saldo' => $saldoNuevo]);

            session(['perfilSaldo' => $saldoNuevo]);

            //Insertar en la tabla relacion
            $historial_compras = DB::table('multinacional_credito')->insertGetId(
                                        ['credito_id' => $id, 'multinacional_id' => session('perfilId'), 'total' => $credito->precio, 'fecha_compra' => $fecha]);    
            // ... //
        }elseif (session('perfilTipo') == 'D'){
            $saldo = DB::table('distribuidor')
                            ->select('saldo')
                            ->where('id', '=', session('perfilId'))
                            ->first();

            $saldoNuevo = $saldo->saldo + $credito->cantidad_creditos;

            $actualizacion_saldo = DB::table('distribuidor')
                                    ->where('id', '=', session('perfilId'))
                                    ->update(['saldo' => $saldoNuevo]);

            session(['perfilSaldo' => $saldoNuevo]);

            //Insertar en la tabla relacion
            $historial_compras = DB::table('distribuidor_credito')->insertGetId(
                                        ['credito_id' => $id, 'distribuidor_id' => session('perfilId'), 'total' => $credito->precio, 'fecha_compra' => $fecha]);    
            // ... //
        }elseif (session('perfilTipo') == 'H'){
            $saldo = DB::table('horeca')
                            ->select('saldo')
                            ->where('id', '=', session('perfilId'))
                            ->first();

            $saldoNuevo = $saldo->saldo + $credito->cantidad_creditos;

            $actualizacion_saldo = DB::table('horeca')
                                    ->where('id', '=', session('perfilId'))
                                    ->update(['saldo' => $saldoNuevo]);

            session(['perfilSaldo' => $saldoNuevo]);

            //Insertar en la tabla relacion
            $historial_compras = DB::table('horeca_credito')->insertGetId(
                                        ['credito_id' => $id, 'horeca_id' => session('perfilId'), 'total' => $credito->precio, 'fecha_compra' => $fecha]);    
            // ... //
        }

        return redirect('credito/historial-de-planes')->with('msj', 'Sus créditos han sido actualizados con éxito.');
    
        $factura=PDF::loadview('credito.FacturaCredito',['credito'=>$credito]);
        //return $factura->stream('factura_credito.pdf');
        return $factura->download('factura_compra_creditos.pdf');
        //return redirect('usuario/inicio')->with('msj', 'Su plan de crédito ha sido agregado exitosamente');
    }

    public function historial_planes(){
        if (session('perfilTipo') == 'P'){
            $planes = DB::table('productor_credito')
                        ->select('productor_credito.*', 'credito.plan', 'credito.cantidad_creditos')
                        ->join('credito', 'productor_credito.credito_id', '=', 'credito.id')
                        ->where('productor_credito.productor_id', '=', session('perfilId'))
                        ->paginate(10);
        }elseif (session('perfilTipo') == 'I'){
        	$planes = DB::table('importador_credito')
                        ->select('importador_credito.*', 'credito.plan', 'credito.cantidad_creditos')
                        ->join('credito', 'importador_credito.credito_id', '=', 'credito.id')
                        ->where('importador_credito.importador_id', '=', session('perfilId'))
                        ->paginate(10);
        }elseif (session('perfilTipo') == 'D'){
        	$planes = DB::table('distribuidor_credito')
                        ->select('distribuidor_credito.*', 'credito.plan', 'credito.cantidad_creditos')
                        ->join('credito', 'distribuidor_credito.credito_id', '=', 'credito.id')
                        ->where('distribuidor_credito.distribuidor_id', '=', session('perfilId'))
                        ->paginate(10);
        }elseif (session('perfilTipo') == 'M' ){
        	$planes = DB::table('multinacional_credito')
                        ->select('multinacional_credito.*', 'credito.plan', 'credito.cantidad_creditos')
                        ->join('credito', 'multinacional_credito.credito_id', '=', 'credito.id')
                        ->where('multinacional_credito.multinacional_id', '=', session('perfilId'))
                        ->paginate(10);
        }

        return view('credito.historialPlanes')->with(compact('planes'));   
    }

    public function generar_factura($id){
        if (session('perfilTipo') == 'P'){
            $compra = DB::table('productor_credito')
                    ->select('productor_credito.total', 'productor_credito.fecha_compra', 'credito.plan', 'credito.cantidad_creditos', 'credito.descripcion')
                    ->join('credito', 'productor_credito.credito_id', '=', 'credito.id')
                    ->where('productor_credito.id', '=', $id)
                    ->first();
        }elseif (session('perfilTipo') == 'I') {
            $compra = DB::table('importador_credito')
                    ->select('importador_credito.total', 'importador_credito.fecha_compra', 'credito.plan', 'credito.cantidad_creditos', 'credito.descripcion')
                    ->join('credito', 'importador_credito.credito_id', '=', 'credito.id')
                    ->where('importador_credito.id', '=', $id)
                    ->first();       
        }elseif(session('perfilTipo') == 'D'){
            $compra = DB::table('distribuidor_credito')
                    ->select('distribuidor_credito.total', 'distribuidor_credito.fecha_compra', 'credito.plan', 'credito.cantidad_creditos', 'credito.descripcion')
                    ->join('credito', 'distribuidor_credito.credito_id', '=', 'credito.id')
                    ->where('distribuidor_credito.id', '=', $id)
                    ->first();   
        }elseif (session('perfilTipo') == 'M'){
        	$compra = DB::table('multinacional_credito')
                    ->select('multinacional_credito.total', 'multinacional_credito.fecha_compra', 'credito.plan', 'credito.cantidad_creditos', 'credito.descripcion')
                    ->join('credito', 'multinacional_credito.credito_id', '=', 'credito.id')
                    ->where('multinacional_credito.id', '=', $id)
                    ->first(); 
        }

        $factura=PDF::loadview('credito.FacturaCredito',['compra'=>$compra]);
        return $factura->download('factura_compra_creditos.pdf');
    }

    public function historial_gastos(){
        if (session('perfilTipo') == 'P'){
            $gastos = Deduccion_Credito_Productor::orderBy('created_at', 'DESC')
                            ->where('productor_id', '=', session('perfilId'))
                            ->paginate(10);
        }elseif (session('perfilTipo') == 'I'){
            $gastos = Deduccion_Credito_Importador::orderBy('created_at', 'DESC')
                            ->where('importador_id', '=', session('perfilId'))
                            ->paginate(10);
        }elseif (session('perfilTipo') == 'D'){
            $gastos = Deduccion_Credito_Distribuidor::orderBy('created_at', 'DESC')
                            ->where('distribuidor_id', '=', session('perfilId'))
                            ->paginate(10);
        }elseif (session('perfilTipo') == 'M'){
        	$gastos = Deduccion_Credito_Multinacional::orderBy('created_at', 'DESC')
                            ->where('multinacional_id', '=', session('perfilId'))
                            ->paginate(10);
        }

        return view('credito.historialGastos')->with(compact('gastos'));
    }

    public function gastar_creditos_CO($id){
        $fecha = new \Datetime();

        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'CO')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);

        if (session('perfilTipo') == 'P'){

            $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Productor();
            $deduccion->productor_id = session('perfilId');
            
        }elseif (session('perfilTipo') == 'I'){
            $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Importador();
            $deduccion->importador_id = session('perfilId');

        }elseif (session('perfilTipo') == 'M'){
        	$act = DB::table('multinacional')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Multinacional();
            $deduccion->multinacional_id = session('perfilId');

        }elseif( session('perfilTipo') == 'D'){
            $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Distribuidor();
            $deduccion->distribuidor_id = session('perfilId');
        }

        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->descripcion = "Crear Oferta";
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'CO';
        $deduccion->accion_id = $id;
        $deduccion->save();
        
        return redirect('oferta')->with('msj', 'Su oferta ha sido creada con éxito. Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }

    public function gastar_creditos_PDI($id){
        $fecha = new \DateTime();
        
        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'DI')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);    

        $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        $deduccion = new Deduccion_Credito_Productor();
        $deduccion->productor_id = session('perfilId');
        $deduccion->descripcion = 'Solicitar Importador';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'PDI';
        $deduccion->accion_id = $id;
        $deduccion->save();

        return redirect('demanda-importador')->with('msj', 'Su demanda de importador ha sido creada con éxito');    
    }

    public function gastar_creditos_DI($id){
        $fecha = new \DateTime();
        
        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'VD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);    

        $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        DB::table('importador_demanda_importador')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_importador_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

        $deduccion = new Deduccion_Credito_Importador();
        $deduccion->importador_id = session('perfilId');
        $deduccion->descripcion = 'Ver demanda de importador';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'DI';
        $deduccion->accion_id = $id;
        $deduccion->save();

        $demanda = DB::table('demanda_importador')
                        ->where('id', '=', $id)
                        ->select('cantidad_contactos')
                        ->first();

        $contactos = $demanda->cantidad_contactos + 1;

        $act = DB::table('demanda_importador')
                ->where('id', '=', $id)
                ->update(['cantidad_contactos' => $contactos]);

        return redirect('demanda-importador/'.$id)->with('msj', 'Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }

    public function gastar_creditos_PDD($id){
        $fecha = new \DateTime();
        
        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'DD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);    

        if (session('perfilTipo') == 'P'){
            $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Productor();
            $deduccion->productor_id = session('perfilId');
        }elseif (session('perfilTipo') == 'I'){
             $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Importador();
            $deduccion->importador_id = session('perfilId');
        }
    
        $deduccion->descripcion = 'Solicitar Distribuidor';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'PDD';
        $deduccion->accion_id = $id;
        $deduccion->save();

        return redirect('demanda-distribuidor')->with('msj', 'Su demanda de distribuidor ha sido creada con éxito');    
    }

    public function gastar_creditos_DD($id){
        $fecha = new \DateTime();

        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'VD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);    

        $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        DB::table('distribuidor_demanda_distribuidor')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_distribuidor_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

        $deduccion = new Deduccion_Credito_Distribuidor();
        $deduccion->distribuidor_id = session('perfilId');
        $deduccion->descripcion = 'Ver demanda de distribuidor';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'DD';
        $deduccion->accion_id = $id;
        $deduccion->save();

        $demanda = DB::table('demanda_distribuidor')
                        ->where('id', '=', $id)
                        ->select('cantidad_contactos')
                        ->first();

        $contactos = $demanda->cantidad_contactos + 1;

        $act = DB::table('demanda_distribuidor')
                ->where('id', '=', $id)
                ->update(['cantidad_contactos' => $contactos]);

        return redirect('demanda-distribuidor/'.$id)->with('msj', 'Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }

    public function gastar_creditos_DP($id){
        $fecha = new \DateTime();

        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'VD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);

        if (session('perfilTipo') == 'P'){
            $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            DB::table('productor_demanda_producto')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Productor();
            $deduccion->productor_id = session('perfilId');
        }elseif (session('perfilTipo') == 'I'){
            $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

             DB::table('importador_demanda_producto')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Importador();
            $deduccion->importador_id = session('perfilId');
        }elseif (session('perfilTipo') == 'M'){
        	 $act = DB::table('multinacional')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

             DB::table('multinacional_demanda_producto')->insertGetId(
                                        ['multinacional_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Multinacional();
            $deduccion->multinacional_id = session('perfilId');
        }elseif (session('perfilTipo') == 'D'){
            $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

             DB::table('distribuidor_demanda_producto')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Distribuidor();
            $deduccion->distribuidor_id = session('perfilId');
        }
       
        $deduccion->descripcion = 'Ver demanda de producto';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'DP';
        $deduccion->accion_id = $id;
        $deduccion->save();

        $demanda = DB::table('demanda_producto')
                        ->where('id', '=', $id)
                        ->select('cantidad_contactos')
                        ->first();

        $contactos = $demanda->cantidad_contactos + 1;

        $act = DB::table('demanda_producto')
                ->where('id', '=', $id)
                ->update(['cantidad_contactos' => $contactos]);

        return redirect('demanda-producto/'.$id)->with('msj', 'Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }

    public function gastar_creditos_DB($id){
        $fecha = new \DateTime();
        
        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'VD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);  

        if (session('perfilTipo') == 'P'){
            $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            DB::table('productor_demanda_producto')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Productor();
            $deduccion->productor_id = session('perfilId');
        }elseif (session('perfilTipo') == 'I'){
            $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            DB::table('importador_demanda_producto')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Importador();
            $deduccion->importador_id = session('perfilId');
        }elseif (session('perfilTipo') == 'M'){
        	 $act = DB::table('multinacional')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

             DB::table('multinacional_demanda_producto')->insertGetId(
                                        ['multinacional_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Multinacional();
            $deduccion->multinacional_id = session('perfilId');
        }elseif (session('perfilTipo') == 'D'){
            $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            DB::table('distribuidor_demanda_producto')->insertGetId(
                                        ['distribuidor_id' => session('perfilId'), 'demanda_producto_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Distribuidor();
            $deduccion->distribuidor_id = session('perfilId');
        }
       
        $deduccion->descripcion = 'Ver demanda de bebida';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'DB';
        $deduccion->accion_id = $id;
        $deduccion->save();

        $demanda = DB::table('demanda_producto')
                        ->where('id', '=', $id)
                        ->select('cantidad_contactos')
                        ->first();

        $contactos = $demanda->cantidad_contactos + 1;

        $act = DB::table('demanda_producto')
                ->where('id', '=', $id)
                ->update(['cantidad_contactos' => $contactos]);

        return redirect('demanda-producto/'.$id)->with('msj', 'Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }

    public function gastar_creditos_SI($id){
        $fecha = new \DateTime();
        
        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'VD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);  
   
        $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        DB::table('productor_solicitud_importacion')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'solicitud_importacion_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

        $deduccion = new Deduccion_Credito_Productor();
        $deduccion->productor_id = session('perfilId');
        $deduccion->descripcion = 'Ver demanda de importación';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'SI';
        $deduccion->accion_id = $id;
        $deduccion->save();

        $solicitud = DB::table('solicitud_importacion')
                        ->where('id', '=', $id)
                        ->select('cantidad_contactos')
                        ->first();

        $contactos = $solicitud->cantidad_contactos + 1;

        $act = DB::table('solicitud_importacion')
                ->where('id', '=', $id)
                ->update(['cantidad_contactos' => $contactos]);

        return redirect('solicitud-importacion/'.$id)->with('msj', 'Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }

    public function gastar_creditos_SD($id){
        $fecha = new \DateTime();
        
        $coste = DB::table('coste_credito')
                        ->select('cantidad_creditos')
                        ->where('accion', '=', 'VD')
                        ->where('entidad', '=', session('perfilTipo'))
                        ->first(); 

        $saldo = session('perfilSaldo') - $coste->cantidad_creditos;
        session(['perfilSaldo' => $saldo]);     

        if (session('perfilTipo') == 'P'){
            $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            DB::table('productor_solicitud_distribucion')->insertGetId(
                                        ['productor_id' => session('perfilId'), 'solicitud_distribucion_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Productor();
            $deduccion->productor_id = session('perfilId');
        }elseif (session('perfilTipo') == 'I'){
            $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            DB::table('importador_solicitud_distribucion')->insertGetId(
                                        ['importador_id' => session('perfilId'), 'solicitud_distribucion_id' => $id, 'fecha' => $fecha, 'marcada' => '1']);    

            $deduccion = new Deduccion_Credito_Importador();
            $deduccion->importador_id = session('perfilId');
        }
       
        $deduccion->descripcion = 'Ver demanda de distribución';
        $deduccion->cantidad_creditos = $coste->cantidad_creditos;
        $deduccion->fecha = $fecha;
        $deduccion->tipo_deduccion = 'SD';
        $deduccion->accion_id = $id;
        $deduccion->save();

        $solicitud = DB::table('solicitud_distribucion')
                        ->where('id', '=', $id)
                        ->select('cantidad_contactos')
                        ->first();

        $contactos = $solicitud->cantidad_contactos + 1;

        $act = DB::table('solicitud_distribucion')
                ->where('id', '=', $id)
                ->update(['cantidad_contactos' => $contactos]);

        return redirect('solicitud-distribucion/'.$id)->with('msj', 'Se han descontado '.$coste->cantidad_creditos.' créditos de su saldo.');
    }
}

