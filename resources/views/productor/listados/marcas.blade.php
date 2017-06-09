@extends('plantillas.productor.mainProductor')
@section('title', 'Listado de Marcas')

@section('items')
	<span><strong><h3>Mis Marcas</h3></strong></span>
@endsection

@section('content-left')
	<div class="row">
		@foreach($marcas as $marca)
			<?php
            $productos = DB::table('producto')
                           ->select('id')
                           ->where('marca_id', $marca->id)
                           ->get();

            $cont = 0;
            foreach ($productos as $producto)
               $cont++;
			 ?>
			<div class="col-md-6 col-xs-12">
          		<!-- Widget: user widget style 1 -->
          		<div class="box box-widget widget-user-2">
           			<!-- Add the bg color to the header using any of the bg-* classes -->
            		<div class="widget-user-header bg-green">
              			<div class="widget-user-image">
                			<img class="img-rounded" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}">
              			</div>
              			<!-- /.widget-user-image -->
              			<h3 class="widget-user-username">{{ $marca->nombre }}</h3>
              			<h5 class="widget-user-desc"> {{ $marca->pais->pais }} </i></h5>
           			</div>
            		
            		<div class="box-footer no-padding">
              			<ul class="nav nav-stacked">
              				<li class="active"><a><strong>Descripción: </strong> {{ $marca->descripcion }} </a></li>
              				<li class="active"><a><strong>Website: </strong> {{ $marca->website }} </a></li>
                        <li class="active"><a href="{{ route('productor.productos', [$marca->id, $marca->nombre]) }}"><strong><u>Catálogo de Productos: </strong> {{ $cont }} Producto(s) </u></a></li>
                        <li class="active"><a href="{{ route('productor.registrar-producto', [$marca->id, $marca->nombre]) }}"><strong><u>Agregar Producto</u></strong></a></li>
                        <li class="active"><a href="{{ route('productor.marca', [$marca->id, $marca->nombre]) }}"><strong><u>Ver más detalles</u></strong></a></li>
                     </ul>
            		</div>
         		</div>
          		<!-- /.widget-user -->
       		</div>
		@endforeach

	</div>
	<div>
		{{ $marcas->render() }}
	</div>

@endsection