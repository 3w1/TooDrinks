@extends('plantillas.main')
@section('title', 'Listado de Productos')

{!! Html::script('js/productos/cargarClases.js') !!}

<script>
   window.onload=function() {
      var select = document.getElementById("bebida_id");
      for (var j = 0, l = select.length; j < l; j++) {
         if (select[j].value == ''){
            select[j].selected = true;
         }
      }
   }
</script>

@section('title-header')
   Productos
@endsection

@section('title-complement')
   (Mis Productos)
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
      <li class="active btn btn-default"><a href="{{ route('producto.index') }}"><strong>MIS PRODUCTOS</strong></a></li>
   	<li class="btn btn-default"><a href="{{ route('producto.agregar-producto') }}"><strong>AGREGAR PRODUCTO</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('producto.create') }}"><strong>CREAR PRODUCTO</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
         	<div class="tab-pane fade in active" id="tab1">
               @if ($cont > 0)
                	@foreach($productos as $producto)
				      	<div class="col-md-4 col-xs-6">
				         	<div class="thumbnail">
				            	<div>
				               	<img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
				           		</div>             
				            	<div class="caption">
				               	<p>
                                 @if ($producto->publicado == '0')
                                    <label class="label label-danger">Sin Publicar</label>
                                 @else
                                    <label class="label label-success">Publicado</label>
                                 @endif
				                 		@if ($producto->confirmado == '0')
					       					<label class="label label-danger">Sin Confirmar</label>
				                 	 	@else
				                     	<label class="label label-success">Confirmado</label>
				                 		@endif
				               	</p>
				               	<h3>{{ $producto->nombre }}</h3>
				              		<p><strong>{{ $producto->bebida->nombre }}</strong> ({{ $producto->clase_bebida->clase }})</p>
				               	<p>
				                 		<a href="{{ route('producto.detalle', [$producto->id, $producto->nombre_seo]) }}" class="btn btn-primary" role="button">Ver Más</a>
				                  	@if ($producto->publicado == '1')
                                    <a href="{{ route('oferta.crear-oferta', [$producto->id, $producto->nombre]) }}" class="btn btn-info" role="button">Ofertar</a>
                                 @else
                                    <button class="btn btn-primary" disabled>Ofertar</button>
                                 @endif
				               	</p>
				           		</div>
				         	</div>
				      	</div>
				   	@endforeach
               @else
                  <strong>No se han encontrado productos asociados</strong>
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
               		@include('producto.tabs.filtroMisProductos')
            	</div>
         	</div>
      	</div>
   	</div>
@endsection

@section('paginacion')
   {{$productos->appends(Request::only(['busqueda', 'marca', 'bebida', 'clase_bebida']))->render()}}
@endsection

