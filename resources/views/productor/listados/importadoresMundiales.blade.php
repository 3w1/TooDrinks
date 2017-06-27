@extends('plantillas.main')
@section('title', 'Listado de Importadores')

@section('title-header')
	<span><strong><h3>Importadores Mundiales</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@if ($check == '1')
			@foreach($importadores as $importador)
				<div class="col-md-6 col-xs-12">

		         	<div class="box box-widget widget-user-2">

		           		<div class="widget-user-header bg-blue">
		              		<div class="widget-user-image">
		                		<img class="img-rounded" src="{{ asset('imagenes/importadores/thumbnails/')}}/{{ $importador->logo }}">
		              		</div>
		           			<h3 class="widget-user-username">{{ $importador->nombre }}</h3>
		           			<h5 class="widget-user-desc"> {{ $importador->persona_contacto }} </i></h5>
		       			</div>
		            		
		            	<div class="box-footer no-padding">
		              		<ul class="nav nav-stacked">
		             			<li class="active"><a><strong>País: </strong> {{ $importador->pais->pais }} </a></li>
		             			<li class="active"><a><strong>Provincia: </strong> {{ $importador->provincia_region->provincia }} </a></li>
					            <li class="active"><a class="btn btn-primary" href="{{ route('importador.show', $importador->id) }}" ><strong>¡¡Contactar!!</strong><i class="fa fa-check"></i> </a></li>
					        </ul>
		            	</div>
		         	</div>
		        </div>
		    @endforeach
		@else 
			<div class="alert alert-danger">
	            <strong>¡Ups!</strong> No puede acceder a la lista de importadores mundiales sin suscripción. Pague una suscripción para disfrutar de esta opción. <a href="{{ route('suscripcion.index') }}">Ver planes de Suscripción</a>
	        </div>
		@endif
	</div>

	<div>
		<center>{!! $importadores->render() !!}</center>
	</div>

@endsection