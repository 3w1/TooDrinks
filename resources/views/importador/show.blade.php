@extends('plantillas.importador.mainImportador')
@section('title', 'Dashboard Importador')

@section('items')
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
            	<a href="" class="small-box-footer">Registrar Marca <i class="fa fa-arrow-circle-right"></i></a>
            @endif
            
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	           	<h3>{{ $cont2 }}</h3>
	            <p>Distribuidores</p>
	        </div>
	        <div class="icon">
	           	<i class="ion ion-person-add"></i>
	        </div>
             @if ($cont2 > 0) 
            	<a href="" class="small-box-footer">Ver Mis Distribuidores <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="" class="small-box-footer">Registrar Distribuidor<i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $cont3 }}</h3>
                <p>Ofertas</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
             @if ($cont3 > 0) 
                <a href="" class="small-box-footer">Ver Mis Ofertas<i class="fa fa-arrow-circle-right"></i></a>
            @else
                <a href="" class="small-box-footer">Registrar Oferta<i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
	        <div class="inner">
	            <h3>{{ $cont4 }}</h3>
	            <p>Demandas de Productos</p>
	        </div>
	        <div class="icon">
	           	<i class="ion ion-pie-graph"></i>
	        </div>
	         @if ($cont4 > 0) 
            	<a href="" class="small-box-footer">Ver Mis Demandas<i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="" class="small-box-footer">Registrar Demanda <i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>
@endsection

@section('content-left')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">PANEL DE IMPORTADOR</h3>

			<div class="box-tools">
                
            </div>
		</div>

		<div class="box-body table-responsive no-padding">
			
			<center><h1>ESPACIO EN CONSTRUCCIÓN</h1>
		</div>
	</div>

@endsection