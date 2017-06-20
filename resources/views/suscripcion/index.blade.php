@extends('plantillas.main')
@section('title', 'Planes de Suscripción')
@section('content-left')
	<div class="row">
		@foreach($suscripciones as $suscripcion)
			<div class="col-md-12 col-xs-12">
          		<div class="box box-widget widget-user-2">
            		<div class="widget-user-header bg-green">

              			<h3 class="widget-user-username">{{ $suscripcion->suscripcion }}</h3>
           			</div>
            		
            		<div class="box-footer no-padding">
              			<ul class="nav nav-stacked">
              				<li class="active"><a><strong>Descripción: </strong> {{ $suscripcion->descripcion }} </a></li>
                       	 	<li class="active"><a><strong>Precio: </strong> {{ $suscripcion->precio }} $</a></li>
                        	<li class="active"><a href=""><strong><u>Comprar</u></strong></a></li>
                     	</ul>
            		</div>
         		</div>
       		</div>
		@endforeach
	</div>
@endsection