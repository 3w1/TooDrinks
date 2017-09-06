@extends('adminWeb.plantillas.main')
@section('title', 'Banners')

@section('title-header')
   Sugerir Correcciones
@endsection

@section('content-left')
	<div class="row">
      <div class="col-md-4"></div>
      <div class="col-sm-6 col-md-4">
        	<img src="{{ asset('imagenes/banners/thumbnails') }}/{{ $banner->imagen }}">
      </div>
   	<div class="col-md-4"></div>
	</div>

   <div class="row">
   	<div class="col-md-1"></div>
      <div class="col-md-10 col-xs-12"> 
      	<div class="panel panel-default panel-success">
         	<div class="panel-heading"><h4><b> 
               	{{ $banner->titulo }}</b></h4>
            </div>
             
         	<ul class="list-group">
         		<li class="list-group-item"><b>Descripción:</b> {{ $banner->descripcion }}</li>
               <li class="list-group-item"><b>URL Destino:</b> {{ $banner->url_banner }}</li>
            </ul>
         </div>
      </div>
   </div>
@endsection

@section('content-right')
	<div class="box box-solid">
      <div class="box-header with-border">
      	<h3 class="box-title">Sugerencias</h3>

         <div class="box-tools">
      	   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      	</div>
   	</div>

      <div class="box-body">
      	{!! Form::open(['route' => 'admin.guardar-sugerencias-banner', 'method' => 'POST']) !!}
         	{!! Form::hidden('banner_id', $banner->id) !!}
      		<div class="form-group">
		       	{!! Form::textarea('sugerencias', null, ['class' => 'form-control', 'placeholder' => 'Ingrese aquí todas las sugerencias que desee realizar sobre el banner.', 'rows' => '15' ]) !!}
		      </div>
		    	{!! Form::submit('Guardar Sugerencias', ['class' => 'btn btn-primary pull-right']) !!}
		   {!! Form::close() !!}
     	</div>
   </div>      
@endsection