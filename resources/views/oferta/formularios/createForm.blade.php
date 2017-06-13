	{!! Html::script('js/ofertas/create.js') !!}

	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

	<div class="form-group">
		{!! Form::label('titulo', 'Título') !!}
		{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Título'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripcion'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_unitario', 'Precio por Unidad') !!}
		{!! Form::text('precio_unitario', null, ['class' => 'form-control', 'placeholder' => 'Precio por Unidad'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio_lote', 'Precio por el Lote') !!}
		{!! Form::text('precio_lote', null, ['class' => 'form-control', 'placeholder' => 'Precio por el Lote'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_producto', 'Cantidad de Productos') !!}
		{!! Form::number('cantidad_producto', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de Productos'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_caja', 'Cantidad de Cajas') !!}
		{!! Form::number('cantidad_caja', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de Cajas'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima de Venta') !!}
		{!! Form::number('cantidad_minima', null, ['class' => 'form-control', 'placeholder' => 'Cantidad Mínima de Venta'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('env', 'Envío Disponible') !!}
		{!! Form::select('envio', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción']); !!}
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', null, ['class' => 'form-control', 'placeholder' => 'Costo del Envío'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'Seleccione el país que será destino de la oferta') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'Seleccione las provincias que serán destino de la oferta') !!}
		{!! Form::select('opciones', ['T' => 'Todas las Provincias', 'P' => 'Personalizado'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...', 'id' => 'opciones', 'onchange' => 'cargarProvincias();'] ) !!}
	</div>

	<div class="form-group" id="estados"></div>
	