@include('usuario.modales.modalAvatar')
	
@if (Session::has('status'))
	<div class="alert alert-success alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Enhorabuena!</strong> {{Session::get('status')}}.
	</div>
@endif

	<div class="row">
  		<div class="col-sm-6 col-md-3">
    		<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/usuarios/') }}/{{ $usuario->avatar }}" alt="..."></a>
  		</div>
	</div>

{!! Form::open(['route' => ['usuario.update', $usuario->id], 'method' => 'PUT']) !!}
		
	{!! Form::hidden('pais_hidden', $usuario->pais_id, ['id' => 'pais_hidden']) !!}
	{!! Form::hidden('provincia_hidden', $usuario->provincia_region_id, ['id' => 'provincia_hidden']) !!}
	{!! Form::hidden('datos_hidden', $usuario->estado_datos, ['id' => 'datos_hidden']) !!}
		
		<div class="form-group">
			{!! Form::label('name', 'Nombre de Usuario') !!}
			{!! Form::text('name', $usuario->name, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('email', 'Correo Electrónico') !!}
			{!! Form::email('email', $usuario->email, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('nombre', 'Nombre') !!}
			{!! Form::text('nombre', $usuario->nombre, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('apellido', 'Apellido') !!}
			{!! Form::text('apellido', $usuario->apellido, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('direccion', 'Dirección') !!}
			{!! Form::textarea('direccion', $usuario->direccion, ['class' => 'form-control', 'rows' => '5'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('codigo_postal', 'Código Postal') !!}
			{!! Form::text('codigo_postal', $usuario->codigo_postal, ['class' => 'form-control'] ) !!}
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
			<select name="estado_datos" id="estado_datos" class="form-control">
				<option value="0">Sin Actualizar</option>
				<option value="1">Actualizados</option>
			</select>
		</div>

		<div class="form-group">
			{!! Form::label('telefono', 'Teléfono') !!}
			{!! Form::text('telefono', $usuario->telefono, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::label('telefono_opcional', 'Teléfono') !!}
			{!! Form::text('telefono_opcional', $usuario->telefono_opcional, ['class' => 'form-control'] ) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Modificar Usuario', ['class' => 'btn btn-primary']) !!}
		</div>
		
	{!! Form::close() !!}