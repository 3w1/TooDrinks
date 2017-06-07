@extends('plantillas.productor.mainProductor')
@section('title', 'Ver Oferta')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3>Detalles de la Oferta <strong> {{ $oferta->titulo }} </strong></h3>
	@endsection
		
	@include('oferta.show')

@endsection
