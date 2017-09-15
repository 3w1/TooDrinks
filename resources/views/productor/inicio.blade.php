@extends('plantillas.main')
@section('title', 'Inicio')

@section('title-header')
   Dashboard
@endsection

@section('items')
		<div class="col-lg-3 col-xs-6">
	      <div class="small-box bg-aqua">
	         <div class="inner">
	            <h3>{{$marcas->cant}}</h3><p>Marcas</p>
	         </div>
	         <div class="icon">
	           	<i class="fa fa-diamond"></i>
	         </div>
	         <a href="{{ route('marca.index') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
	      </div>
	   </div>

	   <div class="col-lg-3 col-xs-6">
	      <div class="small-box bg-green">
	         <div class="inner">
	            <h3>{{$productos->cant}}</h3><p>Productos</p>
	         </div>
	         <div class="icon">
	            <i class="fa fa-product-hunt"></i>
	         </div>
	         <a href="{{route('producto.index')}}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
	      </div>
	   </div>

	   <div class="col-lg-3 col-xs-6">
	      <div class="small-box bg-yellow">
	         <div class="inner">
	            <h3>{{$ofertas->cant}}</h3><p>Ofertas Realizadas</p>
	         </div>
	         <div class="icon">
	            <i class="fa fa-bullhorn"></i>
	         </div>
	         <a href="{{route('oferta.index')}}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
	      </div>
	   </div>

	   <div class="col-lg-3 col-xs-6">
	      <div class="small-box bg-red">
	         <div class="inner">
	            <h3>{{$banners->cant}}</h3><p>Publicidades</p>
	         </div>
	         <div class="icon">
	            <i class="fa fa-flag"></i>
	         </div>
	         <a href="{{route('banner-publicitario.index')}}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
	      </div>
	   </div>

   	<div class="col-md-12">
   		<div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Mis Contactos Recientes</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                	<?php $cont=0; ?>
                	@foreach($importadores as $importador)
                		<?php $cont++; ?>
	                    <li>
	                    	<img src="{{ asset('imagenes/importadores/thumbnails') }}/{{ $importador->logo}}">
	                      	<span class="users-list-name">{{$importador->nombre}} ({{$importador->pais->pais}})</span>
	                      	<span class="users-list-date">Desde {{ date('d-m-Y', strtotime($importador->created_at)) }}</span>
	                    </li>
	                @endforeach
	                @foreach($distribuidores as $distribuidor)
	                	<?php $cont++; ?>
	                    <li>
	                    	<img src="{{ asset('imagenes/distribuidores/thumbnails') }}/{{ $distribuidor->logo}}">
	                      	<span class="users-list-name" >{{$distribuidor->nombre}} ({{$distribuidor->provincia_region->provincia}})</span>
	                      	<span class="users-list-date">Desde {{ date('d-m-Y', strtotime($distribuidor->created_at)) }}</span>
	                    </li>
	                @endforeach
	                @if ($cont == 0)
	                	<li><center><strong>No posee ningún contacto reciente.</strong></center></li>
	                @endif
                </ul>
            </div>
        </div>
   </div>
@endsection

@section('content-left')
	<div class="box box-info">
      <div class="box-header with-border">
         <h3 class="box-title">Notificaciones Recientes</h3>
      </div>
      <div class="box-body">
         <div class="table-responsive">
            <table class="table no-margin">

               <tbody>
               	<?php $cont = 0; ?>
               	@foreach ($notificaciones as $notificacion)
               		<?php $cont++; ?>
	                  <tr>
	                  	<td><strong>{{$cont}}</strong></td>
	                    	<td><a href="{{ url($notificacion->url) }}">{{$notificacion->titulo}}</a></td>
	                    	<td>{{ date('d-m-Y', strtotime($notificacion->fecha)) }}</td>
	                    	@if ($notificacion->leida == '0')
	                    		<td><span class="label label-danger">Sin Leer</span></td>
	                    	@else 
	                    		<td><span class="label label-success">Leída</span></td>
	                    	@endif
	                    	<td></td>
	                  </tr>
	               @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <div class="box-footer clearfix">
         <a href="{{route('notificacion.index')}}" class="btn btn-sm btn-default btn-flat pull-right">Ver Todas</a>
      </div>
	</div>
@endsection

@section('content-right')
	<div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-shopping-bag"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Solicitudes de Productos</span>
            <span class="info-box-number">{{$solicitudesProductos->cant}}</span>

            <div class="progress">
      	       <div class="progress-bar" style="width: 50%"></div>
            </div>
            <span class="progress-description">
                50% Incremento en 2 Días
            </span>
        </div>
    </div>

    <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-diamond"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Importación de Marcas</span>
            <span class="info-box-number">{{$solicitudesImportacion->cant}}</span>

            <div class="progress">
      	       <div class="progress-bar" style="width: 20%"></div>
            </div>
            <span class="progress-description">
                20% de incremento en 30 Días
            </span>
        </div>
    </div>

    <div class="info-box bg-orange">
        <span class="info-box-icon"><i class="fa fa-diamond"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Distribución de Marcas</span>
            <span class="info-box-number">{{$solicitudesDistribucion->cant}}</span>

            <div class="progress">
      	       <div class="progress-bar" style="width: 70%"></div>
            </div>
            <span class="progress-description">
                70% de incremento en 30 Días
            </span>
        </div>
    </div>

    <div class="info-box bg-red">
        <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Contactos por Ofertas</span>
            <span class="info-box-number">{{$contactos}}</span>

            <div class="progress">
      	       <div class="progress-bar" style="width: 55%"></div>
            </div>
            <span class="progress-description">
                55% de incremento en 30 Días
            </span>
        </div>
    </div>
@endsection