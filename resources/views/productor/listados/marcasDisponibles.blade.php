@extends('plantillas.main')
@section('title', 'Listado de Marcas')

@section('title-header')
	<span><strong><h3>Marcas sin Propietario</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($marcas as $marca)
			<div class="col-md-6 col-xs-12">

	         	<div class="box box-widget widget-user-2">

	           		<div class="widget-user-header bg-blue">
	              		<div class="widget-user-image">
	                		<img class="img-rounded" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}">
	              		</div>
	           			<h3 class="widget-user-username">{{ $marca->nombre }}</h3>
	           			<h5 class="widget-user-desc"> Sin Propietario </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><stron>País: </stron> {{ $marca->pais->pais }} </a></li>
	             			<li class="active"><a><stron>Provincia: </stron> {{ $marca->provincia_region->provincia }} </a></li>
	              			<li class="active"><a><stron>Descripción: </stron> {{ $marca->descripcion }} </a></li>
				               <li class="active"><a href="{{ route('productor.reclamar-marca', $marca->id) }}" ><strong>Reclamar de mi Propiedad</strong> </a></li>
				        </ul>
	            	</div>
	         	</div>
	        </div>
	    @endforeach
	</div>

	<div>
		<center>{!! $marcas->render() !!}</center>
	</div>

@endsection