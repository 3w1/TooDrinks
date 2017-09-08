@extends('plantillas.main')
@section('title', 'Listado de Productos')

@section('title-header')
   Productos
@endsection

@section('title-complement')
   (Mis Productos)
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
   	<li class="btn btn-default"><a href="{{ route('producto.index') }}"><strong>MIS PRODUCTOS</strong></a></li>
      <li class="btn btn-default"><a href="{{ route('producto.agregar-producto') }}"><strong>AGREGAR PRODUCTO</strong></a></li>
      <li class="active btn btn-default"><a href="{{ route('producto.create') }}"><strong>CREAR PRODUCTO</strong></a></li>
   </ul>

   <div class="panel with-nav-tabs panel-primary">
   	<div class="panel-heading"></div>
      <div class="panel-body">
      	<div class="tab-content">
            <div class="tab-pane fade in active">
               @include('producto.formularios.createForm')
         	</div>
      	</div>
   	</div>
   </div>
@endsection

