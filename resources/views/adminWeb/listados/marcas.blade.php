@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Listado de Marcas')

@section('title-header')
   Marcas
@endsection

@section('title-complement')
   (General)
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

   @foreach($marcas as $marca)
      @if ($marca->id != '0')
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
          	<div class="box box-widget widget-user-2">
           	   <div class="widget-user-header bg-green">
               	<div class="widget-user-image">
                	   <img class="img-rounded" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}">
             		</div>
               	<h3 class="widget-user-username">{{ $marca->nombre }}</h3>
                 	<h5 class="widget-user-desc"> {{ $marca->pais->pais }} </i></h5>
           		</div>
            		
            	<div class="box-footer no-padding">
              		<ul class="nav nav-stacked">
                 		<li class="active"><a><strong>Website: </strong> {{ $marca->website }} </a></li>
                     <li class="active"><a href="{{ route('admin.productos-marca', [$marca->id, $marca->nombre]) }}"><strong><u>Catálogo de Productos: </strong> {{ $cont }} Producto(s) </u></a></li>
                     <li class="active"><a href="{{ route('admin.crear-producto-marca', [$marca->id, $marca->nombre] )}}"><strong><u>Agregar Producto</u></strong></a></li>
                     <li class="active"><a href="{{ route('admin.detalle-marca', $marca->id) }}"><strong><u>Ver más detalles</u></strong></a></li>
                     <li class="active"><a>
                        @if ($marca->publicada == '0')
                           <label class="label label-danger">Sin Publicar (Admin)</label>
                        @else
                           <label class="label label-success">Publicada (Admin)</label>
                        @endif
                        @if ($marca->aprobada == '0')
                           <label class="label label-danger">Sin Confirmar (Productor)</label>
                        @else
                           <label class="label label-success">Confirmada (Productor)</label>
                        @endif
                     </a></li> 
                  </ul>
               </div>
         	</div>
       	</div>
      @endif
	@endforeach
@endsection

@section('pagination')
   <center>{{ $marcas->render() }}</center>
@endsection

@section('content-right')
  
   <div class="box box-solid">
       <div class="box-header with-border">
         <h3 class="box-title">Búsqueda Personalizada</h3>

         <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
         </div>
      </div>

      <div class="box-body">
         <div class="input-group input-group-sm">
            <input type="text" name="table_search" class="form-control" placeholder="Buscar Marca">

            <div class="input-group-btn">
               <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
         </div>
      </div>
   </div>

   <div class="box box-solid">
      <div class="box-header with-border">
         <h3 class="box-title">Filtros</h3>

         <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
         </div>
      </div>
      
      <div class="box-body no-padding">
         <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#"><i class="fa fa-inbox"></i> Ver Todas
               <span class="label label-primary pull-right">12</span></a>
            </li>
            <li class="active"><a href="#"><i class="fa fa-envelope-o"></i> Confirmadas</a></li>
            <li class="active"><a href="#"><i class="fa fa-file-text-o"></i> Sin Confirmar</a></li>
            <li class="active"><a href="#"><i class="fa fa-filter"></i> Aprobadas 
               <span class="label label-warning pull-right">65</span></a>
            </li>
            <li class="active"><a href="#"><i class="fa fa-trash-o"></i> Sin Aprobar</a></li>
         </ul>
      </div>
   </div>
@endsection