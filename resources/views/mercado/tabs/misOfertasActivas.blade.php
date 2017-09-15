@extends('plantillas.main')
@section('title', 'Mis Ofertas')

@section('title-header')
   Mis Ofertas
@endsection

@section('title-complement')
   (Activas)
@endsection

@section('content-left')
   <?php 
      if (session('perfilTipo') == 'I'){
         $not_od = DB::table('notificacion_i')->select('id')
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'NO')->where('leida', '=', '0')->get();

         $od=0;
         foreach($not_od as $nod){
            $od++;
         }
      }elseif (session('perfilTipo') == 'D'){
         $not_od = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'NO')->where('leida', '=', '0')->get();
          $od=0;
         foreach($not_od as $nod){
            $od++;
         }
      }
   ?>
   
   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
         </div>
      @endif
   @endsection  
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default"><a href="{{ route('oferta.index') }}"><strong>MIS OFERTAS ACTIVAS</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('oferta.create') }}"><strong>NUEVA OFERTA</strong></a></li>
      @if (session('perfilTipo') != 'P')
         <li class="btn btn-default">
            <a href="{{ route('oferta.disponibles') }}"><strong>OFERTAS DISPONIBLES | 
            <small class="label bg-red">{{ $od }}</small></strong></a>
         </li>
      @endif
      <li class="btn btn-default"><a href="{{ route('oferta.historial')}}"><strong>HISTORIAL DE OFERTAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
               @if ($cont > 0 )
                  @foreach($ofertas as $oferta)
                     <div class="col-md-4 col-xs-6">
                        <div class="thumbnail">
                           <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $oferta->producto->imagen }}" >
                           <div class="caption">
                              <h3>{{ $oferta->titulo }}</h3>
                              <ul class="nav nav-stacked">
                                 <li><a><strong>Producto:</strong> {{ $oferta->producto->nombre }}</a></li>
                                 <li><a><strong>Precio Unitario: </strong> {{ $oferta->precio_unitario }} $</a></li>
                                 <li><a><strong>Envío Disponible: </strong> @if ( $oferta->envio == '1') Si  @else No @endif </a></li>
                              </ul>
                              <p><center>
                                 <a href="{{ route('oferta.detalles', [$oferta->id, $oferta->titulo]) }}" class="btn btn-primary pull" role="button">Ver Más</a>
                              </center></p>
                           </div>
                        </div>
                     </div>
                  @endforeach
               @else 
                  <strong>Actualmente no posee ofertas activas.</strong>
               @endif
               </div>
            </div>
         </div>
      </div>
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  @include('mercado.tabs.filtroMisOfertasActivas')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$ofertas->appends(Request::only(['busqueda', 'producto']))->render()}}
@endsection

