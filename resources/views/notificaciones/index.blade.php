@extends('plantillas.main')
@section('title', 'Notificaciones')

@section('items')
   @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Notificaciones</h3></strong></span>
   
@endsection

@section('content-left')
   <div class="row">
      
      <div class="col-md-12">
         <ul class="timeline">
            
            @foreach($notificaciones as $notificacion)

               <li class="time-label">
                  <span class="{{ $notificacion->color }}">{{ $notificacion->descripcion }}</span>
               </li>
      
               <li>
                  <i class="{{ $notificacion->icono }} {{ $notificacion->color }}"></i>
                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($notificacion->created_at)) }}</span>
                    @if($notificacion->leida == '1')
                     	<h3 class="timeline-header"><a href="{{ url($notificacion->url) }}" style="color:#151515;">{{ $notificacion->titulo }}</a></h3>
                    @else
                    	<h3 class="timeline-header"><a href="{{ route('notificacion.leida', $notificacion->id) }}">{{ $notificacion->titulo }}</a></h3>
                    @endif
                  </div>
               </li>
               
            @endforeach
         </ul>
      </div>
   
      <div>
        {{ $notificaciones->render() }}
      </div>
   </div>
@endsection
