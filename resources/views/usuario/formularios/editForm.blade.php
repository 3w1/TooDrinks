<div class="row">
  	<div class="col-sm-6 col-md-3">
   		<a href="" class="thumbnail" data-toggle='modal' data-target='#myModal'><img src="{{ asset('imagenes/usuarios/thumbnails/') }}/{{ $usuario->avatar }}" alt="..."></a>
  	</div>
</div>

{!! Form::open(['route' => ['usuario.update', $usuario->id], 'method' => 'PUT']) !!}
		
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
		{!! Form::label ('pais_id','País') !!}
		{!! Form::select('pais_id', $paises, $usuario->pais_id, ['class' => 'form-control', 'id' => 'pais_id', 'onchange' => 'cargarProvincias();']) !!}
	</div>
		
	<div class="form-group">
		{!! Form::label ('provincia','Provincia') !!}
		{!! Form::select('provincia_region_id', $provincias, $usuario->provincia_region_id, ['class' => 'form-control', 'id' => 'provincias']) !!}
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