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
            DB::table('notificacion_i')->where('id', '=', $nod->id)->update(['leida' => '1']);
         }
      }elseif (session('perfilTipo') == 'D'){
         $not_od = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'NO')->where('leida', '=', '0')->get();
          $od=0;
         foreach($not_od as $nod){
            $od++;
            DB::table('notificacion_d')->where('id', '=', $nod->id)->update(['leida' => '1']);
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
      <li class="btn btn-default"><a href="{{ route('oferta.index') }}"><strong>MIS OFERTAS ACTIVAS</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('oferta.create') }}"><strong>NUEVA OFERTA</strong></a></li>
      @if (session('perfilTipo') != 'P')
         <li class="active btn btn-default">
            <a href="{{ route('oferta.disponibles') }}"><strong>OFERTAS DISPONIBLES | 
            <small class="label bg-orange">{{ $od }}</small></strong></a>
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
                     <?php 
                        if (session('perfilTipo') == 'I'){
                           $relacion = DB::table('importador_oferta')
                                    ->select('id')
                                    ->where('oferta_id', '=', $oferta->id)
                                    ->where('importador_id', '=', session('perfilId'))
                                    ->first();
                        }elseif (session('perfilTipo')== 'D'){
                           $relacion = DB::table('distribuidor_oferta')
                                    ->select('id')
                                    ->where('oferta_id', '=', $oferta->id)
                                    ->where('distribuidor_id', '=', session('perfilId'))
                                    ->first();
                        }   

                        $ofertaD = App\Models\Oferta::find($oferta->id);      
                     ?>
                     @if ($relacion == null)
                        <div class="col-md-4 col-xs-6">
                           <div class="thumbnail">
                              <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $ofertaD->producto->imagen }}" >
                              <div class="caption">
                                 <h3>{{ $ofertaD->titulo }}</h3>
                                 <p>{{ $ofertaD->descripcion }}</p>
                                 <ul class="nav nav-stacked">
                                    <li><a><strong>Producto:</strong> {{ $ofertaD->producto->nombre }}</a></li>
                                 </ul>
                                 <p><center>
                                    {!! Form::open(['route' => 'oferta.ver-detalles', 'method' => 'GET'])!!}
                                       {!! Form::hidden('oferta_id', $ofertaD->id)!!}
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
                  @include('mercado.tabs.filtroOfertasDisponibles')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$ofertas->appends(Request::only(['busqueda', 'producto']))->render()}}
@endsection

