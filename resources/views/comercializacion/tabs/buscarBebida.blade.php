@extends('plantillas.main')
@section('title', 'Comercialización')

{!! Html::script('js/productos/cargarClases.js') !!}
{!! Html::script('js/demandaProductos/create.js') !!}

@section('title-header')
   Comercialización
@endsection

@section('title-complement')
   (Bebida)
@endsection

@section('content-left')
   <ul class="nav nav-pills">
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.create') }}"><strong>BUSCAR PRODUCTO</strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('demanda-producto.bebida') }}"><strong>BUSCAR TIPO DE BEBIDA</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.historial') }}"><strong>HISTORIAL</strong></a>
      </li>
   </ul>
   
   @include('comercializacion.modales.solicitarBebida')

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active">
               @if ($cont > 0)
                  @foreach($bebidas as $bebida)
                     <div class="col-md-6 col-xs-12">
                        <div class="box box-widget widget-user-2">
                           <div class="widget-user-header bg-green">
                              <div class="widget-user-image">
                                 <img class="img-rounded" src="{{ asset('imagenes/bebidas/thumbnails/')}}/{{ $bebida->imagen }}">
                              </div>
                              <h3 class="widget-user-username">{{ $bebida->nombre }}</h3>
                           </div>
                           <div class="box-footer no-padding">
                              <ul class="nav nav-stacked">
                                 <li class="active"><a><strong>Características:</strong> {{ $bebida->caracteristicas}}</a></li>
                                 <li class="active"><a><strong>País:</strong> 
                                    @if ($pais_elegido == null)
                                       Cualquier País
                                    @else 
                                       {{$pais_elegido->pais}}
                                    @endif
                                 </a></li>
                                 <li class="active"><center>
                                    @if ($pais_elegido == null)
                                       <a onclick="cargarModalBebida({{$bebida->id}}, '0');" class="btn btn-primary">Solicitar Bebida</a>
                                    @else 
                                       <a onclick="cargarModalBebida({{$bebida->id}}, {{$pais_elegido->id}});" class="btn btn-primary">Solicitar Bebida</a>
                                    @endif
                                 </center></li>
                              </ul>
                           </div> 
                        </div>
                     </div>
                  @endforeach
               @else
                  <strong>No se han encontrado bebidas disponibles para solicitar.</strong>
               @endif		
            </div>
         </div>
      </div>
   </div>
@endsection

@section('paginacion')
   {{ $bebidas->appends(Request::only(['busqueda', 'bebida', 'pais']))->render() }}
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                     @include('comercializacion.tabs.filtroBuscarBebida')
               </div>
            </div>
         </div>
      </div>
@endsection

