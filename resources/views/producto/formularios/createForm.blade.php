{!! Html::script('js/productos/cargarClases.js') !!}
{!! Html::script('js/productos/verificarNombre.js') !!}

{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

	{!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
	{!! Form::hidden('creador_id', session('perfilId')) !!}

	@if (session('perfilTipo') == 'P')
		{!! Form::hidden('publicado', '1') !!}
		{!! Form::hidden('confirmado', '1') !!}
	@else
		{!! Form::hidden('publicado', '0') !!}
		{!! Form::hidden('confirmado', '0') !!}
	@endif
	
	<!-- Para efectos de la Consulta Ajax de Verificar Nombre-->
	{!! Form::hidden('id_producto', '0', ['id' => 'id_producto']) !!}

	<div class="form-group">
		{!! Form::label('marca', 'Marca (*)') !!}
		{!! Form::select('marca_id', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca..', 'required']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('nombre', 'Nombre (*)') !!}
		{!! Form::text('nombre', null, ['class' => 'form-control', 'required', 'id' => 'nombre', 'onblur' => 'verificarNombre();'] ) !!}
		<div class="alert alert-danger" style="display: none;" id="errorNombre">
			<strong>Ups!!</strong> Ya existe un producto con este nombre.
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre Seo (*)') !!}
		{!! Form::text('nombre_seo', null, ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción') !!}
		{!! Form::text('descripcion', null, ['class' => 'form-control'] ) !!}
	</div>
		
	<div class="form-group">
		{!! Form::label('pais_id', 'País de origen (*)') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('bebida', 'Tipo de Bebida (*)') !!}
		{!! Form::select('bebida_id', $tipos_bebidas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un tipo..', 'id' => 'bebida_id', 'onchange' => 'cargarClases("N");', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('clase', 'Clase de Bebida (*)') !!}
		<select name="clase_bebida_id" class="form-control" id="clases_bebidas" disabled required>
			<option value="">Seleccione una clase..</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('ano_produccion', 'Año de Producción') !!}
		{!! Form::text('ano_produccion', null, ['class' => 'form-control'] ) !!}
	</div>
		
	<div class="form-group">
		{!! Form::label('imagen', 'Logo / Imagen (*)') !!}
		{!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Crear Producto', ['class' => 'btn btn-primary pull-right', 'id' => 'boton']) !!}
	</div>
		
{!! Form::close() !!}