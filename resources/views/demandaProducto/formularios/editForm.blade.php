{!! Form::open(['route' => ['demanda-producto.update', $solicitudProducto->id], 'method' => 'PUT']) !!}
	<div class="form-group">
		{!! Form::label('titulo', 'Título de la Demanda') !!}
		{!! Form::text('titulo', $solicitudProducto->titulo, ['class' => 'form-control']) !!}
	</div>
	
	@if ($solicitudProducto->producto_id != '0')
		<div class="form-group">
			{!! Form::label('producto', 'Producto') !!}
			{!! Form::text('producto', $solicitudProducto->producto->nombre, ['class' => 'form-control', 'disabled']) !!}
		</div>
	@else 
		<div class="form-group">
			{!! Form::label('bebidas', 'Bebida') !!}
			{!! Form::text('bebida', $solicitudProducto->bebida->nombre, ['class' => 'form-control', 'disabled']) !!}
		</div>
	@endif

	<div class="form-group">
		{!! Form::label('pais', 'País') !!}
		{!! Form::text('pais', $solicitudProducto->pais->pais, ['class' => 'form-control', 'disabled']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincia_', 'Provincia') !!}
		{!! Form::text('provincia', $solicitudProducto->provincia_region->provincia, ['class' => 'form-control', 'disabled']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción de la demanda') !!}
		{!! Form::textarea('descripcion', $solicitudProducto->descripcion, ['class' => 'form-control', 'rows' => '5']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Ingrese la cantidad mínima deseada') !!}
		{!! Form::number('cantidad_minima', $solicitudProducto->cantidad_minima, ['class' => ' form-control'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('cantidad_maxima', 'Ingrese la cantidad máxima deseada') !!}
		{!! Form::number('cantidad_maxima', $solicitudProducto->cantidad_maxima, ['class' => ' form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('estatus', 'Status') !!}
		{!! Form::select('status', ['0' => 'Inactiva', '1' => 'Activa' ], $solicitudProducto->status, ['class' => 'form-control']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close() !!}