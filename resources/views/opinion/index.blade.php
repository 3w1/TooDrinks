@extends('plantillas.main')
@section('title', 'Opiniones')
@section('content-left')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Opiniones</h3>

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
					<th><center>Producto</th>
					<th><center>Valoración</th>
					<th><center>Comentario</th>
					<th><center>Fecha</th>
					<th></th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($opiniones as $opinion)
						<tr>
							<td><center>{{ $opinion->producto->nombre }}</td>
							<td><center>{{ $opinion->valoracion }}</td>
							<td><center>{{ $opinion->comentario }}</td>
							<td><center>{{ $opinion->fecha }}</td>
							<td><center><a class="btn btn-primary" href="{{ route('opinion.edit', $opinion->id ) }}"><i class="fa fa-edit"></i></a></td>
							<td><center> 
								{!! Form::open(['route' => ['opinion.destroy', $opinion->id], 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	{!! $opiniones->render() !!}
@endsection