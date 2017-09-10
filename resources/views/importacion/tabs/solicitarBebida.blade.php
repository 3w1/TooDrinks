@extends('plantillas.main')
@section('title', 'Importación')

@section('title-header')
   Solicitud de Importación
@endsection

@section('title-complement')
   (Bebida)
@endsection

@section('content-left')
   <ul class="nav nav-pills">
      <li class="btn btn-default"><a href="{{ route('solicitud-importacion.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('solicitud-importacion.create') }}"><strong>SOLICITAR MARCA</strong></a></li>
      <li class="active btn btn-default"><a href="{{ route('solicitud-importacion.bebida') }}"><strong>SOLICITAR TIPO DE BEBIDA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('solicitud-importacion.historial') }}"><strong>HISTORIAL DE BÚSQUEDAS</strong></a></li>
   </ul>

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
                              <h3 class="widget-user-username">{{ $bebida->nombre }}
                              <a href="{{ route('solicitud-importacion.guardar-solicitud-bebida', $bebida->id) }}" class="btn btn-primary pull-right">Solicitar bebida</a></h3>
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
   {{ $bebidas->appends(Request::only(['busqueda']))->render() }}
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                     @include('importacion.tabs.filtroSolicitarBebida')
               </div>
            </div>
         </div>
      </div>
@endsection

