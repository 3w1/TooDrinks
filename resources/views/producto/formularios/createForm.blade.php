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
			{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca..', 'required']) !!}
		</div>
	@else
		{!! Form::hidden('marca_id', $id)!!}
	@endif		

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre (*)') !!}
		{!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese un nombre para el producto'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre Seo (*)') !!}
		{!! Form::text('nombre_seo', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese un Nombre SEO para el producto'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción (*)') !!}
		{!! Form::text('descripcion', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese una descripción para el producto'] ) !!}
	</div>
		
	<div class="form-group">
		{!! Form::label('pais_id', 'País de origen (*)') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('bebida', 'Tipo de Bebida (*)') !!}
		{!! Form::select('bebida_id', $tipos_bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo..', 'id' => 'bebida_id', 'onchange' => 'cargarClases();', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('clase', 'Clase de Bebida (*)') !!}
		<select name="clase_bebida_id" class="form-control" id="clases_bebidas" disabled required>
			<option value="">Seleccione una clase..</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('ano_produccion', 'Año de Producción (*)') !!}
		{!! Form::text('ano_produccion', null, ['class' => 'form-control', 'required', 'placeholder' => 'Año de Producción'] ) !!}
	</div>
		
	<div class="form-group">
		{!! Form::label('imagen', 'Logo /Imgane (*)') !!}
		{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Registrar Producto', ['class' => 'btn btn-primary pull-right']) !!}
	</div>
		
{!! Form::close() !!}