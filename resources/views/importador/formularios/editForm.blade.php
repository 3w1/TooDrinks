@if (Session::has('msj'))
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
	</div>
@endif

@section('title-header')
	<span><h3>Editar Perfil</h3></span>
@endsection

@include('importador.modales.modalAvatar')


<div class="row">
  	<div class="col-sm-6 col-md-3">
    	<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/importadores/') }}/{{ $importador->logo }}" alt="..."></a>
  	</div>
</div>

{!! Form::open(['route' => ['importador.update', $importador->id], 'method' => 'PUT']) !!}
	
	{!! Form::hidden('user_id', '1') !!}
	{!! Form::hidden('saldo', '0') !!}
	{!! Form::hidden('pais_hidden', $importador->pais_id, ['id' => 'pais_hidden']) !!}
	{!! Form::hidden('provincia_hidden', $importador->provincia_region_id, ['id' => 'provincia_hidden']) !!}
	{!! Form::hidden('reclamada_hidden', $importador->reclamada, ['id' => 'reclamada_hidden']) !!}
	{!! Form::hidden('datos_hidden', $importador->estado_datos, ['id' => 'datos_hidden']) !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre') !!}
		{!! Form::text('nombre', $importador->nombre, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre SEO') !!}
		{!! Form::text('nombre_seo', $importador->nombre_seo, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', $importador->descripcion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion', 'Dirección') !!}
		{!! Form::textarea('direccion', $importador->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('codigo_postal', 'Código Postal') !!}
		{!! Form::text('codigo_postal', $importador->codigo_postal, ['class' => 'form-control'] ) !!}
	</div>
	
	<div class="form-group">
		<select name="pais_id" id="pais_id" class="form-control">
			@foreach ($paises as $pais )
				<option value="{{ $pais->id }}">{{ $pais->pais }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<select name="provincia_region_id" id="provincia_id" class="form-control">
			@foreach ($provincias as $provincia )
				<option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
			@endforeach
		</select>
	</div>
	
	<div class="form-group">
		{!! Form::label('persona_contacto', 'Persona de Contacto') !!}
		{!! Form::text('persona_contacto', $importador->persona_contacto, ['class' => 'form-control'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('telefono', 'Teléfono') !!}
		{!! Form::text('telefono', $importador->telefono, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono_opcional', 'Teléfono Opcional') !!}
		{!! Form::text('telefono_opcional', $importador->telefono_opcional, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email', 'Correo Electrónico') !!}
		{!! Form::email('email', $importador->email, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('website', 'Website') !!}
		{!! Form::url('website', $importador->website, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('facebook', 'Facebook') !!}
		{!! Form::url('facebook', $importador->facebook, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('twitter', 'Twitter') !!}
		{!! Form::text('twitter', $importador->twitter, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('instagram', 'Instagram') !!}
		{!! Form::text('instagram', $importador->instagram, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		<select name="reclamada" id="reclamada" class="form-control">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('latitud', 'Latitud') !!}
		{!! Form::text('latitud', $importador->latitud, ['class' => 'form-control', 'placeholder' => 'Latitud'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('longitud', 'Longitud') !!}
		{!! Form::text('longitud', $importador->longitud, ['class' => 'form-control', 'placeholder' => 'Longitud'] ) !!}
	</div>

	<div class="form-group">
		<select name="estado_datos" id="estado_datos" class="form-control">
			<option value="0">Sin Actualizar</option>
			<option value="1">Actualizados</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('tipo_suscripcion', 'Tipo de Suscripción') !!}
		{!! Form::text('tipo_suscripcion', $importador->tipo_suscripcion, ['class' => 'form-control', 'placeholder' => 'Tipo de Suscripción'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar Datos', ['class' => 'btn btn-primary']) !!}
	</div>
		
{!! Form::close() !!}
