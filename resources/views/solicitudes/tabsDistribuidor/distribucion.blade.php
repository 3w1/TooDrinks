@extends('plantillas.main')
@section('title', 'Solicitudes')

@section('title-header')
   Solicitudes
@endsection

@section('title-complement')
   (Distribuidor)
@endsection

@section('content-left')
   <?php 
      $not_dp = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->get();
      $dp=0;
      foreach($not_dp as $ndp){
         $dp++;
      }

      $not_db = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->get();
      $db=0;
      foreach($not_db as $ndb){
         $db++;
      }

      $not_dd = DB::table('notificacion_d')->select('id')
               ->where('distribuidor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DD')->where('leida', '=', '0')->get();
      $dd=0;
      foreach($not_dd as $ndd){
         $dd++;
         DB::table('notificacion_d')->where('id', '=', $ndd->id)->update(['leida' => '1']);
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
         <a href="{{ route('demanda-producto.demandas-productos-disponibles') }}"><strong>PRODUCTO | 
         <small class="label bg-red">{{ $dp }}</small></strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('demanda-producto.demandas-bebidas-disponibles') }}"><strong>BEBIDA | <small class="label bg-red">{{ $db }}</small></strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('demanda-distribuidor.demandas-disponibles') }}"><strong>DISTRIBUCIÓN | <small class="label bg-orange">{{ $dd }}</small></strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               <ul class="timeline">
                  @if ($cont > 0)
                     @foreach($demandasDistribuidores as $demandaDistribuidor)
                        <?php 
                           $existe = DB::table('distribuidor_marca')
                                       ->where('distribuidor_id', '=', session('perfilId'))
                                       ->where('marca_id', '=', $demandaDistribuidor->marca_id)
                                       ->first();

                           if ($existe == null){
                              $relacion = DB::table('distribuidor_demanda_distribuidor')
                                       ->select('demanda_distribuidor_id')
                                       ->where('demanda_distribuidor_id', '=', $demandaDistribuidor->id)
                                       ->where('distribuidor_id', '=', session('perfilId'))
                                       ->first();
                           }else{
                              $relacion = '1';
                           }            
                        ?>
                        @if ($relacion == null)
                           <?php 
                              if ($demandaDistribuidor->tipo_creador == 'P'){
                                 $creador= DB::table('productor')
                                             ->select('nombre')
                                             ->where('id', '=', $demandaDistribuidor->creador_id)
                                             ->get()
                                             ->first(); 
                              }else{
                                 $creador= DB::table('importador')
                                             ->select('nombre')
                                             ->where('id', '=', $demandaDistribuidor->creador_id)
                                             ->get()
                                             ->first(); 
                              }
                           ?>
                           <li>
                              <i class="fa fa-hand-pointer-o bg-orange"></i>
                              <div class="timeline-item">
                                 <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demandaDistribuidor->created_at)) }}</span>

                                  <h3 class="timeline-header"> @if($demandaDistribuidor->tipo_creador == 'P') Un productor está buscando distribuidores para su marca. </h3> @else Un importador está buscando distribuidores para su marca.</h3> @endif

                                 <div class="timeline-body">
                                    @if($demandaDistribuidor->tipo_creador == 'P') El productor @else El importador @endif <strong>{{ $creador->nombre }}</strong> ha indicado que está en la búsqueda de nuevos distribuidores para su marca <strong>{{ $demandaDistribuidor->marca->nombre }}</strong> en tu provincia...
                                 </div>
                                 
                                  <div class="timeline-footer">
                                    <a class="btn btn-primary btn-xs" href="{{ route('demanda-distribuidor.show', $demandaDistribuidor->id) }}">¡Más Detalles!</a>
                                    <a class="btn btn-danger btn-xs" href="{{ route('demanda-distribuidor.marcar', [$demandaDistribuidor->id, '0']) }}">¡No Me Interesa!</a>
                                 </div>
                              </div>
                           </li>
                        @endif
                     @endforeach
                  @else
                     <strong>No existen demandas de dsitribuidores disponibles.</strong>
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
   {{$demandasDistribuidores->render()}}
@endsection

