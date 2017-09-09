<div class="box box-warning">
   <div class="box-header with-border">
      <h3 class="box-title">Por País</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
   </div>
   <div class="box-body">
      {!! Form::open([ 'route' => 'banner-publicitario.publicaciones-en-curso', 'method' => 'GET']) !!}
         <div class="form-group">
            {!! Form::select('pais', $paises, null, ['class' => 'form-control', 'placeholder' => 'Seleccione un país..', 'required'] ) !!}
         </div>
         <div class="form-group">
            <center>{!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}</center>
         </div>
      {!! Form::close() !!}
   </div>
</div>