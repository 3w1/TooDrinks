@extends('plantillas.main')
@section('title', 'Listado de Marcas')

@section('title-header')
   Marcas
@endsection

@section('title-complement')
   (Agregar Marca)
@endsection

@section('content-left')
   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
            </div>
      @endif

      <div class="alert alert-danger alert-dismissable" style="display: none;" id="alerta">
         <div id="mensaje"></div>
      </div>
   @endsection  

   <ul class="nav nav-pills">
      <li class="btn btn-default"><a href="{{ route('marca.index') }}"><strong>MIS MARCAS</strong></a></li>
   	<li class="active btn btn-default"><a href="{{ route('marca.agregar-marca') }}"><strong>AGREGAR MARCA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('marca.create') }}"><strong>CREAR MARCA</strong></a></li>
   </ul>

	<div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
               @if ($cont > 0)
                	@foreach($marcas as $marca)
   					   <div class="col-md-6 col-xs-12">
				    		   <div class="box box-widget widget-user-2">
   				        		<div class="widget-user-header bg-green">
   					       		<div class="widget-user-image">
   					              	<img class="img-rounded" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}">
   					           	</div>
   				           		<h3 class="widget-user-username">{{ $marca->nombre }}</h3>
   				           		<h5 class="widget-user-desc"> {{ $marca->pais->pais }} </i></h5>
   				        	   </div>
   				            		
   				            <div class="box-footer no-padding">
   				           		<ul class="nav nav-stacked">
   				      		  		<li class="active"><a href="{{$marca->website}}" target="_blank"><strong>Website:</strong> {{ $marca->website }}</a> </li>
                                 @if (session('perfilTipo') != 'P')
   				                     <li class="active"><a>
                                       @if ($marca->reclamada == '0')
   				                    			<label class="label label-danger">Reclamada</label>
   				                        @else
   				                           <label class="label label-success">Sin Reclamar</label>
   				                        @endif
                                    </a></li>
                                 @endif
   				                  <li class="active"><center>
                                    @if (session('perfilTipo') == 'P')
                                       <a href="{{ route('productor.asociar-marca', [$marca->id, $marca->nombre]) }}" class="btn btn-primary">Agregar</a>
                                    @elseif (session('perfilTipo') == 'I')
                                       <a href="{{ route('importador.asociar-marca', [$marca->id, $marca->nombre]) }}" class="btn btn-primary">Agregar</a>
                                    @elseif (session('perfilTipo') == 'D')
                                       <a href="{{ route('distribuidor.asociar-marca', [$marca->id, $marca->nombre]) }}" class="btn btn-primary">Agregar</a>
                                    @endif
                                 </center></li>
   				           		</ul>
   				        	   </div>
   				     	   </div>
   				      </div>
   			      @endforeach
               @else
                  <strong>No se han encontrado marcas disponibles para agregar.</strong>
               @endif
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
               		@include('marca.tabs.filtroAgregarMarca')
            	</div>
         	</div>
      	</div>
   	</div>
@endsection

@section('paginacion')
   {{$marcas->appends(Request::only(['busqueda', 'status']))->render()}}
@endsection

