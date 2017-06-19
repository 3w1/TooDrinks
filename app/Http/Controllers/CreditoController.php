<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreditoCreateRequest;
use App\Http\Requests\CreditoUpdateRequest;
use App\Models\Credito;
use App\Models\User;
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
        $creditos=Credito::paginate(10);
        return view ('credito.index')->with (compact('creditos'));
    }

    public function create()
    {
      return view ('credito.create');
    }

    public function store(CreditoCreateRequest $request)
    {
        $credito=new Credito($request->all());
        $credito->save();
        return redirect()->action('CreditoController@index');
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

        return redirect()->action('CreditoController@index');
    }

    public function destroy($id)
    {
         $credito = Credito::find($id);
        $credito->delete();

        return redirect()->action('CreditoController@index');
    }






    public function compra($id)
    {  

    $fecha = new \DateTime();
    //echo $now->format(' H:i:s');

     $idusuario = Auth::user()->id;

     $credito = DB::table('credito')
                      ->where('id', $id)->get()->first();


    if(Auth::user()->productor==true){  

        $saldo = DB::table('productor')
                        ->select('saldo')
                        ->where('user_id', $idusuario)->get()->first();

        $actualizacion_saldo = DB::table('productor')
                            ->where('user_id', '=', $idusuario)
                            ->update(['saldo' =>$saldo->saldo+$credito->cantidad_creditos]);

        $historial_compras = DB::table('productor_credito')->insertGetId(
                                    ['credito_id' => $id, 'productor_id' => 11, 'total' => $credito->precio, 'fecha_compra' => $fecha]);    

                                     }

    if(Auth::user()->importador==true){

         $saldo = DB::table('importador')
                        ->select('saldo')
                        ->where('user_id', $idusuario)->get()->first();

        $actualizacion_saldo = DB::table('importador')
                            ->where('user_id', '=', $idusuario)
                            ->update(['saldo' =>$saldo->saldo+$credito->cantidad_creditos]);

        $historial_compras = DB::table('importador_credito')->insertGetId(
                                    ['credito_id' => $id, 'importador_id' => 11, 'total' => $credito->precio, 'fecha_compra' => $fecha]);

                                    }

    if(Auth::user()->distribuidor==true){

         $saldo = DB::table('distribuidor')
                        ->select('saldo')
                        ->where('user_id', $idusuario)->get()->first();

        $actualizacion_saldo = DB::table('distribuidor')
                            ->where('user_id', '=', $idusuario)
                            ->update(['saldo' =>$saldo->saldo+$credito->cantidad_creditos]);

         $historial_compras = DB::table('distribuidor_credito')->insertGetId(
                                    ['credito_id' => $id, 'idistribuidor_id' => 11, 'total' => $credito->precio, 'fecha_compra' => $fecha]);
                                        }

        $factura=PDF::loadview('credito.FacturaCredito',['credito'=>$credito]);
       return $factura->stream('factura_credito.pdf');
       //return $pdf->download('prueba.pdf');
    
    }

    public function generar_factura(){
        
    }

}

