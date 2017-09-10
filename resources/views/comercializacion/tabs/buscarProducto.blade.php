@extends('plantillas.main')
@section('title', 'Comercialización')

{!! Html::script('js/demandaProductos/create.js') !!}

@section('title-header')
   Comercialización
@endsection

@section('title-complement')
   (Producto)
@endsection

@section('content-left')
   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
         </div>
      @endif
   @endsection  

   @include('comercializacion.modales.solicitarProducto')
   
   <ul class="nav nav-pills">
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.index') }}"><strong>MIS BÚSQUEDAS ACTIVAS</strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('demanda-producto.create') }}"><strong>BUSCAR PRODUCTO</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.bebida') }}"><strong>BUSCAR TIPO DE BEBIDA</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.historial') }}"><strong>HISTORIAL</strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               @if ($cont > 0)
                  @foreach($productos as $producto)
                     <div class="col-md-6 col-xs-12">
                        <div class="box box-widget widget-user-2">
                           <div class="widget-user-header bg-green">
                              <div class="widget-user-image">
                                 <img class="img-rounded" src="{{ asset('imagenes/productos/thumbnails/')}}/{{ $producto->imagen }}">
                              </div>
                              <h3 class="widget-user-username">{{ $producto->nombre }}</h3>
                              <h5 class="widget-user-desc"> {{ $producto->pais->pais }} </i></h5>
                           </div>
                                 
                           <div class="box-footer no-padding">
                              <ul class="nav nav-stacked">
                                 <li class="active"><a><strong>Nombre Seo:</strong> {{ $producto->nombre_seo}}</a></li>
                                 <li class="active"><a><strong>Tipo de Bebida:</strong> {{ $producto->bebida->bebida }} ({{ $producto->clase_bebida->clase}})</a> </li>
                                 <li class="active"><a><strong>Año de Producción:</strong> {{ $producto->ano_produccion}}</a></li>
                                 <li class="active"><a><strong>Marca:</strong> {{ $producto->marca->nombre }}</a></li>
                                 <li class="active"><a>
                                    @if ($producto->confirmado == '0')
                                       <label class="label label-danger">Sin Confirmar</label>
                                    @else
                                       <label class="label label-success">Confirmado</label>
                                    @endif
                                 </a></li>
                                 <li class="active"><center>
                                    <a onclick="cargarModalProducto({{$producto->id}});" class="btn btn-primary">Solicitar Producto</a>
                                 </center></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  @endforeach
               @else
                  <strong>No se han encontrado productos disponibles para su comercialización.</strong>
               @endif
            </div>
         </div>
      </div>
   </div>
@endsection

@section('paginacion')
   {{$productos->appends(Request::only(['busqueda', 'marca']))->render()}}
@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  @include('comercializacion.tabs.filtroBuscarProducto')
               </div>
            </div>
         </div>
      </div>
@endsection
