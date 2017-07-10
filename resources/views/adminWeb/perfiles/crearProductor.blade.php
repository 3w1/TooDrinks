@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Productor')

@section('title-header')
   Crear Productor
@endsection

@section('content-left')

	@include('productor.formularios.createForm')
	
@endsection