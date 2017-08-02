{!! Html::script('js/demandaProductos/create.js') !!}

{!! Form::open(['route' => 'demanda-producto.store', 'method' => 'POST']) !!}

	{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}
	{!! Form::hidden('cantidad_visitas', '0') !!}
	{!! Form::hidden('cantidad_contactos', '0') !!}

	<div class="form-group">
		{!! Form::label('titulo', 'Título de la Demanda (*)') !!}
		{!! Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un título para la demanda', 'required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('opcion', '¿Qué tipo de producto busca? (*)') !!}
		{!! Form::select('tipo_producto', ['P' => 'Producto Específico', 'B' => 'Bebida por Región'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..', 'id' => 'opcion', 'onchange' => 'cargarOpcion();']) !!}
	</div>

	<div class="form-group" id="productos" style="display: none;">
		{!! Form::label('productos', 'Producto (*)') !!}
		{!! Form::select('producto_id', $productos, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un producto..', 'required']) !!}
	</div>

	<div id="bebidas" style="display: none;">
		<div class="form-group">
			{!! Form::label('bebidas', 'Bebida (*)') !!}
			{!! Form::select('bebida_id', $bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una bebida..', 'required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('paises', 'País (*)') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();', 'required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('provincias', 'Provincia (*)') !!}
			<select class="form-control" name="provincia_region_id" id="provincias" required disabled>
				<option value="">Seleccione una provincia..</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción (*)') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Ingrese una breve descripción para la demanda', 'required', 'rows' => '5']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('cantidad_minima', 'Cantidad Mínima (*)') !!}
		{!! Form::number('cantidad_minima', '0', ['class' => ' form-control', 'required'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('cantidad_maxima', 'Cantidad Máxima (*)') !!}
		{!! Form::number('cantidad_maxima', '0', ['class' => ' form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Registrar', ['class' => 'btn btn-primary pull-right']) !!}
	</div>

{!! Form::close() !!}