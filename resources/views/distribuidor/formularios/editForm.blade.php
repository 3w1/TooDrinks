<div class="row">
  	<div class="col-sm-6 col-md-3">
   		<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/distribuidores/') }}/{{ $distribuidor->logo }}"></a>
  	</div>
</div>

{!! Form::open(['route' => ['distribuidor.update', $distribuidor->id], 'method' => 'PUT']) !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre') !!}
		{!! Form::text('nombre', $distribuidor->nombre, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre SEO') !!}
		{!! Form::text('nombre_seo', $distribuidor->nombre_seo, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', $distribuidor->descripcion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion', 'Dirección') !!}
		{!! Form::textarea('direccion', $distribuidor->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('codigo_postal', 'Código Postal') !!}
		{!! Form::text('codigo_postal', $distribuidor->codigo_postal, ['class' => 'form-control'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('pais', 'País') !!}
		{!! Form::select('pais_id', $paises, $distribuidor->pais_id, ['class' => 'form-control', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincias', 'Provincia') !!}
		{!! Form::select('provincia_region_id', $provincias, $distribuidor->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('persona_contacto', 'Persona de Contacto') !!}
		{!! Form::text('persona_contacto', $distribuidor->persona_contacto, ['class' => 'form-control'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('telefono', 'Teléfono') !!}
		{!! Form::text('telefono', $distribuidor->telefono, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono_opcional', 'Teléfono Opcional') !!}
		{!! Form::text('telefono_opcional', $distribuidor->telefono_opcional, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email', 'Correo Electrónico') !!}
		{!! Form::email('email', $distribuidor->email, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('website', 'Website') !!}
		{!! Form::url('website', $distribuidor->website, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('facebook', 'Facebook') !!}
		{!! Form::url('facebook', $distribuidor->facebook, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('twitter', 'Twitter') !!}
		{!! Form::text('twitter', $distribuidor->twitter, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('instagram', 'Instagram') !!}
		{!! Form::text('instagram', $distribuidor->instagram, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('latitud', 'Latitud') !!}
		{!! Form::text('latitud', $distribuidor->latitud, ['class' => 'form-control', 'placeholder' => 'Latitud'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('longitud', 'Longitud') !!}
		{!! Form::text('longitud', $distribuidor->longitud, ['class' => 'form-control', 'placeholder' => 'Longitud'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('tipo_suscripcion', 'Tipo de Suscripción') !!}
		{!! Form::text('tipo_suscripcion', $distribuidor->tipo_suscripcion, ['class' => 'form-control', 'placeholder' => 'Tipo de Suscripción'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar Datos', ['class' => 'btn btn-primary']) !!}
	</div>
		
{!! Form::close() !!}
