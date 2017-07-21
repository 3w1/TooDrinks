<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar Banner</h4>
      </div>
      <div class="modal-body">
         {!! Form::open(['route' => ['banner-publicitario.update', $banner->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}

            <div class="form-group">   
               {!! Form::label('titulo', 'Título del Banner')!!}
               {!! Form::text('titulo', $banner->titulo, ['class' => 'form-control']) !!}
            </div>   
            <div class="form-group">   
               {!! Form::label('descripcion', 'Descripción')!!}
               {!! Form::textarea('descripcion', $banner->descripcion, ['class' => 'form-control', 'rows' => '5']) !!}
            </div>      
            <div class="form-group">   
               {!! Form::label('url', 'Enlace del Banner')!!}
               {!! Form::url('url_banner', $banner->url_banner, ['class' => 'form-control']) !!}
            </div>
      </div>
      <div class="modal-footer">
         {!! Form::submit('Actualizar Banner', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>