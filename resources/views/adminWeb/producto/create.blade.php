@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Marca')

{!! Html::script('js/productos/create.js') !!}

@section('title-header')
   Crear Producto
@endsection

@section('title-complement')
   	@if ($marca != '0')
   		(Marca: {{$marca}})
   	@endif
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

	{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
	
		{!! Form::hidden('tipo_creador', 'AD') !!}
		{!! Form::hidden('creador_id', Auth::user()->id) !!}
		{!! Form::hidden('publicado', '1') !!}
		{!! Form::hidden('confirmado', '0') !!}
		
		@if ($marca == '0')
			<div class="form-group">
				{!! Form::label('marca', 'Marca') !!}
				{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca..']) !!}
			</div>	
		@else
			{!! Form::hidden('marca_id', $marca) !!}
		@endif	

		<div class="form-group">
			{!! Form::label('nombre', 'Nombre') !!}
			{!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre del Producto'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('nombre_seo', 'Nombre Seo') !!}
			{!! Form::text('nombre_seo', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre SEO del Producto'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('descripcion', 'Descripción') !!}
			{!! Form::text('descripcion', null, ['class' => 'form-control', 'required', 'placeholder' => 'Descripción del Producto'] ) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('pais_id', 'País de origen') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('provincia', 'Provincia de origen') !!}
			<select name="provincia_region_id" class="form-control" id="provincias">
				<option value="">Seleccione una provincia..</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('bebida', 'Tipo de Bebida') !!}
			{!! Form::select('bebida_id', $tipos_bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo..', 'id' => 'bebida_id', 'onchange' => 'cargarClases();'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('clase', 'Clase de Bebida') !!}
			<select name="clase_bebida_id" class="form-control" id="clases_bebidas">
				<option value="">Seleccione una clase..</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('ano_produccion', 'Año de Producción') !!}
			{!! Form::text('ano_produccion', null, ['class' => 'form-control', 'required', 'placeholder' => 'Año de Producción'] ) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('imagen', 'Imagen') !!}
			{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}
@endsection