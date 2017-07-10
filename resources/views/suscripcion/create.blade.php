@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Nueva Suscripción')

@section('title-header')
  Crear Suscripción
@endsection


@section('content-left')
	@include('suscripcion.formularios.createForm')
@endsection