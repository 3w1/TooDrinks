<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Por Nombre</h3>
   	<div class="box-tools pull-right">
      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   	<div class="box-body">
      	<div class="form-group">
      		{!! Form::open([ 'route' => 'producto.index', 'method' => 'GET']) !!}
		   		{!! Form::text('busqueda', null, ['class' => 'form-control', 'id' => 'busqueda1', 'placeholder' => 'Introduzca el nombre del producto...']) !!}
		   </div>
		<div class="form-group">
			<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
		</div>
		{!! Form::close() !!}
   </div>
</div>

<div class="box box-warning">
   <div class="box-header with-border">
      <h3 class="box-title">Por Marca</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'producto.index', 'method' => 'GET']) !!}
         <div class="form-group">
            {!! Form::select('marca', $marcas, null, ['class' => 'form-control', 'required'] ) !!}
         </div>
         <div class="form-group">
            <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
         </div>
      {!! Form::close() !!}
   </div>
</div>

<div class="box box-warning">
   <div class="box-header with-border">
   	<h3 class="box-title">Por Tipo de Bebida</h3>
      <div class="box-tools pull-right">
      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
	<div class="box-body">
      {!! Form::open([ 'route' => 'producto.index', 'method' => 'GET']) !!}
		   <div class="form-group">
            {!! Form::label('bebida', 'Bebida') !!}
            {!! Form::select('bebida', $tipos_bebidas, null, ['class' => 'form-control', 'id' => 'bebida_id', 'onchange' => 'cargarClases("B");', 'required'] ) !!}
         </div>
         <div class="form-group">
            {!! Form::label('clase', 'Clase') !!}
            <select name="clase_bebida" class="form-control" id="clases_bebidas">
               <option value="">Seleccione una clase..</option>
            </select>
         </div>
	   	<div class="form-group">
			   <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
		   </div>
		{!! Form::close() !!}
   </div>
</div>

