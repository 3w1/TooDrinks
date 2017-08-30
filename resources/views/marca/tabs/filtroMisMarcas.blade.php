<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Búsqueda por Nombre</h3>
   	<div class="box-tools pull-right">
      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   	<div class="box-body">
      	<div class="form-group">
      		{!! Form::open([ 'route' => 'marca.index', 'method' => 'GET']) !!}
		   		{!! Form::text('busqueda', null, ['class' => 'form-control', 'id' => 'busqueda1', 'placeholder' => 'Introduzca el nombre de la marca...']) !!}
		</div>
			
		<div class="form-group">
			<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
		</div>
		{!! Form::close() !!}
   </div>
</div>

<div class="box box-warning">
   	<div class="box-header with-border">
      	<h3 class="box-title">Búsqueda por Status</h3>
      	<div class="box-tools pull-right">
         	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      	</div>
   	</div>
	<div class="box-body">
      	<div class="form-group">
      		{!! Form::open([ 'route' => 'marca.index', 'method' => 'GET']) !!}
		   		{!! Form::select('status', ['1' => 'Publicadas', '0' => 'Sin Publicar'], null, ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Seleccione una opción...']) !!}
		</div>
	   	<div class="form-group">
			<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
		</div>
		{!! Form::close() !!}
   	</div>
</div>

