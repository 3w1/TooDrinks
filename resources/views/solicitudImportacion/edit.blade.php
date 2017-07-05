@extends('plantillas.main')
@section('title', 'Solicitud de Importación')

@section('items')
	<span><strong><h3>Modificar Solicitud de Importación</h3></strong></span>
@endsection

@section('content-left')
	
	{!! Form::open(['route' => ['solicitar-importacion.update', $solicitudImportacion->id], 'method' => 'PUT']) !!}

		<div class="form-group">
			{!! Form::label('statu', 'Status') !!}
			{!! Form::select('status', ['0' => 'Inactiva', '1' => 'Activa'], $solicitudImportacion->status, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}
	
@endsection