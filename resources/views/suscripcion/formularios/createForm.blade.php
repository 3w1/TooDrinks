{!! Form::open(['route' => 'suscripcion.store', 'method' => 'POST']) !!}
	<div class="form-group">
		{!! Form::label('suscripcion', 'Nombre del Plan de Suscripcion') !!}
		{!! Form::text('suscripcion', null, ['class' => 'form-control', 'placeholder' => 'Nombre del Plan de Suscripción'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('creditos', 'Creditos Disponibles') !!}
		{!! Form::text('creditos_disponibles', null, ['class' => 'form-control', 'placeholder' => 'Cantidad de Créditos'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('precio', 'Precio') !!}
		{!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => 'Precio'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::label('descripcion', 'Descripción') !!}
		{!! Form::textarea('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción del Plan', 'rows' => '4'] ) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
	</div>		
{!! Form::close() !!}