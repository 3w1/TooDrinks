@extends('plantillas.main')
@section('title', 'Importación')

{!! Html::script('js/demandaProductos/cambiarStatus.js') !!}

@section('title-header')
   Mis Solicitudes de Distribución
@endsection

@section('content-left')
   <ul class="nav nav-pills">
      <li class="active btn btn-default"><a href="{{ route('solicitud-distribucion.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a></li>
   	<li class="btn btn-default"><a href="{{ route('solicitud-distribucion.create') }}"><strong>SOLICITAR MARCA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('solicitud-distribucion.bebida') }}"><strong>SOLICITAR TIPO DE BEBIDA</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('solicitud-distribucion.historial') }}"><strong>HISTORIAL DE BÚSQUEDAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active">
               <div class="box">
                  <div class="box-body table-responsive no-padding table-bordered">
                     <table class="table table-hover">
                        <thead>
                           <th><center>Fecha de Solicitud</center></th>
                           <th><center>Marca / Bebida</center></th>
                           <th ><center>Visitas / Contactos</center></th>
                           <th><center>Status</center></th>
                        </thead>
                        <tbody>
                           @if ($cont > 0)
                              @foreach ($solicitudesDistribucion as $solicitudDistribucion) 
                                 <tr>
                                    <td><center>{{ date('d-m-Y', strtotime($solicitudDistribucion->fecha)) }}</td>
                                    <td><center>
                                       @if ($solicitudDistribucion->marca_id != null)
                                          (M) {{ $solicitudDistribucion->marca->nombre }} 
                                       @else
                                          (B) {{ $solicitudDistribucion->bebida->nombre }} 
                                          @if ($solicitudDistribucion->pais_id == null)
                                             [Cualquier País]
                                          @else 
                                             [{{ $solicitudDistribucion->pais->pais}}]
                                          @endif
                                       @endif
                                    </center></td>
                                    <td><center>
                                       <label class="label label-warning">{{$solicitudDistribucion->cantidad_visitas}}</label> /
                                       <label class="label label-success">{{$solicitudDistribucion->cantidad_contactos}}</label>
                                    </center></td>
                                    <td><center>
                                       <div class="btn-group btn-toggle"> 
                                          <button class="btn btn-primary btn-xs active" id="on-{{$solicitudDistribucion->id}}" onclick="cambiar(this.id);">Visible</button>
                                          <button class="btn btn-default btn-xs" id="off-{{$solicitudDistribucion->id}}" onclick="cambiar(this.id);">No Visible</button>
                                       </div>
                                    </center></td>
                                 </tr>
                              @endforeach
                             {!! Form::open(['route' => 'solicitud-distribucion.status', 'method' => 'POST', 'id' => 'formStatus' ]) !!}
                                 {!! Form::hidden('id', null, ['id' => 'id']) !!}
                                 {!! Form::hidden('status', null, ['id' => 'status'] ) !!}
                              {!! Form::close() !!}
                           @else
                              <tr>
                                 <td colspan="4"><strong>Actualmente no posee solicitudes de distribucion de marcas o bebidas activas.</strong></td>
                              </tr>
                           @endif
                        </tbody>
                     </table>
                  </div>      
               </div>   
            </div>
         </div>
      </div>
   </div>
@endsection

@section('paginacion')
   {{ $solicitudesDistribucion->appends(Request::only(['tipo']))->render() }}
@endsection

@section('content-right')
   <div class="panel with-nav-tabs panel-default">
      <div class="panel-heading">
         <h5><b><center>Filtros de Búsqueda</center></b></h5>
      </div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               @include('distribucion.tabsDistribuidor.filtroBusquedasActivas')
            </div>
         </div>
      </div>
   </div>
@endsection



