@extends('plantillas.main')

@section('title', 'Planes de Crédito')

@section('title-header')
   Planes de Crédito
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
 
   @foreach($creditos as $credito)         
      <div class="col-md-4 col-xs-6">
         <div class="thumbnail">
            <img src="{{ asset('imagenes/monedas.jpg') }}" >
            <div class="caption">
               <h3>{{ $credito->plan }}</h3>
            	<p>{{ $credito->descripcion }}</p>
               <ul class="nav nav-stacked">
                  <li><a><strong>Cantidad de créditos: </strong> {{ $credito->cantidad_creditos }} $</a></li>
                  <li><a><strong>Precio: </strong> {{ $credito->precio }} $</a></li>
            	</ul>
               <p>
                  {!! Form::open(['route' => 'payment', 'method' => 'GET' ]) !!}
                     {!! Form::hidden('id', $credito->id) !!}
                     {!! Form::hidden('tipo', 'Plan') !!}
                     {!! Form::hidden('plan', $credito->plan) !!}
                     {!! Form::hidden('descripcion', $credito->descripcion) !!}
                     {!! Form::hidden('precio', $credito->precio) !!}
                     {!! Form::submit('Comprar', ['class' => 'btn btn-primary']) !!}
                  {!! Form::close() !!}
               </p>
            </div>
         </div>
      </div>
   @endforeach
@endsection

@section('pagination')
   {{$creditos->render()}}
@endsection



