@extends('plantillas.main')
@section('title', 'Distribución')

{!! Html::script('js/demandaDistribuidores/cambiarStatus.js') !!}

@section('title-header')
   Mis Demandas de Distribuidores
@endsection

@section('content-left')
   @section('alertas')
   	@if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
         </div>
      @endif
   @endsection  
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default"><a href="{{ route('demanda-distribuidor.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a></li>
   	<li class="btn btn-default"><a href="{{ route('demanda-distribuidor.create') }}"><strong>NUEVA BÚSQUEDA</strong></a></li>
   	<li class="btn btn-default"><a href="{{ route('demanda-distribuidor.historial') }}"><strong>HISTORIAL DE BÚSQUEDAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
         		<div class="box">
						<div class="box-body table-responsive no-padding table-bordered">
				         <table class="table table-hover">
				            <thead>
				               <th><center>Fecha de Solicitud</center></th>
				               <th><center>Marca</center></th>
				               <th><center>Provincia / Estado</center></th>
				               <th><center>Status</center></th>
				               <th><center>Visitas / Contactos</center></th>
				            </thead>
               		   <tbody>
               				@if ($cont > 0)
					             	@foreach ($demandasDistribuidores as $demandaDistribuidor) 
					                 	<tr>
					                     <td><center>{{ $demandaDistribuidor->created_at->format('d-m-Y') }}</td>
					                     <td><center>{{ $demandaDistribuidor->marca->nombre }}</td>
					                   	<td><center>{{ $demandaDistribuidor->provincia_region->provincia }}</td>
					                  	<td><center>
	                           			<div class="btn-group btn-toggle"> 
	                             				<button class="btn btn-primary btn-xs active" id="on-{{$demandaDistribuidor->id}}" onclick="cambiar(this.id);">Visible</button>
	                                 		<button class="btn btn-default btn-xs" id="off-{{$demandaDistribuidor->id}}" onclick="cambiar(this.id);">No Visible</button>
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
						         @else
						         	<tr>
					            		<td colspan="5"><strong>Actualmente no posee búsquedas de distribuidores activas.</strong></td>
						            </tr>
									@endif
               			</tbody>
            			</table>
        			 	</div>      
      			</div>					
            </div>
         </div>
      </div>
   </div>
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
      	<div class="panel-heading">
         	<h5><b><center>Filtros de Búsqueda</center></b></h5>
      	</div>
      	<div class="panel-body">
         	<div class="tab-content">
            	<div class="tab-pane fade in active">
                  @include('distribucion.tabs.filtroBusquedasActivas')
            	</div>
         	</div>
      	</div>
   	</div>
@endsection

@section('paginacion')
   {{$demandasDistribuidores->appends(Request::only(['marca', 'provincia']))->render()}}
@endsection

