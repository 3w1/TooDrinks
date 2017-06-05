@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Importadores')

@section('title-header')
	<span><strong><h3>Mis Importadores</h3></strong></span>
@endsection

@section('content-left')
	<div class="row">
		@foreach($importadores as $importador)
			<?php 
				$pais = DB::table('pais')
							->select('pais')
							->where('id', $importador->pais_id)
							->get()->first();
			 ?>
			<div class="col-md-6 col-xs-12">
          		<!-- Widget: user widget style 1 -->
          		<div class="box box-widget widget-user-2">
           			<!-- Add the bg color to the header using any of the bg-* classes -->
            		<div class="widget-user-header bg-green">
              			<div class="widget-user-image">
                			<img class="img-circle" src="{{ asset('imagenes/importadores/')}}/{{ $importador->logo }}" alt="User Avatar">
              			</div>
              			<!-- /.widget-user-image -->
              			<h3 class="widget-user-username">{{ $importador->nombre }}</h3>
              			<h5 class="widget-user-desc"> {{ $pais->pais }} </i></h5>
           			</div>
            		
            		<div class="box-footer no-padding">
              			<ul class="nav nav-stacked">
              				<li class="active"><a><stron>Correo: </stron> {{ $importador->email }} </a></li>
              				<li class="active"><a><stron>Teléfono: </stron> {{ $importador->telefono }} </a></li>
              				<li class="active"><a><stron>Créditos Disponibles: </stron> {{ $importador->saldo }} </a></li>
			                <li class="active"><a href="{{ route('importador.show', $importador->id) }}"><strong>Ingresar al perfil</strong> </a></li>
			            </ul>
            		</div>
         		</div>
          		<!-- /.widget-user -->
       		</div>
		@endforeach

	</div>

	<div>
		<center>{!! $importadores->render() !!}</center>
	</div>
	<!--<div class="box">
		<div class="box-header">
			<h3 class="box-title">Mis Importadores</h3>

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
					<th><center>Importador</th>
					<th><center>Teléfono</th>
					<th><center>Email</th>
					<th><center>Créditos Disponibles</th>
					<th colspan="3"><center>Acciones</th>
				<tbody>
					@foreach ($importadores as $importador)
						<tr>
							<td><center>{{ $importador->nombre }}</td>
							<td><center>{{ $importador->telefono }}</td>
							<td><center>{{ $importador->email }}</td>
							<td><center>{{ $importador->saldo }}</td>
							<td><center> <a class="btn btn-primary" href="{{ route('importador.edit', $importador->id ) }}"><i class="fa fa-edit"></a></td>
							<td><center><a class="btn btn-success" href="{{ route('importador.show', $importador->id) }}"><i class="fa fa-arrow-circle-right"></a></td>
							<td><center> 
								{!! Form::open(['route' => ['importador.destroy', $importador->id], 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<div>
		<center>{!! $importadores->render() !!}</center>
	</div>-->

@endsection