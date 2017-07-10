@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Modificar Suscripción '.$suscripcion->suscripcion)
@section('content-left')
	@include('suscripcion.formularios.editForm')
@endsection