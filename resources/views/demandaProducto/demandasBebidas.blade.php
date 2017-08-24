@extends('plantillas.main')
@section('title', 'Demandas de Productos/Bebidas')

@section('title-header')
   Demandas de Bebidas
@endsection

@section('content-left')
   
   @section('alertas')
      @if (Session::has('msj'))
           <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
           </div>
       @endif
   @endsection

   <div class="col-md-12">
      <ul class="timeline">
         <li class="time-label">
            <span class="bg-yellow">
               Demandas de Tipos de Bebidas
            </span>
         </li>
         
         @foreach($demandasBebidas as $demandaBebida)
            <?php 
               if (session('perfilTipo') == 'P'){
                  $relacion = DB::table('productor_demanda_producto')
                           ->select('demanda_producto_id')
                           ->where('demanda_producto_id', '=', $demandaBebida->id)
                           ->where('productor_id', '=', session('perfilId'))
                           ->first();
               }elseif (session('perfilTipo') == 'I'){
                  $relacion = DB::table('importador_demanda_producto')
                           ->select('demanda_producto_id')
                           ->where('demanda_producto_id', '=', $demandaBebida->id)
                           ->where('importador_id', '=', session('perfilId'))
                           ->first();
               }elseif (session('perfilTipo') == 'D'){
                  $relacion = DB::table('distribuidor_demanda_producto')
                           ->select('demanda_producto_id')
                           ->where('demanda_producto_id', '=', $demandaBebida->id)
                           ->where('distribuidor_id', '=', session('perfilId'))
                           ->first();
               }

               $demanda = App\Models\Demanda_Producto::find($demandaBebida->id);
            ?>
            
            @if ($relacion == null)
               <li>
                  <i class="fa fa-hand-pointer-o bg-blue"></i>
                  <div class="timeline-item">
                     <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y', strtotime($demanda->created_at)) }}</span>
                     <h3 class="timeline-header">
                        @if ($demanda->tipo_creador == 'I') 
                           Un importador 
                        @elseif ($demanda->tipo_creador == 'D') 
                           Un Distribuidor 
                        @else 
                           Un Horeca 
                        @endif está demandando un tipo de bebida que tu posees.
                     </h3>

                     <div class="timeline-body">
                        @if ($demanda->tipo_creador == 'I') 
                           Un importador 
                        @elseif ($demanda->tipo_creador == 'D') 
                           Un Distribuidor  
                        @else 
                           Un Horeca 
                        @endif está en la búsqueda de <strong>{{ $demanda->bebida->nombre }}</strong>. 
                        <br><strong>Descripción de la Demanda:</strong> {{ $demanda->titulo }}. ({{ $demanda->descripcion }}).
                     </div>
               
                     <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('demanda-producto.show', $demanda->id) }}">¡Más Detalles!</a>
                        <a class="btn btn-danger btn-xs" href="{{ route('demanda-producto.marcar', [$demandaBebida->id, '0']) }}">¡No Me Interesa!</a>
                     </div>
                  </div>
               </li>
            @endif
         @endforeach
      </ul>
   </div>
@endsection

@section('paginacion')
   {{$demandasBebidas->render()}}
@endsection
