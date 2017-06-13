@extends('plantillas.main')
@section('title', 'Crear Oferta')

@section('items')

@endsection

@section('content-left')
	
	@section('title-header')
		<h3><b>Crear Oferta  del Producto {{ $producto }}</b></h3>
	@endsection
	
	{!! Form::open(['route' => 'oferta.store', 'method' => 'POST']) !!}
		
		{!! Form::hidden('who', 'P') !!}

		{!! Form::hidden('tipo_creador', 'P') !!}
		{!! Form::hidden('creador_id', session('productorId')) !!}
		{!! Form::hidden('producto_id', $id) !!}

		@include('oferta.formularios.createForm')
		
		<div class="form-group">
            {!! Form::label('visible_importador', 'Disponible para Importadores') !!}
            {!! Form::select('visible_importadores', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
        </div>

		<div class="form-group">
            {!! Form::label('visible_distribuidor', 'Disponible para Distribuidores') !!}
            {!! Form::select('visible_distribuidores', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('visible_horeca', 'Visible para Horecas') !!}
            {!! Form::select('visible_horecas', ['0' => 'No', '1' => 'Si'], null, ['class' => 'form-control']); !!}
        </div>  

        <div class="form-group">
			{!! Form::submit('Crear Oferta', ['class' => 'btn btn-primary']) !!}
		</div>
		
		{!! Form::close() !!}

@endsection