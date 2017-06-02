@extends('plantillas.main')
@section('content-left')

	
	<div class="container text-center">
		<div class="page-header">
			<h1><i class="fa fa-shopping"></i>Lista de Miembros</h1>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th>id</th>
						<th>Nombre</th>
						<th>Telefono</th>
						<th>email</th>
						<th>saldo</th>
						<th>logo</th>
						<th>pais</th>
					</tr>
				</thead>
					<tbody>
						@foreach($lista as $productores)
							<tr>
								<td>{{ $lista->id }}</td>
								<td>{{ $lista->Nombre }}</td>
								<td>{{ $lista->Telefono }}</td>
								<td>{{ $lista->email }}</td>
								<td>{{ number_format($lista->saldo) }}</td>
								<td>< img src="{{ $lista->logo }}></td>
								<td>{{ $lista->pais }}</td>
								<td>
									<a href="#" class="btn btn-circle">
										
									</a>
								</td>	
							</tr>
				
						@endforeach
					</tbody>				
			</table>
		</div>




	</div>

@stop



///'id', 'nombre', 'telefono', 'email', 'saldo', 'logo', 'pais_id'