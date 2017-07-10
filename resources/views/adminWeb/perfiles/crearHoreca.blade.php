@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Horeca')

@section('title-header')
   Crear Horeca
@endsection

@section('content-left')

	@include('horeca.formularios.createForm')
	
@endsection