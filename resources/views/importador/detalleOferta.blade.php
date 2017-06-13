@extends('plantillas.main')
@section('title', 'Ver Oferta')

@section('items')
@endsection

@section('content-left')
	
	@include('importador.modales.editOferta')

	@section('title-header')
		<h3>Detalles de la Oferta <strong> {{ $oferta->titulo }} </strong></h3>
	@endsection

	@include('oferta.show')

@endsection
