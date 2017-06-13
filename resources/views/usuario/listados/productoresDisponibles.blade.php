@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Productores')

@section('title-header')
	<span><strong><h3>Productores sin Propietario</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($productores as $productor)
			@if ($productor->id != '0')
				<div class="col-md-6 col-xs-12">
	          		<!-- Widget: user widget style 1 -->
	          		<div class="box box-widget widget-user-2">
	           			<!-- Add the bg color to the header using any of the bg-* classes -->
	            		<div class="widget-user-header bg-blue">
	              			<div class="widget-user-image">
	                			<img class="img-rounded" src="{{ asset('imagenes/productores/thumbnails/')}}/{{ $productor->logo }}">
	              			</div>
	              			<!-- /.widget-user-image -->
	              			<h3 class="widget-user-username">{{ $productor->nombre }}</h3>
	              			<h5 class="widget-user-desc"> Sin Propietario </i></h5>
	           			</div>
	            		
	            		<div class="box-footer no-padding">
	              			<ul class="nav nav-stacked">
	              				<li class="active"><a><stron>País: </stron> {{ $productor->pais->pais }} </a></li>
	              				<li class="active"><a><stron>Provincia: </stron> {{ $productor->provincia_region->provincia }} </a></li>
	              				<li class="active"><a><stron>Descripción: </stron> {{ $productor->descripcion }} </a></li>
				                <li class="active"><a href="{{ route('usuario.reclamar-productor', $productor->id) }}" ><strong>Reclamar de mi Propiedad</strong> </a></li>
				            </ul>
	            		</div>
	         		</div>
	          		<!-- /.widget-user -->
	       		</div>
	       	@endif
		@endforeach

	</div>

	<div>
		<center>{!! $productores->render() !!}</center>
	</div>

@endsection