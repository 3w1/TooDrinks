@extends('plantillas.main')
@section('title', 'Planes de Suscripción')

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3><center>Suscripciones</center></h3></strong></span>
@endsection

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

  <div>
    <center>{{ $suscripciones->render() }}</center>
  </div>
@endsection