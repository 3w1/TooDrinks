@extends('plantillas.main')
@section('title', 'Solicitud de Importación')

@section('items')
	<span><strong><h3>Modificar Solicitud de Distribución</h3></strong></span>
@endsection

@section('content-left')
	
	{!! Form::open(['route' => ['solicitar-distribucion.update', $solicitudDistribucion->id], 'method' => 'PUT']) !!}

		<div class="form-group">
			{!! Form::label('statu', 'Status') !!}
			{!! Form::select('status', ['0' => 'Inactiva', '1' => 'Activa'], $solicitudDistribucion->status, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}
	
@endsection