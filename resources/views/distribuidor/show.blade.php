@extends('plantillas.distribuidor.mainDistribuidor')
@section('title', 'Dashboard Distribuidor')

@section('items')
	@if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif

    <div class="col-lg-6 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner">
				<h3>{{ $cont }}</h3>
	        	<p>Marcas</p>
            </div>
            <div class="icon">
             	<i class="ion ion-bag"></i>
            </div>
            @if ($cont > 0) 
            	<a href="{{ route('distribuidor.marcas') }}" class="small-box-footer">Ver Mis Marcas <i class="fa fa-arrow-circle-right"></i></a>
            @else
            	<a href="{{ route('distribuidor.registrar-marca') }}" class="small-box-footer">Registrar Marca <i class="fa fa-arrow-circle-right"></i></a>
            @endif
            
        </div>
    </div>

    <div class="col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $cont2 }}</h3>
                <p>Ofertas</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
             @if ($cont2 > 0) 
                <a href="{{ route('distribuidor.ofertas') }}" class="small-box-footer">Ver Mis Ofertas<i class="fa fa-arrow-circle-right"></i></a>
            @else
                <a href="" class="small-box-footer">Registrar Oferta<i class="fa fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div>
@endsection

@section('content-left')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">PANEL DE DISTRIBUIDOR</h3>

			<div class="box-tools">
                
            </div>
		</div>

		<div class="box-body table-responsive no-padding">
			
			<center><h1>ESPACIO EN CONSTRUCCIÓN</h1>
		</div>
	</div>

@endsection