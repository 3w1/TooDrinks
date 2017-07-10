@extends('plantillas.adminWeb.mainAdmin')
@section('title', 'Confirmar Distribuidores')

@section('title-header')
   Confirmación de Distribuidores 
@endsection

@section('title-complement')
   (Marcas sin Propietario)
@endsection

@section('content-left')
    @section('alertas')
      @if (Session::has('msj-success'))
         <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj-success')}}.
         </div>
      @endif
   @endsection

   <ul class="timeline">
      @foreach($solicitudes as $solicitud)
         <?php 
            $distribuidor = DB::table('distribuidor')
                              ->select('id', 'nombre', 'pais_id', 'provincia_region_id')
                              ->where('id', '=', $solicitud->distribuidor_id)
                              ->first();

            $pais = DB::table('pais')
                        ->select('pais')
                        ->where('id', '=', $distribuidor->pais_id)
                        ->first();

            $provincia = DB::table('provincia_region')
                        ->select('provincia')
                        ->where('id', '=', $distribuidor->provincia_region_id)
                        ->first();

            $marca = DB::table('marca')
                        ->where('id', '=', $solicitud->marca_id)
                        ->first();             
         ?>

         <li>
            <i class="fa fa-hand-pointer-o bg-blue"></i>

            <div class="timeline-item">
               <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($solicitud->created_at)) }}</span>

               <h3 class="timeline-header"><a href="#">{{ $distribuidor->nombre }}</a> ha indicado que distribuye una marca sin propietario.</h3>

               <div class="timeline-body">
                  El distribuidor <strong>{{ $distribuidor->nombre }}</strong> ha indicado que distribuye la marca <strong>{{ $marca->nombre }}</strong> en <strong>{{ $provincia->provincia}}</strong> ({{ $pais->pais }})...
               </div>
            
               <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs" href="{{ route('admin.confirmar-distribuidor', [$solicitud->id, 'S']) }}">¡Confirmar!</a>
                  <a class="btn btn-danger btn-xs" href="{{ route('admin.confirmar-distribuidor', [$solicitud->id, 'N']) }}">¡No Confirmar!</a>
               </div>
            </div>
         </li>
      @endforeach
   </ul>
@endsection

@section('pagination')
   {{$solicitudes->render()}}
@endsection
