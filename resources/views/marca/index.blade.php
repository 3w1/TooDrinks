@extends('plantillas.main')
@section('title', 'Listado de Marcas')

@section('title-header')
   Marcas
@endsection

@section('title-complement')
   (Mis Marcas)
@endsection

<script>
   function activarTabs1(){
      $("#2").removeClass("active");
      $("#tab2").removeClass("active");
      $("#tab22").removeClass("active");
      $("#1").addClass("active");
      $("#tab1").addClass("active");
      $("#tab11").addClass("active");
   }

   function activarTabs2(){
      $("#1").removeClass("active");
      $("#tab1").removeClass("active");
      $("#tab11").removeClass("active");
      $("#2").addClass("active");
      $("#tab2").addClass("active");
      $("#tab22").addClass("active");
   }
</script>

@section('content-left')
   @section('alertas')
      @if (Session::has('msj'))
         <div class="alert alert-success alert-dismissable">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>¡Enhorabuena!</strong> {{Session::get('msj')}}.
            </div>
      @endif

      <div class="alert alert-danger alert-dismissable" style="display: none;" id="alerta">
         <div id="mensaje"></div>
      </div>
   @endsection  

   @include('marca.modales.detallesMarca') 
   
   <ul class="nav nav-pills">
      <li class="active btn btn-default" id="1"><a href="#" onclick="activarTabs1();" ><strong>MIS MARCAS</strong></a></li>
      <li class="btn btn-default" id="2"><a href="#" onclick="activarTabs2();" ><strong>AGREGAR MARCA</strong></a></li>
   </ul>
   <div class="panel with-nav-tabs panel-primary">
      <div class="panel-heading">
         
      </div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1">
               @include('marca.tabs.misMarcas')
            </div>
            <div class="tab-pane fade in" id="tab2">
               <div id="marcas">
                  <h4>Elija uno de los filtros para realizar la búsqueda...</h4>
               </div>
            </div>
         </div>
      </div>
   </div>

@endsection

@section('content-right')
    <div class="panel with-nav-tabs panel-default">
      <div class="panel-heading">
         <h5><b><center>Filtros de Búsqueda</center></b></h5>
      </div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade in active" id="tab11">
               @include('marca.tabs.filtroMisMarcas')
            </div>
            <div class="tab-pane fade in" id="tab22">
               @include('marca.tabs.filtroAgregarMarca')
            </div>
         </div>
      </div>
   </div>
@endsection
@section('paginacion')
   {{$marcas->appends(Request::only(['busqueda', 'status']))->render()}}
@endsection