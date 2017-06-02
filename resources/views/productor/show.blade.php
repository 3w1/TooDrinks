@extends('plantillas.productor.mainProductor')
@section('title', 'Dashboard Productor')



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
	        	<p>Marcas</p>
            </div>
            <div class="icon">
             	<i class="ion ion-bag"></i>
            </div>
            @if ($cont > 0) 
            	<a href="" class="small-box-footer">Ver Mis Marcas <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="" class="small-box-footer">Agregar Marca <i class="fa fa-arrow-circle-right"></i></a>
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
            	<a href="{{  route('productor.importadores') }}" class="small-box-footer">Ver Mis Importadores <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('productor.registrar-importador') }}" class="small-box-footer">Agregar Importador <i class="fa fa-arrow-circle-right"></i></a>
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
            	<a href="{{  route('productor.distribuidores') }}" class="small-box-footer">Ver Mis Distribuidores <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('productor.registrar-distribuidor') }}" class="small-box-footer">Agregar Distribuidor<i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
	        <div class="inner">
	            <h3>{{ $cont4 }}</h3>
	            <p>Demandas de Prod / Imp</p>
	        </div>
	        <div class="icon">
	           	<i class="ion ion-pie-graph"></i>
	        </div>
	         @if ($cont4 > 0) 
            	<a href="" class="small-box-footer">Ver Mis Demandas<i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="" class="small-box-footer">Agregar Demanda <i class="fa fa-arrow-circle-right"></i></a>
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