@extends('plantillas.main')
@section('title', 'Listado de Productos')

<style>
   .checkeable input {
      display: none;
   }
   .checkeable img {
     border: 5px solid transparent;
   }
   .checkeable input {
     display: none;
   }
   .checkeable input:checked  + img {
     border-color: green;
   }
</style>

@section('items')
  @if (Session::has('msj'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
        </div>
    @endif
  <span><strong><h3>Asociar Productos de <strong>{{ $nombre_marca->nombre }}</strong></h3></strong></span>
@endsection

@section('content-left')   
   <div class="row alert alert-info">
       <strong>Seleccione los productos de la marca {{$nombre_marca->nombre}} con los que trabaja ...</strong>
   </div>
  
   <div class="row">
      {!! Form::open(['route' => 'producto.asociar-productos', 'method' => 'POST'])!!}
         @foreach($productos as $producto)
            <div class="col-md-4 col-xs-6">
               <div class="thumbnail">
                  <div>
                     <label class="checkeable">
                        <input type="checkbox" name="productos[]" value="{{$producto->id}}"/>
                        <img src="{{ asset('imagenes/productos/thumbnails/') }}/{{ $producto->imagen }}" class="img-responsive">
                     </label>
                    
                  </div>             
                     
               </div>
            </div>
         @endforeach
      
      
   </div>
   <center>{!! Form::submit('Asociar Productos', ['class' => 'btn btn-primary']) !!}</center>
   {!! Form::close() !!}
   <div>
         {{ $productos->render() }}
      </div>
@endsection


