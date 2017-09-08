@extends('plantillas.main')
@section('title', 'Exportación')

@section('title-header')
   Mis Demandas de Importadores
@endsection

@section('title-complement')
   (Activas)
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
      <li class="btn btn-default"><a href="{{ route('demanda-importador.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a></li>
   	<li class="btn btn-default"><a href="{{ route('demanda-importador.create') }}"><strong>NUEVA BÚSQUEDA</strong></a></li>
   	<li class="active btn btn-default"><a href="{{ route('demanda-importador.historial') }}"><strong>HISTORIAL DE BÚSQUEDAS</strong></a></li>
   </ul>

	<div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
   	<div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active">
         		<div class="box">
						<div class="box-body table-responsive no-padding table-bordered">
				         <table class="table table-hover">
				         	<thead>
				               <th><center>Fecha de Solicitud</center></th>
				               <th><center>Marca</center></th>
				               <th><center>País</center></th>
				               <th ><center>Visitas / Contactos</center></th>
				            </thead>
               			<tbody>
               				@if ($cont > 0)
					               @foreach ($demandasImportadores as $demandaImportador) 
					                  <tr>
					                     <td><center>{{ $demandaImportador->created_at->format('d-m-Y') }}</td>
					                     <td><center>{{ $demandaImportador->marca->nombre }}</td>
					                   	<td><center>{{ $demandaImportador->pais->pais }}</td>
						                  <td><center>
						                     <label class="label label-warning">{{$demandaImportador->cantidad_visitas}}</label> /
						                     <label class="label label-success">{{$demandaImportador->cantidad_contactos}}</label>
						                  </center></td>
						               </tr>
						            @endforeach
						         @else
						         	<tr>
						         		<td colspan="5"><strong>Actualmente no posee búsquedas de importadores en su historial.</strong></td>
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
               		@include('exportacion.tabs.filtroHistorial')
            	</div>
         	</div>
      	</div>
   	</div>
@endsection

@section('paginacion')
   {{$demandasImportadores->appends(Request::only(['marca', 'pais']))->render()}}
@endsection

