
@if (Session::has('msj'))
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
	</div>
@endif

@section('title-header')
	<span><h3>Editar Perfil</h3></span>
@endsection

@include('productor.modales.modalAvatar')


<div class="row">
  		<div class="col-sm-6 col-md-3">
    		<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/productores/') }}/{{ $productor->logo }}" alt="..."></a>
  		</div>
	</div>


	
{!! Form::open(['route' => ['productor.update', $productor->id], 'method' => 'PUT']) !!}
	
	{!! Form::hidden('user_id', Auth::user()->id) !!}
	{!! Form::hidden('saldo', $productor->saldo) !!}
	{!! Form::hidden('pais_hidden', $productor->pais_id, ['id' => 'pais_hidden']) !!}
	{!! Form::hidden('provincia_hidden', $productor->provincia_region_id, ['id' => 'provincia_hidden']) !!}
	{!! Form::hidden('reclamada_hidden', $productor->reclamada, ['id' => 'reclamada_hidden']) !!}
	{!! Form::hidden('datos_hidden', $productor->estado_datos, ['id' => 'datos_hidden']) !!}

	<div class="form-group">
		{!! Form::label('nombre', 'Nombre') !!}
		{!! Form::text('nombre', $productor->nombre, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('nombre_seo', 'Nombre SEO') !!}
		{!! Form::text('nombre_seo', $productor->nombre_seo, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripcion') !!}
		{!! Form::textarea('descripcion', $productor->descripcion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('direccion', 'Dirección') !!}
		{!! Form::textarea('direccion', $productor->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('codigo_postal', 'Código Postal') !!}
		{!! Form::text('codigo_postal', $productor->codigo_postal, ['class' => 'form-control'] ) !!}
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
		{!! Form::text('persona_contacto', $productor->persona_contacto, ['class' => 'form-control'] ) !!}
	</div>
	
	<div class="form-group">
		{!! Form::label('telefono', 'Teléfono') !!}
		{!! Form::text('telefono', $productor->telefono, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('telefono_opcional', 'Teléfono Opcional') !!}
		{!! Form::text('telefono_opcional', $productor->telefono_opcional, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('email', 'Correo Electrónico') !!}
		{!! Form::email('email', $productor->email, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('website', 'Website') !!}
		{!! Form::url('website', $productor->website, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('facebook', 'Facebook') !!}
		{!! Form::url('facebook', $productor->facebook, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('twitter', 'Twitter') !!}
		{!! Form::text('twitter', $productor->twitter, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('instagram', 'Instagram') !!}
		{!! Form::text('instagram', $productor->instagram, ['class' => 'form-control'] ) !!}
	</div>

	<div class="form-group">
		<select name="reclamada" id="reclamada" class="form-control">
			<option value="0">No</option>
			<option value="1">Si</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('latitud', 'Latitud') !!}
		{!! Form::text('latitud', $productor->latitud, ['class' => 'form-control', 'placeholder' => 'Latitud'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('longitud', 'Longitud') !!}
		{!! Form::text('longitud', $productor->longitud, ['class' => 'form-control', 'placeholder' => 'Longitud'] ) !!}
	</div>

	<div class="form-group">
		<select name="estado_datos" id="estado_datos" class="form-control">
			<option value="0">Sin Actualizar</option>
			<option value="1">Actualizados</option>
		</select>
	</div>

	<div class="form-group">
		{!! Form::label('tipo_suscripcion', 'Tipo de Suscripción') !!}
		{!! Form::text('tipo_suscripcion', $productor->tipo_suscripcion, ['class' => 'form-control', 'placeholder' => 'Tipo de Suscripción'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Actualizar Datos', ['class' => 'btn btn-primary']) !!}
	</div>
		
{!! Form::close() !!}
