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
            {!! Form::hidden('who', 'P') !!}

            @include('oferta.formularios.editForm')  

            <div class="form-group">
              {!! Form::label('visible_importador', 'Disponible para Distribuidores') !!}
              {!! Form::select('visible_importadores', ['0' => 'No', '1' => 'Si'], $oferta->visible_importadores, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('visible_distribuidor', 'Disponible para Distribuidores') !!}
              {!! Form::select('visible_distribuidores', ['0' => 'No', '1' => 'Si'], $oferta->visible_distribuidores, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('visible_horeca', 'Visible para Horecas') !!}
              {!! Form::select('visible_horecas', ['0' => 'No', '1' => 'Si'], $oferta->visible_horecas, ['class' => 'form-control']); !!}
            </div>             
      </div>
      <div class="modal-footer">
         {!! Form::submit('Modificar Oferta', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>