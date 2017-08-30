<div class="modal fade" id="descripcionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Descripción de la Marca</h4>
      </div>
      <div class="modal-body">
         <ul class="nav nav-stacked" id="descripcion"></ul>
         {!! Form::open(['route' => ['admin.aprobar-marca', '0'], 'method' => 'GET']) !!}
            {!! Form::hidden('marca_id', '0', ['id' => 'marca_id']) !!}
               
      </div>
      <div class="modal-footer">
         {!! Form::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
         {!! Form::submit('Aprobar', ['class' => 'btn btn-primary']) !!}
      </div>
         {!! Form::close() !!}
            }
    </div>
  </div>
</div>

