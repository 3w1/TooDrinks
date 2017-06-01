@extends('plantillas.productor.mainProductor')
@section('title', 'Modificar Productor '.$productor->nombre)
@section('content-left')

	{!! Html::script('js/productores/edit.js') !!}

	
		@include('productor.formularios.editForm')

	
@endsection