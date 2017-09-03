@extends('adminWeb.plantillas.main')
@section('title', 'Banner Publicitario')

{!! Html::script('js/adminWeb/cargarEntidades.js') !!}

@section('title-header')
   Banners
@endsection

@section('title-complement')
   (Publicaciones en Curso)
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

   	<div class="col-md-12">
      	<div class="box">
         	<div class="box-header">
          
         	</div>

        	<div class="box-body table-responsive no-padding table-bordered">
            	<table class="table table-hover">
            		<thead>
                  		<th><center>#</center></th>
                  		<th><center>Banner</center></th>
                  		<th><center>País</center></th>
                  		<th><center>Fecha Inicial</center></th>
                  		<th><center>Fecha Final</center></th>
                  		<th><center>Clicks</center></th>
               		</thead>
               		<tbody>
                  		@foreach ($publicaciones as $publicacion) 
                  			<?php $cont++; ?>
	                     	<tr>
		                        <td><center>{{ $cont }}</td>
		                        <td><center>{{ $publicacion->banner->titulo }}</td>
		                        <td><center>{{ $publicacion->pais->pais}}</center></td>
		                        <td><center>{{ $publicacion->fecha_inicio }}</center></td>
		                        <td><center>{{ $publicacion->fecha_fin }}</center></td>
		                        <td><center>{{ $publicacion->cantidad_clics }}</center></td>
	                     	</tr>
                  		@endforeach
               		</tbody>
            	</table>
         	</div>      
      	</div>
   	</div>
@endsection

@section('pagination')
	{{ $publicaciones->appends(Request::only(['tipo_entidad', 'entidad_id', 'busqueda', 'pais']))->render() }}
@endsection

@section('content-right')
	<div class="box box-danger">
   		<div class="box-header with-border">
      		<h3 class="box-title">Búsqueda por Entidad</h3>
   			<div class="box-tools pull-right">
        		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      		</div>
   		</div>
	   	<div class="box-body">
	   		{!! Form::open([ 'route' => 'admin.publicaciones-en-curso', 'method' => 'GET']) !!}
	      		<div class="form-group">
	         		{!! Form::label('tipo', 'Tipo de Entidad')!!}
					{!! Form::select('tipo_entidad', ['P' => 'Productor', 'I' => 'Importador', 'D' => 'Distribuidor'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'required', 'onchange' => 'cargarEntidades();', 'id' => 'tipo_entidad']) !!}
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

	<div class="box box-success">
	   	<div class="box-header with-border">
	   		<h3 class="box-title">Búsqueda por Banner</h3>
	      	<div class="box-tools pull-right">
	      		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      	</div>
	   	</div>
		<div class="box-body">
			{!! Form::open([ 'route' => 'admin.publicaciones-en-curso', 'method' => 'GET']) !!}
	      		<div class="form-group">
	        		{!! Form::text('busqueda', null, ['class' => 'form-control', 'id' => 'busqueda', 'placeholder' => 'Introduzca el nombre del Banner...']) !!}   
	   			</div>
				<div class="form-group">
					<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
				</div>
			{!! Form::close() !!}
	   	</div>
	</div>

	<div class="box box-warning">
	   	<div class="box-header with-border">
	   		<h3 class="box-title">Búsqueda por País</h3>
	      	<div class="box-tools pull-right">
	      		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      	</div>
	   	</div>
		<div class="box-body">
			{!! Form::open([ 'route' => 'admin.publicaciones-en-curso', 'method' => 'GET']) !!}
	      		<div class="form-group">
	        		{!! Form::select('pais', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'required']) !!}   
	   			</div>
				<div class="form-group">
					<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
				</div>
			{!! Form::close() !!}
	   	</div>
	</div>
@endsection