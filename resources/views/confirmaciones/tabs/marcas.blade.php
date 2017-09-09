@extends('plantillas.main')
@section('title', 'Confirmaciones')

@section('title-header')
   Confirmaciones
@endsection

@section('title-complement')
   (Marcas)
@endsection

@section('content-left')
   <?php 
      if (session('perfilTipo') == 'P'){
         $not_ai = DB::table('notificacion_p')->select('id')
                  ->where('productor_id', '=', session('perfilId'))
                  ->where('tipo', '=', 'AI')->where('leida', '=', '0')->get();
         $ai=0;
         foreach($not_ai as $nai){
            $ai++;
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
            DB::table('notificacion_p')->where('id', '=', $nnm->id)->update(['leida' => '1']);
         }
      }elseif (session('perfilTipo') == 'I'){
         
      }elseif (session('perfilTipo') == 'D'){
         
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
      <li class="btn btn-default">
         <a href="{{ route('productor.confirmar-importadores') }}"><strong>IMPORTADORES | 
         <small class="label bg-red">{{ $ai }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('productor.confirmar-distribuidores') }}"><strong>DISTRIBUIDORES | <small class="label bg-red">{{ $ad }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('productor.confirmar-productos') }}"><strong>PRODUCTOS| <small class="label bg-red">{{ $np }}</small></strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('productor.confirmar-marcas') }}"><strong>MARCAS | <small class="label bg-orange">{{ $nm }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($marcas as $marca)
                        <li>
                           <i class="fa fa-hand-pointer-o bg-orange"></i>
                           <div class="timeline-item">
                              <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($marca->created_at)) }}</span>
                              <h3 class="timeline-header">El administrador web te ha asociado la marca <strong>{{ $marca->nombre }}</strong>.</h3>

                              <div class="timeline-body">
                                 <div class="panel panel-default panel-info">
                                    <div class="panel-heading"><h5><b>Detalles</b></h5></div>
                                    <ul class="list-group">
                                       <li class="list-group-item"><b>Nombre SEO:</b> {{ $marca->nombre_seo }}</li>
                                       <li class="list-group-item"><b>Descripción:</b> {{ $marca->descripcion}} </li>
                                       <li class="list-group-item"><b>País Originario:</b> {{ $marca->pais->pais }}</li>
                                       <li class="list-group-item"><b>Website:</b> {{ $marca->website }}</li>
                                    </ul>
                                 </div>
                              </div>
                              
                              <div class="timeline-footer">
                                 <a class="btn btn-primary btn-xs" href="{{ route('productor.confirmar-marca', [$marca->id, 'S']) }}">¡Confirmar!</a>
                                 <a class="btn btn-danger btn-xs" href="{{ route('productor.confirmar-marca', [$marca->id, 'N']) }}">¡No Confirmar!</a>
                              </div>
                           </div>
                        </li>
                     @endforeach
                  @else
                     <strong>Actualmente no posee confirmaciones de marcas pendientes.</strong>
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

               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$marcas->render()}}
@endsection

