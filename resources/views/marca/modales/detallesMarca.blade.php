<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel">Detalles de la Marca</h4>
         </div>
         <div class="modal-body">
            <div class="panel panel-default panel-success" id="infoMarca">
            
            </div>
            <span class="alert alert-warning" id="alert" style="display: none;"></span>
         </div>
         <div class="modal-footer">
            {!! Form::open(['route' => ['importador.asociar-marca', 0], 'method' => 'GET']) !!}
               {!! Form::hidden('marca_id', null, ['id' => 'marca_id']) !!}
               {!! Form::submit("Reclamar", ['class' => 'btn btn-primary pull-right'])!!}
            {!! Form::close() !!}
         </div>
      </div>
   </div>
</div>

