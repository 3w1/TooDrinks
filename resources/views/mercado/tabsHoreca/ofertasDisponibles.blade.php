@extends('plantillas.main')
@section('title', 'Ofertas')

@section('title-header')
   Ofertas
@endsection

@section('title-complement')
   (Disponibles)
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
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default"><a href="{{ route('oferta.disponibles') }}"><strong>OFERTAS DISPONIBLES</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
               @if ($cont > 0 )
                  @foreach($ofertas as $oferta) 
                     <?php 
                        $relacion = DB::table('horeca_oferta')
                                 ->select('id')
                                 ->where('oferta_id', '=', $oferta->id)
                                 ->where('horeca_id', '=', session('perfilId'))
                                 ->first();        
                     ?>
                     @if ($relacion == null)
                        <div class="col-md-4 col-xs-6">
                           <div class="thumbnail">
                              <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $oferta->producto->imagen }}" >
                              <div class="caption">
                                 <h3>{{ $oferta->titulo }}</h3>
                                 <p>{{ $oferta->descripcion }}</p>
                                 <ul class="nav nav-stacked">
                                    <li><a><strong>Producto:</strong> {{ $oferta->producto->nombre }}</a></li>
                                 </ul>
                                 <p><center>
                                    {!! Form::open(['route' => 'oferta.ver-detalles', 'method' => 'GET'])!!}
                                       {!! Form::hidden('oferta_id', $oferta->id)!!}
                                       {!! Form::submit('Ver Detalles', ['class' => 'btn btn-primary'])!!}
                                    {!! Form::close() !!}
                                 </center></p>
                              </div>
                           </div>
                        </div>
                     @endif
                  @endforeach
               @else 
                  <strong>Actualmente no existen ofertas disponibles.</strong>
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
                  
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$ofertas->appends(Request::only(['busqueda', 'producto']))->render()}}
@endsection

