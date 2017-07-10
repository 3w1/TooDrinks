@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Marcas')

{!! Html::script('js/adminWeb/buscarProductor.js') !!}

@section('title-header')
   Marcas
@endsection

@section('title-complement')
   (Sin Propietario)
@endsection

@include('adminWeb.modales.asociarProductor')

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
      <?php 
         if ($marca->tipo_creador == 'I'){
            $creador = DB::table('importador')
                        ->select('nombre')
                        ->where('id', '=', $marca->creador_id)
                        ->first();
         }elseif ($marca->tipo_creador == 'D'){
            $creador = DB::table('distribuidor')
                        ->select('nombre')
                        ->where('id', '=', $marca->creador_id)
                        ->first();
         }
      ?>
		<div class="col-md-6 col-xs-12">
         <div class="box box-widget widget-user-2">
           	   
            <div class="widget-user-header bg-green">
           		<div class="widget-user-image">
                	<img class="img-rounded" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}">
              	</div>
              		
               <h3 class="widget-user-username">{{ $marca->nombre }}</h3>
           		<h5 class="widget-user-desc"> {{ $marca->pais->pais }} ({{$marca->provincia_region->provincia}}) </i></h5>
           	</div>
            		
            <div class="box-footer no-padding">
              	<ul class="nav nav-stacked">
                  <li class="active"><a><strong>Nombre SEO: </strong>{{$marca->nombre_seo}} </a></li>
              		<li class="active"><a><strong>Perfil Creador: </strong>
                     @if ($marca->tipo_creador == 'P') 
                        {{ $marca->productor->nombre }}
                     @elseif($marca->tipo_creador == 'AD')
                        AdminWeb
                     @else 
                        {{$creador->nombre}}
                     @endif
                     @if ($marca->tipo_creador == 'P') 
                        (Productor) 
                     @elseif ($marca->tipo_creador == 'I') 
                        (Importador) 
                     @elseif ($marca->tipo_creador == 'D')
                           (Distribuidor)
                     @elseif ($marca->tipo_creador == 'AD')
                        AdminWeb
                     @endif
                  </a></li>
                  <li><center><a href="#" class="btn btn-primary" onclick="cargarModal({{$marca->id}});">Asociar Productor</a></center></li> 
                       
               </ul>
            </div>
         </div>
      </div>
	@endforeach
@endsection

@section('pagination')
   {{$marcas->render()}}
@endsection