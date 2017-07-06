@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Marcas')

{!! Html::script('js/adminWeb/descripcionMarca.js') !!}

@section('items')
  @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
      </div>
   @endif
   <span><strong><h3><center>Marcas Sin Aprobar</center></h3></strong></span><hr>
@endsection

@include('adminWeb.modales.descripcionMarca')

@section('content-left')
	<div class="row">
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
			<div class="col-md-4 col-xs-12">
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
                        @else 
                           {{$creador->nombre}}
                        @endif
                        @if ($marca->tipo_creador == 'P') 
                           (Productor) 
                        @elseif ($marca->tipo_creador == 'I') 
                           (Importador) 
                        @elseif ($marca->tipo_creador == 'D')
                           (Distribuidor)
                        @endif
                     </a></li>
                     <li class="active"><a><strong>Productor Propietario: </strong> 
                        @if ($marca->productor_id == '0')
                           Sin Productor Asociado.
                        @else
                           {{ $marca->productor->nombre }} 
                        @endif               
                     </a></li>
                     <li class="active"><a href="#" onclick="cargarDescripcion({{$marca->id}});"><strong><u>Ver descripción</u></strong></a></li>
                     <li><center><a href="{{ route( 'admin.aprobar-marca', $marca->id) }}" class="btn btn-primary">Aprobar</a> <a href="#" class="btn btn-danger">Eliminar</a></center></li> 
                       
                  </ul>
            	</div>
         	</div>
       	</div>
		@endforeach
	</div>
	
   <div>
		{{ $marcas->render() }}
	</div>
@endsection