@extends('plantillas.main')
@section('title', 'Listado de Demandas de Distribuidores')

{!! Html::script('js/demandaDistribuidores/cambiarStatus.js') !!}

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<span><strong><h3>Mis Demandas de Distribuidor</h3></strong></span>
@endsection

@section('content-left')
   <div class="row">
      <div class="col-md-12">
         <div class="box">

            <div class="box-header">
               <h3 class="box-title">Demandas de Distribuidor</h3>

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
                     <th><center>Marca</center></th>
                     <th><center>Provincia</center></th>
                     <th><center>Status</center></th>
                     <th ><center>Visitas / Contactos</center></th>
                  </thead>
                  <tbody>
                     @foreach ($demandasDistribuidores as $demandaDistribuidor)
                        <?php $cont++; ?>  
                        <tr>
                           <td><center>{{ $cont }}</td>
                           <td><center>{{ $demandaDistribuidor->created_at->format('d-m-Y') }}</td>
                           <td><center>{{ $demandaDistribuidor->marca->nombre }}</td>
                           <td><center>{{ $demandaDistribuidor->provincia_region->provincia }}</td>
                           <td><center>
                              <div class="btn-group btn-toggle"> 
                                 @if ($demandaDistribuidor->status == '1')
                                    <button class="btn btn-primary btn-xs active" id="on-{{$demandaDistribuidor->id}}" onclick="cambiar(this.id);">Visible</button>
                                    <button class="btn btn-default btn-xs" id="off-{{$demandaDistribuidor->id}}" onclick="cambiar(this.id);">No Visible</button>
                                 @else
                                    <button class="btn btn-default btn-xs" id="on-{{$demandaDistribuidor->id}}" onclick="cambiar(this.id);">Visible</button>
                                    <button class="btn btn-primary btn-xs active" id="off-{{$demandaDistribuidor->id}}" onclick="cambiar(this.id);">No Visible</button>
                                 @endif
                              </div>
                           </center></td>
                           <td><center>
                              <label class="label label-warning">{{$demandaDistribuidor->cantidad_visitas}}</label> /
                              <label class="label label-success">{{$demandaDistribuidor->cantidad_contactos}}</label>
                           </center></td>
                        </tr>
                     @endforeach
                     {!! Form::open(['route' => 'demanda-distribuidor.status', 'method' => 'POST', 'id' => 'formStatus' ]) !!}
                        {!! Form::hidden('id', null, ['id' => 'id']) !!}
                        {!! Form::hidden('status', null, ['id' => 'status'] ) !!}
                     {!! Form::close() !!}
                  </tbody>
               </table>
            </div>      
         </div>
         <center>{{ $demandasDistribuidores->render() }}</center>
      </div>
   </div>
@endsection