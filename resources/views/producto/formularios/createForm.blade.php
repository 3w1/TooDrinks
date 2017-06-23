{!! Html::script('js/productos/create.js') !!}

{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
	
	{!! Form::hidden('marca_nombre', $marca) !!}
	{!! Form::hidden('usuario', $usuario) !!}

	@if ($usuario == '1')
		{!! Form::hidden('tipo_creador', 'U') !!}
		{!! Form::hidden('creador_id', Auth::user()->id) !!}
		{!! Form::hidden('publicado', '0') !!}
		{!! Form::hidden('confirmado', '0') !!}
	@else
		{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
		{!! Form::hidden('creador_id', session('perfilId')) !!}
		{!! Form::hidden('publicado', '1') !!}
		@if (session('perfilTipo') == 'P')
			{!! Form::hidden('confirmado', '1') !!}
		@else 
			{!! Form::hidden('confirmado', '0') !!}
		@endif
	@endif
	
	@if ($id == '0')
		<div class="form-group">
			{!! Form::label('marca', 'Marca') !!}
			{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca..']) !!}
		</div>
	@else
		{!! Form::hidden('marca_id', $id)!!}
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