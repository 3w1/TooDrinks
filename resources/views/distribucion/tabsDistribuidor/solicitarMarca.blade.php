@extends('plantillas.main')
@section('title', 'Importación')

@section('title-header')
   Solicitud de Distribución
@endsection

@section('title-complement')
   (Marca)
@endsection

@section('content-left')
   <ul class="nav nav-pills">
      <li class="btn btn-default"><a href="{{ route('solicitud-distribucion.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a></li>
      <li class="active btn btn-default"><a href="{{ route('solicitud-distribucion.create') }}"><strong>SOLICITAR MARCA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('solicitud-distribucion.bebida') }}"><strong>SOLICITAR TIPO DE BEBIDA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('solicitud-distribucion.historial') }}"><strong>HISTORIAL DE BÚSQUEDAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active">
               @if ($cont > 0)
                  @foreach($marcas as $marca)
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
                                 <li class="active"><a href="{{$marca->website}}" target="_blank"><strong>Website:</strong> {{ $marca->website }}</a> </li>
                                 <li class="active"><a>
                                    @if ($marca->reclamada == '0')
                                       <label class="label label-danger">Sin Reclamar</label>
                                    @else
                                       <label class="label label-success">Reclamada</label>
                                    @endif
                                 </a></li>
                                 <li class="active"><center>
                                    {!! Form::open(['route' => 'solicitud-distribucion.store', 'method' => 'POST']) !!}
                                       {!! Form::hidden('distribuidor_id', session('perfilId') ) !!}
                                       {!! Form::hidden('marca_id', $marca->id) !!}
                                       {!! Form::hidden('pais_id', $marca->pais_id ) !!}
                                       {!! Form::hidden('status', '1') !!}
                                       {!! Form::hidden('cantidad_visitas', '0') !!}
                                       {!! Form::hidden('cantidad_contactos', '0') !!}
                                       {!! Form::submit("Solicitar Marca", ['class' => 'btn btn-primary'])!!}
                                    {!! Form::close() !!}
                                 </center></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  @endforeach
               @else
                  <strong>No se han encontrado marcas disponibles para solicitar.</strong>
               @endif		
            </div>
         </div>
      </div>
   </div>
@endsection

@section('paginacion')
   {{ $marcas->appends(Request::only(['busqueda']))->render() }}
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                     @include('distribucion.tabsDistribuidor.filtroSolicitarMarca')
               </div>
            </div>
         </div>
      </div>
@endsection

