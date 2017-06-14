@extends('plantillas.main')
@section('title', 'Crear Oferta')

@section('items')

@endsection

@section('content-left')
	
	@section('title-header')
		@if ($tipo == '1')
			<h3><b>Crear Oferta  del Producto {{ $producto }}</b></h3>
		@else
			<h3><b>Crear Oferta  de Producto </b></h3>
		@endif
	@endsection
	
	{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
		
		{!! Form::hidden('who', 'P') !!}

		{!! Form::hidden('tipo_creador', 'P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}

		@if ($tipo == '1')
			{!! Form::hidden('producto_id', $id) !!}
		@else 
			<div class="form-group">
				{!! Form::label('marca', 'Marca') !!}
				{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'id' => 'marca', 'placeholder' => 'Seleccione una marca..', 'onchange' => 'cargarProductos();']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('producto_id', 'Producto') !!}
				<select class="form-control" id="productos" name="producto_id">
					<option value="">Seleccione un producto..</option>
				</select>
			</div>
		@endif

		@include('oferta.formularios.createForm')
		
		<div class="form-group">
            {!! Form::label('visible_importador', 'Disponible para Importadores') !!}
            {!! Form::select('visible_importadores', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
        </div>

		<div class="form-group">
            {!! Form::label('visible_distribuidor', 'Disponible para Distribuidores') !!}
            {!! Form::select('visible_distribuidores', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('visible_horeca', 'Visible para Horecas') !!}
            {!! Form::select('visible_horecas', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']); !!}
        </div>  

        <div class="form-group">
			{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary']) !!}
		</div>
		
		{!! Form::close() !!}

@endsection