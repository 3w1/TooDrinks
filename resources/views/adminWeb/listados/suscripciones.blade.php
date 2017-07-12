@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Planes de Suscripción')

@section('title-header')
  Suscripciones
@endsection

@section('content-left')
   @section('alertas')
      @if (Session::has('msj-success'))
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
       </div>
      @endif
   @endsection

	@foreach($suscripciones as $suscripcion)
		<div class="col-md-6 col-xs-12">
         <div class="box box-widget widget-user-2">
        		<div class="widget-user-header bg-green">
        			<h3 class="widget-user-username">{{ $suscripcion->suscripcion }}</h3>
           	</div>
            		
            <div class="box-footer no-padding">
        			<ul class="nav nav-stacked">
              		<li class="active"><a><strong>Descripción: </strong> {{ $suscripcion->descripcion }} </a></li>
              	 	<li class="active"><a><strong>Precio: </strong> {{ $suscripcion->precio }} $</a></li>
                  <li class="active"><a href="{{ route('suscripcion.edit', $suscripcion->id) }}"><strong><u>Modificar</u></strong></a></li>
            	</ul>
      		</div>
         </div>
      </div>
	@endforeach
@endsection

@section('pagination')
   {{$suscripciones->render()}}
@endsection