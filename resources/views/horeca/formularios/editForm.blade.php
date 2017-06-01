@if (Session::has('msj'))
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
	</div>
@endif

@section('title-header')
	<span><h3>Editar Perfil</h3></span>
@endsection

@include('horeca.modales.modalAvatar')


<div class="row">
  	<div class="col-sm-6 col-md-3">
   		<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/horecas/') }}/{{ $horeca->logo }}"></a>
  	</div>
</div>

{!! Form::open(['route' => ['horeca.update', $horeca->id], 'method' => 'PUT']) !!}
	
	{!! Form::hidden('saldo', $horeca->saldo) !!}
	{!! Form::hidden('reclamada_hidden', $horeca->reclamada, ['id' => 'reclamada_hidden']) !!}
	{!! Form::hidden('pais_hidden', $horeca->pais_id, ['id' => 'pais_hidden']) !!}
	{!! Form::hidden('provincia_hidden', $horeca->provincia_region_id, ['id' => 'provincia_hidden']) !!}
	{!! Form::hidden('datos_hidden', $horeca->estado_datos, ['id' => 'datos_hidden']) !!}
	{!! Form::hidden('tipo_hidden', $horeca->tipo_horeca, ['id' => 'tipo_hidden']) !!}

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
		{!! Form::label('reclamada', 'Reclamada') !!}
		<select name="reclamada" id="reclamada" class="form-control">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
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
		<select name="estado_datos" id="estado_datos" class="form-control">
			<option value="0">Sin Actualizar</option>
			<option value="1">Actualizados</option>
		</select>
	</div>

	<div class="form-group">
		<select name="tipo_horeca" id="tipo_horeca" class="form-control">
			<option value="H">Hotel</option>
			<option value="R">Restaurante</option>
			<option value="C">Cafetería</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::submit('Modificar Horeca', ['class' => 'btn btn-primary']) !!}
	</div>
		
{!! Form::close() !!}