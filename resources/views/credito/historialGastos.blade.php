@extends('plantillas.main')
@section('title', 'Planes de Crédito')

{!! Html::script('js/credito/detalleGasto.js') !!}

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<span><strong><h3>Mi Historial de Gastos</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
            <div class="box-header">
               <br>
               <div class="box-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                     <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar">
                     <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                     </div>
                  </div>
               </div>
            </div>

            <div class="box-body table-responsive no-padding table-bordered">
               <table class="table table-hover">
                  <thead>
                     <th><center>Fecha</center></th>
                     <th><center>Tipo de Deducción</center></th>
                     <th><center>Cantidad de Créditos</center></th>
                     <th><center>Acción</center></th>
                  </thead>
                  <tbody>
                     @foreach ($gastos as $gasto) 
                        <tr>
                           <td><center>{{ date('d-m-Y', strtotime($gasto->fecha)) }}</td>
                           <td><center>{{ $gasto->descripcion }}</td>
                           <td><center>{{ $gasto->cantidad_creditos}} <i class="fa fa-certificate"></i></center></td>
                           <td><center>
                              @if ($gasto->tipo_deduccion == 'DP')
                                 <a href="{{ route('demanda-producto.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @elseif ($gasto->tipo_deduccion == 'DB')
                                 <a href="{{ route('demanda-producto.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @elseif ($gasto->tipo_deduccion == 'CO')
                                 <a href="{{ route('oferta.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @elseif ($gasto->tipo_deduccion == 'SI')
                                 <a href="{{ route('solicitar-importacion.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @elseif ($gasto->tipo_deduccion == 'SD') 
                                 <a href="{{ route('solicitar-distribucion.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @elseif ($gasto->tipo_deduccion == 'DI')
                                  <a href="{{ route('demanda-importador.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @elseif ($gasto->tipo_deduccion == 'DD')
                                  <a href="{{ route('demanda-distribuidor.show', $gasto->accion_id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                              @endif
                           </center></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>      
         </div>
         <center>{{ $gastos->render() }}</center>
      </div>
   </div>
@endsection