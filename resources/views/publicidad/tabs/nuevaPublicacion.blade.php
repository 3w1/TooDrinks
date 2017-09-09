@extends('plantillas.main')
@section('title', 'Publicidad')

{!! Html::script('js/banners/consultarDisponibilidad.js') !!}

@section('title-header')
   Publicidad
@endsection

@section('title-complement')
   (Mis Banners)
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
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.index') }}"><strong>MIS BANNERS</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.create') }}"><strong>NUEVO BANNER</strong></a>
      </li>
      <li class="active btn btn-default">
         <a href="{{ route('banner-publicitario.nueva-publicacion') }}"><strong>NUEVA PUBLICACIÓN</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.publicaciones-en-curso') }}"><strong>PUBLICACIONES EN CURSO</strong></a>
      </li>
      <li class="btn btn-default">
         <a href="{{ route('banner-publicitario.historial') }}"><strong>HISTORIAL</strong></a>
      </li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading"></div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active">
               {!! Form::open(['route' => 'payment', 'method' => 'GET']) !!}
      
                  {!! Form::hidden('cantidad_clics', 0) !!}
                  {!! Form::hidden('pagado', 0) !!}
                  {!! Form::hidden('fecha_inicio', null, ['id' => 'fecha_inicio']) !!}
                  {!! Form::hidden('fecha_fin', null, ['id' => 'fecha_fin']) !!}
                  {!! Form::hidden('precio', null, ['id' => 'precio']) !!}
                  {!! Form::hidden('tipo', 'Banner') !!}
                  
                  <div class="form-group">   
                     {!! Form::label('banner', 'Banner Publicitario (*)')!!}
                     {!! Form::select('banner_id', $banners, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un banner...', 'id' => 'banner', 'required']) !!}
                  </div>   

                  <div class="form-group">   
                     {!! Form::label('pais', 'País Destino')!!}
                     {!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país...', 'id' => 'pais', 'onchange' => 'resetTiempo();']) !!}
                  </div>      

                  <div class="form-group">   
                     {!! Form::label('tiempo', 'Tiempo de Publicación (Semanas)')!!}
                     {!! Form::select('tiempo_publicacion', ['' => 'Seleccione una opción...', '1' => '1 Semana', '2' => '2 Semanas', '3' => '3 Semanas', '4' => '4 Semanas'], null, ['class' => 'form-control', 'id' => 'semanas', 'onchange' => 'consultarDisponibilidad();', 'required']) !!}
                  </div>

                  <div class="alert alert-success" id="fechas" style="display: none;">
                     
                  </div>
               
                  <button class="btn btn-primary pull-right" id="boton" style="display: none;">Continuar</button>

               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection


