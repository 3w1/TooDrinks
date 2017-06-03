	{!! Form::hidden('user_id', Auth::user()->id) !!}
	{!! Form::hidden('reclamada', '1') !!}
	{!! Form::hidden('estado_datos', '1') !!}
	{!! Form::hidden('saldo', '0') !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre del Horeca') !!}
		{!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del Horeca'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre SEO del Horeca') !!}
		{!! Form::text('nombre_seo', null, ['class' => 'form-control', 'placeholder' => 'Nombre SEO del Horeca'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '4',  'placeholder' => 'Descripción'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion', 'Dirección') !!}
		{!! Form::textarea('direccion', null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Dirección'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('codigo_postal', 'Código Postal') !!}
		{!! Form::text('codigo_postal', null, ['class' => 'form-control', 'placeholder' => 'Código Postal'] ) !!}
	</div>

	<div class="form-group">
		<select name="pais_id" class="form-control">
			@foreach ($paises as $pais )
				<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<select name="provincia_region_id" class="form-control">
			@foreach ($provincias as $provincia )
				<option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
			@endforeach
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
		<select name="tipo_horeca" class="form-control">
			<option value="H">Hotel</option>
			<option value="R">Restaurant</option>
			<option value="C">Cafetería</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('logo', 'Logotipo / Avatar') !!}
		{!! Form::file('logo', ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Agregar Horeca', ['class' => 'btn btn-primary']) !!}
	</div>