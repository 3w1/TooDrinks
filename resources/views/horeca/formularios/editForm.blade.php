<div class="row">
  	<div class="col-sm-6 col-md-3">
   		<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/horecas/') }}/{{ $horeca->logo }}"></a>
  	</div>
</div>

{!! Form::open(['route' => ['horeca.update', $horeca->id], 'method' => 'PUT']) !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre del Horeca') !!}
		{!! Form::text('nombre', $horeca->nombre, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre SEO del Horeca') !!}
		{!! Form::text('nombre_seo', $horeca->nombre_seo, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', $horeca->descripcion, ['class' => 'form-control', 'rows' => '4'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion', 'Dirección') !!}
		{!! Form::textarea('direccion', $horeca->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('codigo_postal', 'Código Postal') !!}
		{!! Form::text('codigo_postal', $horeca->codigo_postal, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('pais', 'País') !!}
		{!! Form::select('pais_id', $paises, $horeca->pais_id, ['class' => 'form-control', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('provincias', 'Provincia') !!}
		{!! Form::select('provincia_region_id', $provincias, $horeca->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
	</div>

	<div class="form-group">
		{!! Form::label('persona_contacto', 'Persona de Contacto') !!}
		{!! Form::text('persona_contacto', $horeca->persona_contacto, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono', 'Teléfono') !!}
		{!! Form::text('telefono', $horeca->telefono, ['class' => 'form-control', 'placeholder' => 'Teléfono'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono_opcional', 'Teléfono') !!}
		{!! Form::text('telefono_opcional', $horeca->telefono_opcional, ['class' => 'form-control', 'placeholder' => 'Teléfono Opcional'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email', 'Correo Electrónico') !!}
		{!! Form::email('email', $horeca->email, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('website', 'Website') !!}
		{!! Form::url('website', $horeca->email, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('facebook', 'Facebook') !!}
		{!! Form::url('facebook', $horeca->facebook, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('twitter', 'Twitter') !!}
		{!! Form::text('twitter', $horeca->twitter, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('instagram', 'Instagram') !!}
		{!! Form::text('instagram', $horeca->instagram, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('latitud', 'Latitud') !!}
		{!! Form::text('latitud', $horeca->latitud, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('longitud', 'Longitud') !!}
		{!! Form::text('longitud', $horeca->longitud, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('tip', 'Tipo de Horeca') !!}
		{!! Form::select('tipo_horeca', ['H' => 'Hotel', 'R' => 'Restaurant', 'C' => 'Cafetería'], $horeca->tipo_horeca, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Modificar Horeca', ['class' => 'btn btn-primary']) !!}
	</div>
		
{!! Form::close() !!}