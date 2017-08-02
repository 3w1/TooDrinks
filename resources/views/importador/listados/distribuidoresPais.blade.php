@extends('plantillas.main')
@section('title', 'Listado de Importadores')

@section('title-header')
	Distribuidores
@endsection

@section('title-complement')
	(Nacionales)
@endsection

@section('content-left')

		@foreach($distribuidores as $distribuidor)
			<div class="col-md-6 col-xs-12">

	         	<div class="box box-widget widget-user-2">

	           		<div class="widget-user-header bg-blue">
	              		<div class="widget-user-image">
	                		<img class="img-rounded" src="{{ asset('imagenes/distribuidores/thumbnails/')}}/{{ $distribuidor->logo }}">
	              		</div>
	           			<h3 class="widget-user-username">{{ $distribuidor->nombre }}</h3>
	           			<h5 class="widget-user-desc"> {{ $distribuidor->persona_contacto }} </i></h5>
	       			</div>
	            		
	            	<div class="box-footer no-padding">
	              		<ul class="nav nav-stacked">
	             			<li class="active"><a><strong>País: </strong> {{ $distribuidor->pais->pais }} </a></li>
	             			<li class="active"><a><strong>Provincia: </strong> {{ $distribuidor->provincia_region->provincia }} </a></li>
				            <li class="active"><a class="btn btn-primary" href="" ><strong>¡¡Contactar!!</strong><i class="fa fa-check"></i> </a></li>
				        </ul>
	            	</div>
	         	</div>
	        </div>
	    @endforeach
@endsection

@section('pagination')
	{{$distribuidores->render()}}
@endsection

@section('content-right')
    <div class="box box-solid box-success">
      <div class="box-header with-border">
         <h3 class="box-title">Filtros</h3>

         <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
         </div>
      </div>
      
      <div class="box-body no-padding">
         <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="{{ route('producto.mis-productos', 'todos') }}"><i class="fa fa-inbox"></i> Ver Todos
               <span class="label label-primary pull-right"></span></a>
            </li>
            <li class="active"><a href="{{route('producto.mis-productos', 'confirmados')}}">
               <i class="fa fa-envelope-o"></i> Registrados
               <span class="label label-success pull-right"></span>
            </a></li>
            <li class="active"><a href="{{route('producto.mis-productos', 'no-confirmados')}}">
               <i class="fa fa-file-text-o"></i> Sin Registrar
               <span class="label label-danger pull-right"></span>
            </a></li>
         </ul>
      </div>
   </div>

@endsection