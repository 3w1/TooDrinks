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
	                    	<td>{{$notificacion->fecha}}</td>
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
	<div class="box box-primary">
      <div class="box-header with-border">
         <h3 class="box-title">Gastos Recientes</h3>
      </div>
      <div class="product-img">
         <img src="dist/img/default-50x50.gif" alt="Product Image">
      </div>
      <div class="box-body">
         <ul class="products-list product-list-in-box">
         	@foreach ($gastos as $gasto)
	            <li class="item">
	               <div class="product-info">
	                  <a href="javascript:void(0)" class="product-title">{{$gasto->tipo_deduccion}}
	         	         <span class="label label-warning pull-right">{{$gasto->cantidad_creditos}}</span>
	         	      </a>
	                  <span class="product-description">
	                     {{$gasto->descripcion}}
	                  </span>
	               </div>
	           </li>
	         @endforeach
         </ul>
      </div>
      <div class="box-footer text-center">
         <a href="javascript:void(0)" class="uppercase">Ver Todos</a>
      </div>
   </div>
@endsection