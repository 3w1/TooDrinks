@extends('plantillas.main')
@section('title', 'Listado de Productos')

{!! Html::script('js/productos/agregarProducto.js') !!}

@section('title-header')
   Productos
@endsection

@section('title-complement')
   (Asociar Producto)
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

   @include('producto.modales.listadoMarcas') 
   
    <ul class="nav nav-pills">
      	<li class="btn btn-default"><a href="{{ route('producto.index') }}"><strong>MIS PRODUCTOS</strong></a></li>
      	<li class="active btn btn-default"><a href="{{ route('producto.agregar-producto') }}"><strong>AGREGAR PRODUCTO</strong></a></li>
   	</ul>

   	<div class="panel with-nav-tabs panel-primary">
      	<div class="panel-heading">
         
      	</div>
      	<div class="panel-body">
         	<div class="tab-content">
            	<div class="tab-pane fade in active" id="tab1">
                	@foreach($productos as $producto)
                     @if ($producto->id != '0')
   				      	<div class="col-md-4 col-xs-6">
   				         	<div class="thumbnail">
   				            	<div>
   				               		<img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
   				           		</div>             
   				            	<div class="caption">
   				               		<p>
   				                  		@if ($producto->confirmado == '0')
   					       					<label class="label label-danger">Sin Confirmar</label>
   				                 	 	@else
   				                     		<label class="label label-success">Confirmado</label>
   				                 		@endif
   				               		</p>
   				               		<h3>{{ $producto->nombre }}</h3>
   				               		<p><strong>{{ $producto->bebida->nombre }}</strong> ({{ $producto->clase_bebida->clase }})</p>
   				               		<p><center>
                                       @if (session('perfilTipo') == 'P')
                                          {!! Form::hidden('productor', session('perfilId'), ['id' => 'productor']) !!}
   				                  		   <a href="#" onclick="cargarMarcas({{$producto->id}});" class="btn btn-info" role="button">Agregar</a>
                                       @else
                                          <a href="{{ route('producto.asociar-producto', $producto->id)}}" class="btn btn-info" role="button">Agregar</a>
                                       @endif
   				               		</center></p>
   				           		</div>
   				         	</div>
   				      	</div>
                     @endif
				   	@endforeach
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
               		@include('producto.tabs.filtroAgregarProducto')
            	</div>
         	</div>
      	</div>
   	</div>
@endsection

@section('paginacion')
   {{$productos->appends(Request::only(['busqueda', 'pais']))->render()}}
@endsection

