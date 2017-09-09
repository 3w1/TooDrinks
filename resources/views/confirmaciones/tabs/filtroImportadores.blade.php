<div class="box box-warning">
   <div class="box-header with-border">
      <h3 class="box-title">Por Marca</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'productor.confirmar-importadores', 'method' => 'GET']) !!}
         <div class="form-group">
            {!! Form::select('marca', $marcas, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una marca...', 'required'] ) !!}
         </div>
         <div class="form-group">
            <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
         </div>
      {!! Form::close() !!}
   </div>
</div>