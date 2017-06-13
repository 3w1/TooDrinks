@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Distribuidores')

@section('title-header')
	<span><strong><h3>Distribuidores sin Propietario</h3></strong></span>
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
	           			<h5 class="widget-user-desc"> Sin Propietario </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><stron>País: </stron> {{ $distribuidor->pais->pais }} </a></li>
	             			<li class="active"><a><stron>Provincia: </stron> {{ $distribuidor->provincia_region->provincia }} </a></li>
	              			<li class="active"><a><stron>Descripción: </stron> {{ $distribuidor->descripcion }} </a></li>
				               <li class="active"><a href="{{ route('usuario.reclamar-distribuidor', $distribuidor->id) }}" ><strong>Reclamar de mi Propiedad</strong> </a></li>
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