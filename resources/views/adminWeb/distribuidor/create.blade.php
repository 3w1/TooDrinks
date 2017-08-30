@extends('adminWeb.plantillas.main')
@section('title', 'Crear Distribuidor')

@section('title-header')
   Crear Distribuidor
@endsection

@section('content-left')

	@include('distribuidor.formularios.createForm')
	
@endsection