
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar Oferta</h4>
      </div>
      <div class="modal-body">
      
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
         {!! Form::open(['route' => ['oferta.update', $oferta->id], 'method' => 'PUT']) !!}
            {!! Form::hidden('who', 'D') !!}
            {!! Form::hidden('tipo_creador', $oferta->tipo_creador) !!}
            {!! Form::hidden('creador_id', $oferta->creador_id) !!}

            @include('oferta.formularios.editForm')       
      </div>
      <div class="modal-footer">
         {!! Form::submit('Modificar Oferta', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>