@extends('plantillas.main')
@section('title', 'Listado de Solicitudes de Importación')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<span><strong><h3>Mis Solicitudes de Distribución</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      <div class="col-md-12">
         <div class="box">

            <div class="box-header">
               <h3 class="box-title">Solicitudes</h3>

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
                     <th><center>N°</center></th>
                     <th><center>Fecha de Solicitud</center></th>
                     <th><center>Producto</center></th>
                     <th><center>Status</center></th>
                     <th ><center>Acción</center></th>
                  </thead>
                  <tbody>
                     @foreach ($solicitudesDistribucion as $solicitudDistribucion)
                        <?php $cont++; ?>  
                        <tr>
                           <td><center>{{ $cont }}</td>
                           <td><center>{{ $solicitudDistribucion->created_at->format('d-m-Y') }}</td>
                           <td><center>{{ $solicitudDistribucion->producto->nombre }}</td>
                           @if ($solicitudDistribucion->status == '1')  
                              <td><center><span class="label label-success">Activa</span></td>
                           @else
                              <td><center><span class="label label-warning">Inactiva</span></td>
                           @endif
                           <td><center><a href="{{ route('solicitar-distribucion.edit', $solicitudDistribucion->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>      
         </div>
         <center>{{ $solicitudesDistribucion->render() }}</center>
      </div>
   </div>
@endsection