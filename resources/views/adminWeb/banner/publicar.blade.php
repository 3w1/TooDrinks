@extends('adminWeb.plantillas.main')
@section('title', 'Banners por Entidad')

<script>
   window.onload=function() {
      var select = document.getElementById("tipo_entidad");
      for (var j = 0, l = select.length; j < l; j++) {
         if (select[j].value == ''){
            select[j].selected = true;
         }
      }
   }
</script>

{!! Html::script('js/adminWeb/cargarEntidades.js') !!}
{!! Html::script('js/adminWeb/detallesBanner.js') !!}
{!! Html::script('js/adminWeb/publicarBanner.js') !!}
{!! Html::script('js/adminWeb/consultarFechasBanner.js') !!}

@section('title-header')
   Banners
@endsection

@section('title-complement')
   (Publicar)
@endsection

@section('content-left')

	@section('alertas')
		@if (Session::has('msj-success'))
	        <div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert">&times;</button>
	            <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
	        </div>
	     @endif
	@endsection
	
	@include('adminWeb.banner.modales.detallesBanner')

	@include('adminWeb.banner.modales.publicarBanner')

	@foreach($banners as $banner)
		<div class="col-md-4 col-xs-6">
	        <div class="thumbnail">
	            <div>
	            	<a href="" class="thumbnail" data-toggle='modal' data-target="#myModal">
		            <img src="{{ asset('imagenes/banners/thumbnails/') }}/{{ $banner->imagen }}" class="img-responsive"></a>
		        </div>             
		        <div class="caption">
		        	<p><strong>{{ $banner->titulo }}<strong></p>
		           	<p><center>
		           		<a href="#" onclick="cargarDetalles({{$banner->id}});" class="btn btn-info" role="button">Ver Detalles</a>
		               	<a href="#" onclick="cargarDatosBanner({{$banner->id}});" class="btn btn-primary" role="button">Publicar</a>
		            </center></p>
		        </div>
		    </div>
		</div>
	@endforeach
@endsection

@section('pagination')
	{{ $banners->appends(Request::only(['busqueda', 'tipo_entidad', 'entidad_id']))->render() }}
@endsection

@section('content-right')
	<div class="box box-success">
   		<div class="box-header with-border">
      		<h3 class="box-title">Búsqueda por Entidad</h3>
   			<div class="box-tools pull-right">
        		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      		</div>
   		</div>
	   	<div class="box-body">
	   		{!! Form::open([ 'route' => 'admin.publicar-banner', 'method' => 'GET']) !!}
	      		<div class="form-group">
	         		{!! Form::label('tipo', 'Tipo de Entidad')!!}
					{!! Form::select('tipo_entidad', ['' => 'Seleccione una entidad', 'P' => 'Productor', 'I' => 'Importador', 'D' => 'Distribuidor'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'required', 'onchange' => 'cargarEntidades();', 'id' => 'tipo_entidad']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('entidad', 'Entidad')!!}
					<select class="form-control" name="entidad_id" id="entidad_id" disabled>
						<option value="">Seleccione una opción</option>
					</select>
				</div>
				<div class="form-group">
					<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
				</div>
	      	{!! Form::close() !!}
	   	</div>
	</div>

	<div class="box box-danger">
	   	<div class="box-header with-border">
	   		<h3 class="box-title">Búsqueda por Banner</h3>
	      	<div class="box-tools pull-right">
	      		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      	</div>
	   	</div>
		<div class="box-body">
			{!! Form::open([ 'route' => 'admin.publicar-banner', 'method' => 'GET']) !!}
	      		<div class="form-group">
	        		{!! Form::text('busqueda', null, ['class' => 'form-control', 'id' => 'busqueda', 'placeholder' => 'Introduzca el nombre del Banner...']) !!}   
	   			</div>
				<div class="form-group">
					<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
				</div>
			{!! Form::close() !!}
	   	</div>
	</div>
@endsection