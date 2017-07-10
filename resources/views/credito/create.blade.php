@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Crear Plan de Crédito')

@section('title-header')
  Crear Plan de Crédito
@endsection

@section('content-left')

	@include('plantillas.alertas.AlertasRequest')	
	@include('credito.formularios.createForm')
	
@endsection