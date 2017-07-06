<div class="modal fade" id="asociarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asociar Productor</h4>
      </div>
      <div class="modal-body">
         {!! Form::open(['route' => 'admin.asociar-marca-productor', 'method' => 'POST']) !!}
            {!! Form::hidden('marca_id', '0', ['id' => 'marca_id']) !!}
            {!! Form::label('label', 'Introduzca el nombre del productor') !!}
            {!! Form::text('busqueda', null, ['class' => 'form-control', 'placeholder' => 'Productor', 'id' => 'busqueda']) !!} 
            <br><center><a href="#" class="btn btn-info" onclick="buscarProductor();">Buscar</a></center><hr>

            <div id="productores" class="row">
               
            </div>    
      </div>
      <div class="modal-footer">
         {!! Form::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
         {!! Form::submit('Asociar', ['class' => 'btn btn-primary']) !!}
      </div>
         {!! Form::close() !!}
    </div>
  </div>
</div>

