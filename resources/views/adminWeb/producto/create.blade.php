@extends('adminWeb.plantillas.main')
@section('title', 'Crear Marca')

{!! Html::script('js/productos/create.js') !!}

@section('title-header')
   Nuevo Producto
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

	{!! Form::open(['route' => 'admin.producto-store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
	
		{!! Form::hidden('tipo_creador', session('adminRol')) !!}
		{!! Form::hidden('creador_id', session('adminId')) !!}
		{!! Form::hidden('publicado', '1') !!}
		{!! Form::hidden('confirmado', '0') !!}

		<div class="form-group">
			{!! Form::label('marca', 'Marca') !!}
			<select class="form-control" name="marca_id">
				<option value="0">Sin marca</option>
				@foreach ($marcas as $marca)
					<option value="{{ $marca->id}}">{{ $marca->nombre}}</option>
				@endforeach
			</select>
		</div>	
		
		<div class="form-group">
			{!! Form::label('nombre', 'Nombre (*)') !!}
			{!! Form::text('nombre', null, ['class' => 'form-control', 'required'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('nombre_seo', 'Nombre Seo') !!}
			{!! Form::text('nombre_seo', null, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('descripcion', 'Descripción') !!}
			{!! Form::text('descripcion', null, ['class' => 'form-control'] ) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('pais_id', 'País de Origen (*)') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();', 'required'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('bebida', 'Tipo de Bebida (*)') !!}
			{!! Form::select('bebida_id', $tipos_bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo..', 'id' => 'bebida_id', 'onchange' => 'cargarClases();', 'required'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('clase', 'Categoría de Bebida (*)') !!}
			<select name="clase_bebida_id" class="form-control" id="clases_bebidas">
				<option value="">Seleccione una clase..</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('ano_produccion', 'Año de Producción') !!}
			{!! Form::text('ano_produccion', null, ['class' => 'form-control'] ) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('imagen', 'Logo (*)') !!}
			{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Crear Producto', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}
@endsection