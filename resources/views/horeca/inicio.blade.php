@extends('plantillas.main')
@section('title', 'Inicio')

@section('title-header')
   Dashboard
@endsection

@section('items')
	<div class="col-lg-6 col-xs-6">
      <div class="small-box bg-aqua">
	      <div class="inner">
	         <h3>{{$solicitudesProductos->cant}}</h3><p>Búsquedas de Productos</p>
	      </div>
	      <div class="icon">
	         <i class="fa fa-diamond"></i>
	      </div>
	      <a href="{{ route('demanda-producto.index') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
	   </div>
	</div>

	<div class="col-lg-6 col-xs-6">
      <div class="small-box bg-yellow">
	      <div class="inner">
	         <h3>{{$ofertas->cant}}</h3><p>Ofertas de Interés</p>
	      </div>
         <div class="icon">
	         <i class="fa fa-bullhorn"></i>
	      </div>
	      <a href="{{route('oferta.disponibles')}}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
	   </div>
	</div>

   <div class="col-md-12">
		<div class="box box-danger">
         <div class="box-header with-border">
             <h3 class="box-title">Distibuidores</h3>
         </div>
         <div class="box-body no-padding">
            <ul class="users-list clearfix">
             	<?php $cont=0; ?>
             	@foreach($distribuidores as $distribuidor)
                	<?php $cont++; ?>
	                  <li>
	                 	<img src="{{ asset('imagenes/distribuidores/thumbnails') }}/{{ $distribuidor->logo}}">
	                  	<span class="users-list-name">{{$distribuidor->nombre}} </span>
	                 </li>
	            @endforeach
	            @if ($cont == 0)
	              	<li><center><strong>Actualmente no existen distribuidores en su zona.</strong></center></li>
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
	                    	<td><a href="{{$notificacion->url}}">{{$notificacion->titulo}}</a></td>
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