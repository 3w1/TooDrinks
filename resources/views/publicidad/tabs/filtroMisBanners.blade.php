<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Por Nombre</h3>
   	<div class="box-tools pull-right">
      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   	<div class="box-body">
      	<div class="form-group">
      		{!! Form::open([ 'route' => 'banner-publicitario.index', 'method' => 'GET']) !!}
		   		{!! Form::text('busqueda', null, ['class' => 'form-control', 'placeholder' => 'Introduzca el nombre del banner...']) !!}
		   </div>
		<div class="form-group">
			<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
		</div>
		{!! Form::close() !!}
   </div>
</div>

<div class="box box-warning">
   <div class="box-header with-border">
      <h3 class="box-title">Por Status</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'banner-publicitario.index', 'method' => 'GET']) !!}
         <div class="form-group">
            {!! Form::select('status', ['1' => 'Aprobado', '0' => 'En Revisión'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción..', 'required'] ) !!}
         </div>
         <div class="form-group">
            <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
         </div>
      {!! Form::close() !!}
   </div>
</div>