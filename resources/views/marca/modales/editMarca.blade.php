<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modificar Marca</h4>
         </div>
         <div class="modal-body">
            @include('marca.formularios.editForm')        
         </div>
         <div class="modal-footer">
            {!! Form::submit('Modificar Marca', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>