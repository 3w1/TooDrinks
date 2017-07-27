@extends('plantillas.main')
@section('title', 'Demandas de Interés')

{!! Html::script('js/credito/detalleGasto.js') !!}

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<span><strong><h3>Mis Demandas de Distribución</h3></strong></span>
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
                     <th><center>Producto</center></th>
                     <th><center>Distribuidor</center></th>
                     <th><center>Acción</center></th>
                  </thead>
                  <tbody>
                     @foreach ($demandas as $demanda) 
                        <tr>
                           <td><center>{{ date('d-m-Y', strtotime($demanda->fecha)) }}</td>
                           <td><center>{{ $demanda->producto->nombre}}</center></td>
                           <td><center>{{ $demanda->distribuidor->nombre}} </center></td>
                           <td><center>
                              <a href="{{ route('solicitud-distribucion.show', $demanda->id) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                           </center></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>      
         </div>
         <center>{{ $demandas->render() }}</center>
      </div>
   </div>
@endsection