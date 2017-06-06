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
		{!! Form::label('envio', 'Envío Disponible') !!}
		<select name="envio" class="form-control">
			<option value="1">Si</option>
			<option value="0">No</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('costo_envio', 'Costo del Envío') !!}
		{!! Form::text('costo_envio', null, ['class' => 'form-control', 'placeholder' => 'Costo del Envío'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('visible_importadores', 'Visible para Importadores') !!}
		<select name="visible_importadores" class="form-control">
			<option value="1">Si</option>
			<option value="0">No</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('visible_distribuidores', 'Visible para Importadores') !!}
		<select name="visible_distribuidores" class="form-control">
			<option value="1">Si</option>
			<option value="0">No</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('visible_horecas', 'Visible para Horecas') !!}
		<select name="visible_horecas" class="form-control">
			<option value="1">Si</option>
			<option value="0">No</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'Seleccione el país que será destino de la oferta') !!}
		<select name="pais_id" id="pais_id" class="form-control">
			<option value="">Seleccione un país..</option>
			@foreach ($paises as $pais )
				<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'Seleccione las provincias que serán destino de la oferta') !!}
		<select name="opciones" id="opciones" class="form-control" onchange="estados();">
			<option value="">Seleccione una opción</option>
			<option value="T">Todas las provincias</option>
			<option value="P">Personalizado</option>
		</select>
	</div>

	<div class="form-group" id="estados"></div>
	
	<div class="form-group">
		{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary']) !!}
	</div>