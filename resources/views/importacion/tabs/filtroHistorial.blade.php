<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Por Tipo</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'solicitud-importacion.historial', 'method' => 'GET']) !!}
         <div class="form-group">
            {!! Form::select('tipo', ['M' => 'Marca', 'B' => 'Bebida'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción...']) !!}
         </div>   
         <div class="form-group">
            <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
         </div>
      {!! Form::close() !!}
   </div>
</div>
