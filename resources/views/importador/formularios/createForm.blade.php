{!! Html::script('js/importadores/create.js') !!}

{!! Form::open(['route' => 'importador.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

	{!! Form::hidden('user_id', '0') !!}	
	{!! Form::hidden('reclamada', '0') !!}
	{!! Form::hidden('estado_datos', '0') !!}
	{!! Form::hidden('saldo', '0') !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre') !!}
		{!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre SEO') !!}
		{!! Form::text('nombre_seo', null, ['class' => 'form-control', 'placeholder' => 'Nombre SEO'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripcion', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion', 'Dirección') !!}
		{!! Form::textarea('direccion', null, ['class' => 'form-control', 'placeholder' => 'Dirección', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('codigo_postal', 'Código Postal') !!}
		{!! Form::text('codigo_postal', null, ['class' => 'form-control', 'placeholder' => 'Código Postal'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('pais', 'País') !!}
		{!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'id' => 'pais_id', 'placeholder' => 'Seleccione un país..', 'onchange' => 'cargarProvincias();']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincia', 'Provincia') !!}
		<select name="provincia_region_id" class="form-control" id="provincias">
			<option value="">Seleccione una provincia..</option>
		</select>
	</div>
	
	<div class="form-group">
		{!! Form::label('persona_contacto', 'Persona de Contacto') !!}
		{!! Form::text('persona_contacto', null, ['class' => 'form-control', 'placeholder' => 'Persona de Contacto'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono', 'Teléfono') !!}
		{!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono_opcional', 'Teléfono') !!}
		{!! Form::text('telefono_opcional', null, ['class' => 'form-control', 'placeholder' => 'Teléfono Opcional'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email', 'Correo Electrónico') !!}
		{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo Electrónico'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('website', 'Website') !!}
		{!! Form::url('website', null, ['class' => 'form-control', 'placeholder' => 'Website'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('facebook', 'Facebook') !!}
		{!! Form::url('facebook', null, ['class' => 'form-control', 'placeholder' => 'Facebook'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('twitter', 'Twitter') !!}
		{!! Form::text('twitter', null, ['class' => 'form-control', 'placeholder' => 'Twitter'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('instagram', 'Instagram') !!}
		{!! Form::text('instagram', null, ['class' => 'form-control', 'placeholder' => 'Instagram'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('latitud', 'Latitud') !!}
		{!! Form::text('latitud', null, ['class' => 'form-control', 'placeholder' => 'Latitud'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('longitud', 'Longitud') !!}
		{!! Form::text('longitud', null, ['class' => 'form-control', 'placeholder' => 'Longitud'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('tipo_suscripcion', 'Tipo de Suscripción') !!}
		{!! Form::select('tipo_suscripcion', ['B' => 'Básica', 'A' => 'Avanzada', 'P' => 'Premium'], null, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('logo', 'Logo / Avatar') !!}
		{!! Form::file('logo', ['class' => 'form-control', 'required'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Agregar Importador', ['class' => 'btn btn-primary']) !!}
	</div>

{!! Form::close()!!}