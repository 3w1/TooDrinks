<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Por Título</h3>
   	<div class="box-tools pull-right">
      	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'oferta.disponibles', 'method' => 'GET']) !!}
         <div class="form-group">
   		 	{!! Form::text('busqueda', null, ['class' => 'form-control', 'id' => 'busqueda1', 'placeholder' => 'Introduzca el titulo de la oferta...']) !!}
   		</div>	
   		<div class="form-group">
   			<center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
   		</div>
		{!! Form::close() !!}
   </div>
</div>

<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Por Producto</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'oferta.disponibles', 'method' => 'GET']) !!}
         <div class="form-group">
            {!! Form::select('producto', $productos, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un producto...']) !!}
         </div>   
         <div class="form-group">
            <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
         </div>
      {!! Form::close() !!}
   </div>
</div>





