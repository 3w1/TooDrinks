@extends('plantillas.usuario.mainUsuario')
@section('title', 'Usuario '. Auth::user()->name)

@section('items')
	@if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
    
	<div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
				<h3>{{ $cont }}</h3>
	        	<p>Productores</p>
            </div>
            <div class="icon">
             	<i class="ion ion-bag"></i>
            </div>
            @if ($cont > 0) 
            	<a href="{{  route('usuario.productores') }}" class="small-box-footer">Ver Mis Productores <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('usuario.registrar-productor') }}" class="small-box-footer">Registrar Productor <i class="fa fa-arrow-circle-right"></i></a>
            @endif
            
        </div>
    </div>
      
    <div class="col-lg-3 col-xs-6">
       	<!-- small box -->
        <div class="small-box bg-green">
	        <div class="inner">
	        	<h3>{{ $cont2 }}</h3>
	        	<p>Importadores</p>
	      	</div>
	        <div class="icon">
	          	<i class="ion ion-stats-bars"></i>
	        </div>
	         @if ($cont2 > 0) 
            	<a href="{{ route('usuario.importadores') }}" class="small-box-footer">Ver Mis Importadores <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('usuario.registrar-importador') }}" class="small-box-footer">Registrar Importador <i class="fa fa-arrow-circle-right"></i></a>
            @endif
	    </div>
    </div>

    <div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	           	<h3>{{ $cont3 }}</h3>
	            <p>Distribuidores</p>
	        </div>
	        <div class="icon">
	           	<i class="ion ion-person-add"></i>
	        </div>
             @if ($cont3 > 0) 
            	<a href="{{ route('usuario.distribuidores') }}" class="small-box-footer">Ver Mis Distribuidores <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('usuario.registrar-distribuidor') }}" class="small-box-footer">Registrar Distribuidor <i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
	        <div class="inner">
	            <h3>{{ $cont4 }}</h3>
	            <p>Horecas</p>
	        </div>
	        <div class="icon">
	           	<i class="ion ion-pie-graph"></i>
	        </div>
	         @if ($cont4 > 0) 
            	<a href="{{ route('usuario.horecas') }}" class="small-box-footer">Ver Mis Horecas <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('usuario.registrar-horeca') }}" class="small-box-footer">Agregar Horeca <i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>
@endsection

@section('content-left')

	<div class="box">
		<div class="box-header">
			<h3 class="box-title">PANEL DE USUARIO</h3>

			<div class="box-tools">
                
            </div>
		</div>

		<div class="box-body table-responsive no-padding">
			
			<center><h1>ESPACIO EN CONSTRUCCIÓN</h1>
		</div>
	</div>
	
@endsection
