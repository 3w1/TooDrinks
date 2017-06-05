@extends('plantillas.usuario.mainUsuario')
@section('title', 'Listado de Horecas')

@section('items')
	<span><strong><h3>Mis Horecas</h3></strong></span>
@endsection

@section('content-left')
	<div class="row">
		@foreach($horecas as $horeca)
			<?php 
				$pais = DB::table('pais')
							->select('pais')
							->where('id', $horeca->pais_id)
							->get()->first();
			 ?>
			<div class="col-md-6 col-xs-12">
          		<!-- Widget: user widget style 1 -->
          		<div class="box box-widget widget-user-2">
           			<!-- Add the bg color to the header using any of the bg-* classes -->
            		<div class="widget-user-header bg-green">
              			<div class="widget-user-image">
                			<img class="img-circle" src="{{ asset('imagenes/horecas/')}}/{{ $horeca->logo }}" alt="User Avatar">
              			</div>
              			<!-- /.widget-user-image -->
              			<h3 class="widget-user-username">{{ $horeca->nombre }}</h3>
              			<h5 class="widget-user-desc"> {{ $pais->pais }} </i></h5>
           			</div>
            		
            		<div class="box-footer no-padding">
              			<ul class="nav nav-stacked">
              				<li class="active"><a><stron>Correo: </stron> {{ $horeca->email }} </a></li>
              				<li class="active"><a><stron>Teléfono: </stron> {{ $horeca->telefono }} </a></li>
              				<li class="active"><a><stron>Créditos Disponibles: </stron> {{ $horeca->saldo }} </a></li>
			                <li class="active"><a href="{{ route('horeca.show', $horeca->id) }}"><strong>Ingresar al perfil</strong> </a></li>
			            </ul>
            		</div>
         		</div>
          		<!-- /.widget-user -->
       		</div>
		@endforeach

	</div>

	<div>
		<center>{!! $horecas->render() !!}</center>
	</div>
	<!--<div class="box">
		<div class="box-header">
			<h3 class="box-title">Mis Horecas</h3>

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
					<th><center>Horeca</th>
					<th><center>Teléfono</th>
					<th><center>Email</th>
					<th><center>Créditos Disponibles</th>
					<th colspan="3"><center>Acciones</th>
				<tbody>
					@foreach ($horecas as $horeca)
						<tr>
							<td><center>{{ $horeca->nombre }}</td>
							<td><center>{{ $horeca->telefono }}</td>
							<td><center>{{ $horeca->email }}</td>
							<td><center>{{ $horeca->saldo }}</td>
							<td><center> <a class="btn btn-primary" href="{{ route('horeca.edit', $horeca->id ) }}"><i class="fa fa-edit"></a></td>
							<td><center><a class="btn btn-success" href="{{ route('horeca.show', $horeca->id) }}"><i class="fa fa-arrow-circle-right"></a></td>
							<td><center> 
								{!! Form::open(['route' => ['horeca.destroy', $horeca->id], 'method' => 'DELETE']) !!}
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
		<center>{!! $horecas->render() !!}</center>
	</div>-->

@endsection