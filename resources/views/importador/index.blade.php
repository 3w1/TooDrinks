@extends('plantillas.importador.mainImportador')
@section('title', 'Importadores')
@section('content-left')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Importadores</h3>

			<div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                	<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                  	<div class="input-group-btn">
                    	<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  	</div>
                </div>
            </div>
		</div>

		<div class="box-body table-responsive no-padding">
			<table class='table table-condensed table-hover'>
				<thead>
					<th><center>Nombre</th>
					<th><center>Dirección</th>
					<th><center>Descripción</th>
					<th><center>Email</th>
					<th></th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($importadores as $importador)
						<tr>
							<td><center>{{ $importador->nombre }}</td>
							<td><center>{{ $importador->direccion }}</td>
							<td><center>{{ $importador->descripcion }}</td>
							<td><center>{{ $importador->email }}</td>
							<td><center> <a class="btn btn-primary" href="{{ route('importador.edit', $importador->id ) }}"><i class="fa fa-edit"></a></td>
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
	{!! $importadores->render() !!}
@endsection