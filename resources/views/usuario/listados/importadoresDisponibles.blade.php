@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Importadores')

@section('title-header')
	<span><strong><h3>Importadores sin Propietario</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($importadores as $importador)
			<div class="col-md-6 col-xs-12">

	         	<div class="box box-widget widget-user-2">

	           		<div class="widget-user-header bg-blue">
	              		<div class="widget-user-image">
	                		<img class="img-rounded" src="{{ asset('imagenes/importadores/thumbnails/')}}/{{ $importador->logo }}">
	              		</div>
	           			<h3 class="widget-user-username">{{ $importador->nombre }}</h3>
	           			<h5 class="widget-user-desc"> Sin Propietario </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><stron>País: </stron> {{ $importador->pais->pais }} </a></li>
	             			<li class="active"><a><stron>Provincia: </stron> {{ $importador->provincia_region->provincia }} </a></li>
	              			<li class="active"><a><stron>Descripción: </stron> {{ $importador->descripcion }} </a></li>
				               <li class="active"><a href="{{ route('usuario.reclamar-importador', $importador->id) }}" ><strong>Reclamar de mi Propiedad</strong> </a></li>
				        </ul>
	            	</div>
	         	</div>
	        </div>
	    @endforeach
	</div>

	<div>
		<center>{!! $importadores->render() !!}</center>
	</div>

@endsection