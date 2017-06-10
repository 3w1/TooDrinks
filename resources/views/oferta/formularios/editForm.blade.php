	{!! Html::script('js/ofertas/edit.js') !!}

	{!! Form::hidden('producto_id', $oferta->producto_id) !!}

	<div class="form-group">
		{!! Form::label('titulo', 'Título') !!}
		{!! Form::text('titulo', $oferta->titulo, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', $oferta->descripcion, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_unitario', 'Precio por Unidad') !!}
		{!! Form::text('precio_unitario', $oferta->precio_unitario, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_lote', 'Precio por el Lote') !!}
		{!! Form::text('precio_lote', $oferta->precio_lote, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_producto', 'Cantidad de Productos') !!}
		{!! Form::number('cantidad_producto', $oferta->cantidad_producto, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_caja', 'Cantidad de Cajas') !!}
		{!! Form::number('cantidad_caja', $oferta->cantidad_caja, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima de Venta') !!}
		{!! Form::number('cantidad_minima', $oferta->cantidad_minima, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('env', 'Envío Disponible') !!}
		{!! Form::select('envio', ['0' => 'No', '1' => 'Si'], $oferta->envio, ['class' => 'form-control']); !!}
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', $oferta->costo_envio, ['class' => 'form-control'] ) !!}
	</div>