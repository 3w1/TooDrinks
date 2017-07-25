@extends('plantillas.main')
@section('title', 'Planes de Crédito')

{!! Html::script('js/banners/correcciones.js') !!}

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<span><strong><h3>Mi Historial de Compras</h3></strong></span>
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
                     <th><center>Plan</center></th>
                     <th><center>Créditos</center></th>
                     <th><center>Precio</center></th>
                     <th><center>Acción</center></th>
                  </thead>
                  <tbody>
                     @foreach ($planes as $plan) 
                        <tr>
                           <td><center>{{ date('d-m-Y', strtotime($plan->fecha_compra)) }}</td>
                           <td><center>{{ $plan->plan }}</td>
                           <td><center>{{ $plan->cantidad_creditos}} <i class="fa fa-certificate"></i></center></td>
                           <td><center>{{ $plan->total}} <i class="fa fa-usd"></i></center></td>
                           <td><center>
                              <a href="{{ route('credito.generar-factura', $plan->id) }}" class="btn btn-primary btn-xs">Generar Factura <i class="fa fa-file-pdf-o"></i></a></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>      
         </div>
         <center>{{ $planes->render() }}</center>
      </div>
   </div>
@endsection