@extends('plantillas.main')
@section('title', 'Modificar Usuario'.$horeca->nombre)
@section('content-left')

	{!! Html::script('js/horecas/edit.js') !!}

		@include('horeca.formularios.editForm')
	>
	
@endsection