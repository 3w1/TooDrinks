@if (session('perfil') == 'P')
	@extends('plantillas.productor.mainProductor')
@elseif (session('perfil') == 'I')
	@extends('plantillas.importador.mainImportador')
@elseif (session('perfil') == 'D')
	@extends('plantillas.distribuidor.mainDistribuidor')
@else 
	@extends('plantillas.usuario.mainUsuario')
@endif 

@section('title', 'Agregar Producto')

@section('items')
@endsection

@section('content-left')
	
	{!! Form::open(['route' => 'producto.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		{!! Form::hidden('tipo_creador', session('perfil')) !!}
		{!! Form::hidden('creador_id', session('perfil_id')) !!}
		

		@if (session('perfil') == 'P')
			{!! Form::hidden('confirmada', '1') !!}
		@elseif (session('perfil') == 'I')

		@elseif (session('perfil') == 'D')

		@else 
			{!! Form::hidden('publicada', '0') !!}
		@endif 

@endsection