@extends('plantillas.main')
@section('title', 'Publicidad')

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
      <li class="active btn btn-default">
         <a href="{{ route('banner-publicitario.create') }}"><strong>NUEVO BANNER</strong></a>
      </li>
      <li class="btn btn-default">
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
               {!! Form::open(['route' => 'banner-publicitario.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                  {!! Form::hidden('tipo_creador', session('perfilTipo')) !!}
                  {!! Form::hidden('creador_id', session('perfilId')) !!}
                  {!! Form::hidden('aprobado', '0') !!}

                  <div class="form-group">    
                     {!! Form::label('titulo', 'Título del Banner (*)')!!}
                     {!! Form::text('titulo', null, ['class' => 'form-control', 'required']) !!}
                  </div>   

                  <div class="form-group">   
                     {!! Form::label('descripcion', 'Descripción (*)')!!}
                     {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '5', 'required']) !!}
                  </div>

                  <div class="form-group">   
                     {!! Form::label('url', 'Enlace del Banner (*)')!!}
                     {!! Form::url('url_banner', null, ['class' => 'form-control', 'placeholder' => '(http://www.dominio.com)', 'required']) !!}
                  </div>

                  <div class="form-group">   
                     {!! Form::label('imagen', 'Imagen del Banner (*)')!!}
                     {!! Form::file('imagen', ['class' => 'form-control', 'required'] ) !!}
                  </div>

                  <div class="form-group">   
                     {!! Form::submit('Crear Banner', ['class' => 'btn btn-primary pull-right'])!!}
                  </div>   
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection


