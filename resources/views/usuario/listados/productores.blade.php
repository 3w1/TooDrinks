@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Productores')

@section('title-header')
	<span><strong><h3>Mis Productores</h3></strong></span>
@endsection

@section('content-left')
	
	<div class="row">
		@foreach($productores as $productor)
			<?php 
				$pais = DB::table('pais')
							->select('pais')
							->where('id', $productor->pais_id)
							->get()->first();
			 ?>
			<div class="col-md-6 col-xs-12">
          		<!-- Widget: user widget style 1 -->
          		<div class="box box-widget widget-user-2">
           			<!-- Add the bg color to the header using any of the bg-* classes -->
            		<div class="widget-user-header bg-blue">
              			<div class="widget-user-image">
                			<img class="img-rounded" src="{{ asset('imagenes/productores/thumbnails/')}}/{{ $productor->logo }}">
              			</div>
              			<!-- /.widget-user-image -->
              			<h3 class="widget-user-username">{{ $productor->nombre }}</h3>
              			<h5 class="widget-user-desc"> {{ $pais->pais }} </i></h5>
           			</div>
            		
            		<div class="box-footer no-padding">
              			<ul class="nav nav-stacked">
              				<li class="active"><a><stron>Correo: </stron> {{ $productor->email }} </a></li>
              				<li class="active"><a><stron>Teléfono: </stron> {{ $productor->telefono }} </a></li>
              				<li class="active"><a><stron>Créditos Disponibles: </stron> {{ $productor->saldo }} </a></li>
			                <li class="active"><a href="{{ route('productor.show', $productor->id) }}" ><strong>Ingresar al perfil</strong> </a></li>
			            </ul>
            		</div>
         		</div>
          		<!-- /.widget-user -->
       		</div>
		@endforeach

	</div>

	<div>
		<center>{!! $productores->render() !!}</center>
	</div>
	<!--<div class="box">
		<div class="box-header">
			<h3 class="box-title">Mis Productores</h3>

			<div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                	<input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar">
                  	<div class="input-group-btn">
                    	<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  	</div>
                </div>
            </div>
		</div>

		<div class="box-body table-responsive no-padding">
			<table class='table table-condensed table-hover'>
				<thead>
					<th><center>Productor</th>
					<th><center>Teléfono</th>
					<th><center>Email</th>
					<th><center>Créditos Disponibles</th>
					<th colspan="3"><center>Acciones</th>
				<tbody>
					@foreach ($productores as $productor)
						<tr>
							<td><center>{{ $productor->nombre }}</td>
							<td><center>{{ $productor->telefono }}</td>
							<td><center>{{ $productor->email }}</td>
							<td><center>{{ $productor->saldo }}</td>
							<td><center> <a class="btn btn-primary" href="{{ route('productor.edit', $productor->id ) }}"><i class="fa fa-edit"></a></td>

							<td><button class='btn btn-primary' value="{{ $productor->id }}" Onclick='Mostrar(this);' data-toggle='modal' data-target='#myModal'><i class="fa fa-edit"></i></button>
							<td><center><a class="btn btn-success" href="{{ route('productor.show', $productor->id) }}"><i class="fa fa-arrow-circle-right"></a></td>
							<td><center> 
								{!! Form::open(['route' => ['productor.destroy', $productor->id], 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>-->

@endsection