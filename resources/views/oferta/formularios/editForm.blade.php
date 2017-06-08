	{!! Html::script('js/ofertas/edit.js') !!}

	{!! Form::hidden('v_importadores', $oferta->visible_importadores, ['id' => 'v_importadores']) !!}
	{!! Form::hidden('v_distribuidores', $oferta->visible_distribuidores, ['id' => 'v_distribuidores']) !!}
	{!! Form::hidden('v_horecas', $oferta->visible_horecas, ['id' => 'v_horecas']) !!}
	{!! Form::hidden('producto_id', $oferta->producto_id) !!}
	{!! Form::hidden('envio_hidden', $oferta->envio, ['id' => 'envio_hidden']) !!}

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
		{!! Form::label('envio', 'Envío Disponible') !!}
		<select name="envio" class="form-control" id="envio">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', $oferta->costo_envio, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('visible_importadores', 'Disponible para Importadores') !!}
		<select name="visible_importadores" class="form-control" id="visible_importadores">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('visible_distribuidores', 'Disponible para Distribuidores') !!}
		<select name="visible_distribuidores" class="form-control" id="visible_distribuidores">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('visible_horecas', 'Visible para Horecas') !!}
		<select name="visible_horecas" class="form-control" id="visible_horecas">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
	</div>