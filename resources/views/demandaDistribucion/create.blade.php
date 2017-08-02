@extends('plantillas.main')
@section('title', 'Solicitar Distribuidor')

@section('title-header')
   Demanda de Distribuidor
@endsection

@section('title-complement')
   (Nueva Demanda)
@endsection

@section('content-left')

	@include('demandaDistribucion.formularios.createForm')

@endsection