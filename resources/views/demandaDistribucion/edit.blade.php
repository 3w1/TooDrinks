@extends('plantillas.main')
@section('title', 'Modificar Demanda de Distribución')

@section('items')
@endsection

@section('content-left')

	@section('title-header')
		<h3><b>Modificar Demanda de Distribución</b></h3>
	@endsection

	@include('demandaDistribucion.formularios.editForm')

@endsection