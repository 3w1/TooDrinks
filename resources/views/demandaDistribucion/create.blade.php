@extends('plantillas.main')
@section('title', 'Solicitar Distribuidor')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Solicitar Distribuidor</b></h3>
	@endsection

	@include('demandaDistribucion.formularios.createForm')

@endsection