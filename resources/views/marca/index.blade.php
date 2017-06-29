@extends('plantillas.main')
@section('title', 'Listado de Marcas')

@section('items')
  @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
  @endif
	<span><strong><h3>Mis Marcas</h3></strong></span>
@endsection

@section('content-left')
	<div class="row">
		@foreach($marcas as $marca)
         @if ($marca->id != '0')
			<?php
            $productos = DB::table('producto')
                           ->select('id', 'confirmado')
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
              			  <li class="active"><a><strong>Website: </strong> {{ $marca->website }} </a></li>
                        <li class="active"><a href="{{ route('producto.listado', [$marca->id, $marca->nombre]) }}"><strong><u>Catálogo de Productos: </strong> {{ $cont }} Producto(s) </u></a></li>
                        <li class="active"><a href="{{ route('producto.agregar', [$marca->id, $marca->nombre]) }}"><strong><u>Agregar Producto</u></strong></a></li>
                        <li class="active"><a href="{{ route('marca.show', $marca->id) }}"><strong><u>Ver más detalles</u></strong></a></li>
                        <li class="active"><a>
                           @if (session('perfilTipo') == 'P')
                              @if ($marca->publicada == '0')
                                 <label class="label label-danger">Sin Publicar</label></a></li>
                              @else
                                 <label class="label label-success">Publicada</label></a></li>
                              @endif
                           @else 
                              @if ($marca->publicada == '0')
                                 <label class="label label-danger">Sin Publicar</label>
                              @else
                                 <label class="label label-success">Publicada</label>
                              @endif

                              @if ($marca->aprobada == '0')
                                 <label class="label label-danger">Sin Confirmar</label></a></li>
                              @else
                                 <label class="label label-success">Confirmada</label></a></li>
                              @endif
                           @endif
                     </ul>
            		</div>
         		</div>
       		</div>
            @endif
		@endforeach
	</div>
	<div>
		{{ $marcas->render() }}
	</div>

@endsection