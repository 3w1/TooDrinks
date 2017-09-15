<?php 
    $dp = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DP')->where('leida', '=', '0')->first();

    $db = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'DB')->where('leida', '=', '0')->first();

    $si = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'SI')->where('leida', '=', '0')->first();
      
    $sd = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
               ->where('productor_id', '=', session('perfilId'))
               ->where('tipo', '=', 'SD')->where('leida', '=', '0')->first();

    $solicitudes = $dp->cant + $db->cant + $si->cant + $sd->cant;

    $ai = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
            ->where('productor_id', '=', session('perfilId'))
            ->where('tipo', '=', 'AI')->where('leida', '=', '0')->first();

    $ad = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
            ->where('productor_id', '=', session('perfilId'))
            ->where('tipo', '=', 'AD')->where('leida', '=', '0')->first();

    $np = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
            ->where('productor_id', '=', session('perfilId'))
            ->where('tipo', '=', 'NP')->where('leida', '=', '0')->first();

    $nm = DB::table('notificacion_p')->select(DB::raw('count(*) as cant'))
            ->where('productor_id', '=', session('perfilId'))
            ->where('tipo', '=', 'NM')->where('leida', '=', '0')->first();

    $confirmaciones = $ai->cant + $ad->cant + $np->cant + $nm->cant;
   ?>
?>

<li class="li"><a href="{{ route('productor.inicio') }}"><i class="fa fa-home"></i> Inicio </a></li>

<li class="li"><a href="{{route('marca.index')}}"><i class="fa fa-diamond"></i> Marcas</a>

<li class="li"><a href="{{route('producto.index')}}"><i class="fa fa-product-hunt"></i> Productos</a></li>

<li class="li"><a href="{{route('oferta.index')}}"><i class="fa fa-shopping-cart"></i> Mercado</a></li>

<li class="li"><a href="{{route('demanda-importador.index')}}"><i class="fa fa-user-plus"></i> Exportación</a></li>

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
	<a href="{{route('productor.confirmar-importadores')}}">
		<i class="fa fa-check-square-o"></i> Confirmaciones
		<span class="pull-right-container">
			<small class="label pull-right bg-green">{{$confirmaciones}}</small>
		</span>
	</a>
</li>

<!--<li class="header">Listados</li>
<li><a href="#"><i class="fa fa-circle-o"></i> Importadores</a></li>
<li><a href="#"><i class="fa fa-circle-o"></i> Marcas</a></li>-->
