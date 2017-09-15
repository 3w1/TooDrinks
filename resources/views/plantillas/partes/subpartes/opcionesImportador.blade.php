<?php 
    $dp = DB::table('notificacion_i')->select(DB::raw('count(*) as cant'))
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->first();

    $db = DB::table('notificacion_i')->select(DB::raw('count(*) as cant'))
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->first();

    $di = DB::table('notificacion_i')->select(DB::raw('count(*) as cant'))
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DI')->where('leida', '=', '0')->first();
      
    $sd = DB::table('notificacion_i')->select(DB::raw('count(*) as cant'))
               ->where('importador_id', '=', session('perfilId'))
               ->where('tipo', '=', 'SD')->where('leida', '=', '0')->first();

    $solicitudes = $dp->cant + $db->cant + $di->cant + $sd->cant;

    $ad = DB::table('notificacion_i')->select(DB::raw('count(*) as cant'))
            ->where('importador_id', '=', session('perfilId'))
            ->where('tipo', '=', 'AD')->where('leida', '=', '0')->first();

    $confirmaciones = $ad->cant;

    $od = DB::table('notificacion_i')->select(DB::raw('count(*) as cant'))
            ->where('importador_id', '=', session('perfilId'))
            ->where('tipo', '=', 'NO')->where('leida', '=', '0')->first();

    $ofertas = $od->cant;
   ?>
?>

<li class="li"><a href="{{ route('importador.inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>

<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a></li>

<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a>

<li class="li">
  <a href="{{route('oferta.index')}}">
    <i class="fa fa-handshake-o"></i> Mercado
    <span class="pull-right-container">
      <small class="label pull-right bg-blue">{{$ofertas}}</small>
    </span>
  </a>
</li> 

<li class="li"><a href="{{route('solicitud-importacion.index')}}"><i class="fa fa-hand-o-up"></i> Importación</a></li>

<li class="li"><a href="{{route('demanda-distribuidor.index')}}"><i class="fa fa-user-plus"></i> Distribución</a></li>

<li class="li">
	<a href="{{route('demanda-producto.demandas-productos-disponibles')}}">
		<i class="fa fa-handshake-o"></i> Solicitudes
		<span class="pull-right-container">
			<small class="label pull-right bg-orange">{{$solicitudes}}</small>
		</span>
	</a>
</li>

<li class="li">
	<a href="{{route('importador.confirmar-distribuidores')}}">
		<i class="fa fa-check-square-o"></i> Confirmaciones
		<span class="pull-right-container">
			<small class="label pull-right bg-green">{{$confirmaciones}}</small>
		</span>
	</a>
</li>

<li class="header">Listados</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>
      