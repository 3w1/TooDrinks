<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreditoCreateRequest;
use App\Http\Requests\CreditoUpdateRequest;
use App\Models\Credito; use App\Models\User;
use App\Models\Deduccion_Credito_Productor; use App\Models\Deduccion_Credito_Importador;
use App\Models\Deduccion_Credito_Distribuidor; use App\Models\Deduccion_Credito_Horeca;
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
        return redirect('credito')->with('msj', 'El plan de crédito ha sido creado exitosamente');
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

        return redirect('credito')->with('msj', 'El plan de crédito ha sido modificado exitosamente');
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

     //   return redirect('usuario/inicio')->with('msj', 'Su plan de crédito ha sido agregado exitosamente');
        $factura=PDF::loadview('credito.FacturaCredito',['credito'=>$credito]);
        //return $factura->stream('factura_credito.pdf');
        return $factura->download('factura_compra_creditos.pdf');
        //return redirect('usuario/inicio')->with('msj', 'Su plan de crédito ha sido agregado exitosamente');
    }

    public function gastar_creditos_CO($cant, $id){
        $fecha = new \Datetime();

        $saldo = session('perfilSaldo') - $cant;
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

        }elseif( session('perfilTipo') == 'D'){
            $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Distribuidor();
            $deduccion->distribuidor_id = session('perfilId');
        }

        $deduccion->cantidad_creditos = $cant;
        $deduccion->descripcion = "Crear Oferta";
        $deduccion->fecha = $fecha;
        $deduccion->save();
        return redirect('oferta')->with('msj', 'Su oferta ha sido creada exitosamente. Se han descontado '.$cant.' créditos de su saldo.');
    }

    public function gastar_creditos_DI($cant, $id){
        $fecha = new \DateTime();
        $saldo = session('perfilSaldo') - $cant;
        session(['perfilSaldo' => $saldo]);    

        $act = DB::table('importador')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        $deduccion = new Deduccion_Credito_Importador();
        $deduccion->importador_id = session('perfilId');
        $deduccion->descripcion = 'Ver demanda de importador';
        $deduccion->cantidad_creditos = $cant;
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

        return redirect('demanda-importador/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
    }

    public function gastar_creditos_DD($cant, $id, $perfil){
        $fecha = new \DateTime();

        $saldo = session('perfilSaldo') - $cant;
        session(['perfilSaldo' => $saldo]);    

        $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        $deduccion = new Deduccion_Credito_Distribuidor();
        $deduccion->distribuidor_id = session('perfilId');
        $deduccion->descripcion = 'Ver demanda de distribuidor';
        $deduccion->cantidad_creditos = $cant;
        $deduccion->fecha = $fecha;
        $deduccion->save();

        if ($perfil == 'P'){
            return redirect('productor/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
        }else{
            return redirect('importador/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
        }
    }

    public function gastar_creditos_DP($cant, $id){
        $fecha = new \DateTime();
        $saldo = session('perfilSaldo') - $cant;
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
        }else{
            $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Distribuidor();
            $deduccion->distribuidor_id = session('perfilId');
        }
       
        $deduccion->descripcion = 'Ver demanda de producto';
        $deduccion->cantidad_creditos = $cant;
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

        return redirect('demanda-producto/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
    }

    public function gastar_creditos_DB($cant, $id){
        $fecha = new \DateTime();
        $saldo = session('perfilSaldo') - $cant;
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
        }else{
            $act = DB::table('distribuidor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

            $deduccion = new Deduccion_Credito_Distribuidor();
            $deduccion->distribuidor_id = session('perfilId');
        }
       
        $deduccion->descripcion = 'Ver demanda de bebida';
        $deduccion->cantidad_creditos = $cant;
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

        return redirect('demanda-producto/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
    }

    public function gastar_creditos_DIP($cant, $id){
        $fecha = new \DateTime();
        $saldo = session('perfilSaldo') - $cant;
        session(['perfilSaldo' => $saldo]);    

        $act = DB::table('productor')
                    ->where('id', '=', session('perfilId'))
                    ->update(['saldo' => $saldo ]);

        $deduccion = new Deduccion_Credito_Productor();
        $deduccion->productor_id = session('perfilId');
        $deduccion->descripcion = 'Ver demanda de importación';
        $deduccion->cantidad_creditos = $cant;
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

        return redirect('solicitar-importacion/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
    }

    public function gastar_creditos_DDP($cant, $id){
        $fecha = new \DateTime();
        $saldo = session('perfilSaldo') - $cant;
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
       
        $deduccion->descripcion = 'Ver demanda de distribución';
        $deduccion->cantidad_creditos = $cant;
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

        return redirect('solicitar-distribucion/'.$id)->with('msj', 'Se han descontado '.$cant.' créditos de su saldo.');
    }
}

