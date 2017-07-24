@extends('plantillas.main')
@section('title', 'Banner Publicitario')

@section('items')
@endsection

@section('content-left')
   @section('title-header')
      <h3><b>Confirmar Publicidad</b></h3>
   @endsection

   @if (Session::has('msj'))
      <div class="alert alert-success alert-dismissable">
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <strong>¡Ya Casi!</strong> {{Session::get('msj')}}.
      </div>
   @endif

   <div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
         <div class="thumbnail"><img src="{{ asset('imagenes/banners/thumbnails') }}/{{ $infoPublicidad->banner->imagen }}"></div>
      </div>
      <div class="col-md-4"></div>
   </div>

   <div class="row">
      <div class="col-md-1"></div>
         
      <div class="col-md-10 col-xs-12"> 
         <div class="panel panel-default panel-success">
            <div class="panel-heading"><h4><b> 
               {{ $infoPublicidad->banner->titulo }}</b></h4>
            </div>
             
            <ul class="list-group">
               <li class="list-group-item"><b>Fecha de Inicio:</b> {{ date('d-m-Y', strtotime($infoPublicidad->fecha_inicio)) }}</li>
               <li class="list-group-item"><b>Fecha de Finalización:</b> {{ date('d-m-Y', strtotime($infoPublicidad->fecha_fin)) }}</li>
               <li class="list-group-item"><b>Tiempo de Publicación:</b> {{ $infoPublicidad->tiempo_publicacion }} Días</li>
               <li class="list-group-item"><b>Total a Pagar:</b> {{ $infoPublicidad->precio }} $</li>
               <li class="list-group-item"><center>
                  {!! Form::open(['route' => 'payment', 'method' => 'GET']) !!}
                     {!! Form::hidden('impresion_id', $infoPublicidad->id) !!}
                     {!! Form::hidden('precio', $infoPublicidad->precio) !!}
                     {!! Form::hidden('tipo', 'Banner') !!}
                     {!! Form::submit('Pagar', ['class' => 'btn btn-primary']) !!}
                  {!! Form::close() !!}
               </center></li>
               
            </ul>
         </div>
      </div>
   </div>
@endsection