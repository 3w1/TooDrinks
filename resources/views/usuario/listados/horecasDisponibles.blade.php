@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Horecas')

@section('title-header')
	<span><strong><h3>Horecas sin Propietario</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($horecas as $horeca)
			<div class="col-md-6 col-xs-12">

	         	<div class="box box-widget widget-user-2">

	           		<div class="widget-user-header bg-blue">
	              		<div class="widget-user-image">
	                		<img class="img-rounded" src="{{ asset('imagenes/horecas/thumbnails/')}}/{{ $horeca->logo }}">
	              		</div>
	           			<h3 class="widget-user-username">{{ $horeca->nombre }}</h3>
	           			<h5 class="widget-user-desc"> Sin Propietario </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><stron>País: </stron> {{ $horeca->pais->pais }} </a></li>
	             			<li class="active"><a><stron>Provincia: </stron> {{ $horeca->provincia_region->provincia }} </a></li>
	              			<li class="active"><a><stron>Descripción: </stron> {{ $horeca->descripcion }} </a></li>
				               <li class="active"><a href="{{ route('usuario.reclamar-horeca', $horeca->id) }}" ><strong>Reclamar de mi Propiedad</strong> </a></li>
				        </ul>
	            	</div>
	         	</div>
	        </div>
	    @endforeach
	</div>

	<div>
		<center>{!! $horecas->render() !!}</center>
	</div>

@endsection