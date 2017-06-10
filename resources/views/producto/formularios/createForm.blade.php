		
		{!! Html::script('js/productos/create.js') !!}

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
			{!! Form::label('pais_id', 'País origen del producto') !!}
			{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'onchange' => 'cargarProvincias();'] ) !!}
		</div>

		<div class="form-group">
			<select name="provincia_region_id" class="form-control" id="provincias">
				<option value="">Seleccione una provincia..</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('clase_bebida_id', 'Clase a la que pertenece el producto') !!}
			{!! Form::select('clase_bebida_id', $clases_bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una clase..'] ) !!}
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