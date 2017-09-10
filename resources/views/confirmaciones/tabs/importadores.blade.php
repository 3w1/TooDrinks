@extends('plantillas.main')
@section('title', 'Confirmaciones')

{!! Html::script('js/importadores/datos.js') !!}

@section('title-header')
   Confirmaciones
@endsection

@section('title-complement')
   (Importadores)
@endsection

@section('content-left')
   <?php 
      $not_ai = DB::table('notificacion_p')->select('id')
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'AI')->where('leida', '=', '0')->get();
      $ai=0;
      foreach($not_ai as $nai){
         $ai++;
         DB::table('notificacion_p')->where('id', '=', $nai->id)->update(['leida' => '1']);
      }

      $not_ad = DB::table('notificacion_p')->select('id')
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'AD')->where('leida', '=', '0')->get();
      $ad=0;
      foreach($not_ad as $nad){
         $ad++;
      }

      $not_np = DB::table('notificacion_p')->select('id')
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'NP')->where('leida', '=', '0')->get();
      $np=0;
      foreach($not_np as $nnp){
         $np++;
      }

      $not_nm = DB::table('notificacion_p')->select('id')
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'NM')->where('leida', '=', '0')->get();
      $nm=0;
      foreach($not_nm as $nnm){
         $nm++;
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

   @include('confirmaciones.modales.datosImportador')
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default">
         <a href="{{ route('productor.confirmar-importadores') }}"><strong>IMPORTADORES | 
         <small class="label bg-orange">{{ $ai }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('productor.confirmar-distribuidores') }}"><strong>DISTRIBUIDORES | <small class="label bg-red">{{ $ad }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('productor.confirmar-productos') }}"><strong>PRODUCTOS| <small class="label bg-red">{{ $np }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('productor.confirmar-marcas') }}"><strong>MARCAS | <small class="label bg-red">{{ $nm }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($solicitudes as $solicitud)
                        <?php 
                           $importador = App\Models\Importador::select('id', 'nombre', 'pais_id')
                                          ->where('id', '=', $solicitud->importador_id)
                                          ->first();

                           $marca = DB::table('marca')
                                    ->select('nombre')
                                    ->where('id', '=', $solicitud->marca_id)
                                    ->first();             
                        ?>
                        <li>
                           <i class="fa fa-hand-pointer-o bg-orange"></i>
                           <div class="timeline-item">
                              <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                              <h3 class="timeline-header"><a href="#" onclick="mostrarDatos({{$importador->id}});">{{ $importador->nombre }}</a> ha indicado que importa tu marca.</h3>

                              <div class="timeline-body">
                                 El importador <strong>{{ $importador->nombre }}</strong> ha indicado que importa tu marca <strong>{{ $marca->nombre }}</strong> en <strong>{{ $importador->pais->pais }}</strong>...
                              </div>
                        
                              <div class="timeline-footer">
                                 <a class="btn btn-primary btn-xs" href="{{ route('productor.confirmar-importador', [$solicitud->id, 'S', $importador->id]) }}">¡Confirmar!</a>
                                 <a class="btn btn-danger btn-xs" href="{{ route('productor.confirmar-importador', [$solicitud->id, 'N', $importador->id]) }}">¡No Confirmar!</a>
                              </div>
                           </div>
                        </li>
                     @endforeach
                  @else
                     <strong>Actualmente no posee confirmaciones de importadores pendientes.</strong>
                  @endif
               </ul>
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
                  @include('confirmaciones.tabs.filtroImportadores')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$solicitudes->appends(Request::only(['marca']))->render()}}
@endsection

