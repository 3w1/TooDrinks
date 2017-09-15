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
      <li class="btn btn-default"><a href="{{ route('oferta.index') }}"><strong>MIS OFERTAS ACTIVAS</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('oferta.create') }}"><strong>NUEVA OFERTA</strong></a></li>
      @if (session('perfilTipo') != 'P')
         <li class="btn btn-default">
            <a href="{{ route('oferta.disponibles') }}"><strong>OFERTAS DISPONIBLES | 
            <small class="label bg-red">{{ $od }}</small></strong></a>
         </li>
      @endif
      <li class="active btn btn-default"><a href="{{ route('oferta.historial')}}"><strong>HISTORIAL DE OFERTAS</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
               <div class="box">
                  <div class="box-body table-responsive no-padding table-bordered">
                     <table class="table table-hover">
                        <thead>
                           <th><center>Fecha</center></th>
                           <th><center>Título</center></th>
                           <th><center>Producto</center></th>
                           <th><center>Visitas / Contactos</center></th>
                           <th><center>Acción</center></th>
                        </thead>
                        <tbody>
                           @if ($cont > 0)
                              @foreach ($ofertas as $oferta) 
                                 <tr>
                                    <td><center>{{ date('d-m-Y', strtotime($oferta->fecha)) }}</td>
                                    <td><center>{{ $oferta->titulo}} </center></td>
                                    <td><center>{{ $oferta->producto->nombre}} </center></td>
                                    <td><center>
                                       <label class="label label-warning">{{ $oferta->cantidad_visitas}}</label> / <label class="label label-success">{{ $oferta->cantidad_contactos}}</label> 
                                    </center></td>
                                    <td><center>
                                       <a href="{{ route('oferta.detalles', [$oferta->id, $oferta->titulo]) }}" class="btn btn-primary btn-xs"> Detalles <i class="fa fa-eye"></i></a></td>
                                    </center></td>
                                 </tr>
                              @endforeach
                           @else
                              <tr>
                                 <td colspan="5"><strong>Actualmente no existen ofertas en su historial.</strong></td>
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

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
         <div class="panel-heading">
            <h5><b><center>Filtros de Búsqueda</center></b></h5>
         </div>
         <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active">
                  @include('mercado.tabs.filtroHistorialOfertas')
               </div>
            </div>
         </div>
      </div>
@endsection

@section('paginacion')
   {{$ofertas->appends(Request::only(['busqueda', 'producto']))->render()}}
@endsection

