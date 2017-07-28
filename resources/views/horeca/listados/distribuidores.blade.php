@extends('plantillas.main')
@section('title', 'Distribuidores Locales')

@section('items')
  @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
  @endif
	<span><strong><h3>Distribuidores Locales</h3></strong></span>
@endsection

@section('content-left')
	<div class="row">
		@foreach($distribuidores as $distribuidor)
			<div class="col-md-6 col-xs-12">
          	<div class="box box-widget widget-user-2">
           		<div class="widget-user-header bg-green">
              		<div class="widget-user-image">
                		<img class="img-rounded" src="{{ asset('imagenes/distribuidores/thumbnails/')}}/{{ $distribuidor->logo }}">
              		</div>
              		<h3 class="widget-user-username">{{ $distribuidor->nombre }}</h3>
              		<h5 class="widget-user-desc"> {{ $distribuidor->provincia_region->provincia }} </i></h5>
           		</div>
            		
         		<div class="box-footer no-padding">
              		<ul class="nav nav-stacked">
              		  <li class="active"><a><strong>Teléfono:</strong> {{ $distribuidor->telefono }} </a></li>
                     <li class="active"><a><strong>Email:</strong> {{$distribuidor->email}}</a></li>
                     <li class="active"><a><strong>Contacto:</strong> {{$distribuidor->persona_contacto}}</a></li>
                     <li class="active">
                        <p><center>
                           <a href="{{ route('distribuidor.show', $distribuidor->id) }}" class="btn btn-primary">Más Detalles</a>
                        </center></p>
                     </li>
                  </ul>
            	</div>
         	</div>
       	</div>
      @endforeach
	</div>

	<div>
		{{ $distribuidores->render() }}
	</div>

@endsection