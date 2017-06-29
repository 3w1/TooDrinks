@extends('plantillas.main')
@section('title', 'Listado de Marcas')

@section('title-header')
	<span><strong><h3>Marcas Disponibles</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($marcas as $marca)
		@if ($marca->id != '0')
			<?php 
				$productor = DB::table('productor')
								->select('nombre')
								->where('id', '=', $marca->productor_id)
								->get()
								->first();

				$pais = DB::table('pais')
								->select('pais')
								->where('id', '=', $marca->pais_id)
								->get()
								->first();

				$provincia = DB::table('provincia_region')
								->select('provincia')
								->where('id', '=', $marca->provincia_region_id)
								->get()
								->first();
			 ?>
			<div class="col-md-6 col-xs-12">

	         	<div class="box box-widget widget-user-2">

	           		<div class="widget-user-header bg-green">
	              		<div class="widget-user-image">
	                		<img class="img-rounded" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}">
	              		</div>
	           			<h3 class="widget-user-username">{{ $marca->nombre }}</h3>
	           			<h5 class="widget-user-desc"> {{ $productor->nombre }} </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><stron>País: </stron> {{ $pais->pais }} </a></li>
	             			<li class="active"><a><stron>Provincia: </stron> {{ $provincia->provincia }} </a></li>
	              			<li class="active"><a><stron>Descripción: </stron> {{ $marca->descripcion }} </a></li>
				            <li>
				            @if ($accion == 'Asociar')
				            	<center>
				               		 <a class="btn btn-success" href="{{ route('importador.asociar-marca', $marca->id) }}" ><strong>¡¡La Importo!!</strong><i class="fa fa-check"></i> </a>
				               	</center>
				            @elseif ($accion == 'Solicitar')
				            	<center>
				               		 <a class="btn btn-success" href="{{ route('importador.solicitar-importacion', $marca->id) }}" ><strong>¡¡Solicitar Importación!!</strong><i class="fa fa-check"></i> </a>
				               	</center>
				            @endif
				            </li>  
				        </ul>
	            	</div>
	         	</div>
	        </div>
	        @endif
	    @endforeach
	</div>

	<div>
		<center>{!! $marcas->render() !!}</center>
	</div>

@endsection