<div class="modal fade" id="asociarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Asociar Productor</h4>
         </div>
         <div class="modal-body">
            {!! Form::open(['route' => 'admin.asociar-producto-marca', 'method' => 'POST']) !!}
               {!! Form::hidden('producto_id', '0', ['id' => 'producto_id']) !!}
               {!! Form::label('label', 'Introduzca el nombre de la marca') !!}
               {!! Form::text('busqueda', null, ['class' => 'form-control', 'placeholder' => 'Marca', 'id' => 'busqueda']) !!} 
               <br><center><a href="#" class="btn btn-info" onclick="buscarMarca();">Buscar</a></center><hr>

               <div id="marcas" class="row"></div>    
         </div>
         <div class="modal-footer">
            {!! Form::button('Cancelar', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
            {!! Form::submit('Asociar', ['class' => 'btn btn-primary']) !!}
         </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>

