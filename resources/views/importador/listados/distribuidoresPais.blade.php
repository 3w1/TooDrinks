@extends('plantillas.main')
@section('title', 'Listado de Importadores')

@section('title-header')
	<span><strong><h3>Distribuidores del País</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($distribuidores as $distribuidor)
			<div class="col-md-6 col-xs-12">

	         	<div class="box box-widget widget-user-2">

	           		<div class="widget-user-header bg-blue">
	              		<div class="widget-user-image">
	                		<img class="img-rounded" src="{{ asset('imagenes/distribuidores/thumbnails/')}}/{{ $distribuidor->logo }}">
	              		</div>
	           			<h3 class="widget-user-username">{{ $distribuidor->nombre }}</h3>
	           			<h5 class="widget-user-desc"> {{ $distribuidor->persona_contacto }} </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><strong>País: </strong> {{ $distribuidor->pais->pais }} </a></li>
	             			<li class="active"><a><strong>Provincia: </strong> {{ $distribuidor->provincia_region->provincia }} </a></li>
				            <li class="active"><a class="btn btn-primary" href="" ><strong>¡¡Contactar!!</strong><i class="fa fa-check"></i> </a></li>
				        </ul>
	            	</div>
	         	</div>
	        </div>
	    @endforeach
	</div>

	<div>
		<center>{!! $distribuidores->render() !!}</center>
	</div>

@endsection