@extends('plantillas.main')
@section('title', 'Nueva Marca')

@section('title-header')
   Marcas
@endsection

@section('title-complement')
   (Nueva Marca)
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
      	<li class="btn btn-default"><a href="{{ route('marca.index') }}"><strong>MIS MARCAS</strong></a></li>
      	<li class="btn btn-default"><a href="{{ route('marca.agregar-marca') }}"><strong>AGREGAR MARCA</strong></a></li>
      	<li class="active btn btn-default"><a href="{{ route('marca.create') }}"><strong>CREAR MARCA</strong></a></li>
   	</ul>
   	<div class="panel with-nav-tabs panel-primary">
      	<div class="panel-heading">
         
      	</div>
      	<div class="panel-body">
         	<div class="tab-content">
            	<div class="tab-pane fade in active">
                	@include('marca.formularios.createForm')
            	</div>
         	</div>
      	</div>
   	</div>
@endsection

@section('content-right')
    
@endsection

