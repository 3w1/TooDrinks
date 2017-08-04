@extends('frontend.plantillas.main')

@section('content') 
    <!-- BREADCRUMBS -->
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Marcas</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="{{route('frontend.index')}}">INICIO</a></li>
                <li class="active">MARCAS</li>
            </ul>
        </div>
    </div>
    <!-- FIN DEL BREADCRUMBS -->
        
    <section id="content">
        <div class="container">
            <div id="main">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <h4 class="search-results-title"><i class="soap-icon-search"></i><b>1,984</b> resultados.</h4>

                        <div class="toggle-container filters-container">
                            <div class="panel style1 arrow-right">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#nombre-search-panel" class="collapsed">Nombre</a>
                                </h4>
                                <div id="nombre-search-panel" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Nombre de la Marca</label>
                                                <input type="text" class="input-text full-width" placeholder="" />
                                            </div>
                                            <br />
                                            <button class="btn-medium icon-check uppercase full-width">BUSCAR</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="panel style1 arrow-right">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#productor-search-panel" class="collapsed">Productor</a>
                                </h4>
                                <div id="productor-search-panel" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Nombre del Productor</label>
                                                <input type="text" class="input-text full-width" placeholder="" />
                                            </div>
                                            <br />
                                            <button class="btn-medium icon-check uppercase full-width">BUSCAR</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="panel style1 arrow-right">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#pais-search-panel" class="collapsed">País</a>
                                </h4>
                                <div id="pais-search-panel" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Seleccione un país</label>
                                                {!! Form::select('pais', $paises, null, ['class' => 'input-select full-width'])!!}
                                            </div>
                                            <br />
                                            <button class="btn-medium icon-check uppercase full-width">BUSCAR</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-sm-8 col-md-9">
                        <div class="sort-by-section clearfix">
                            <h4 class="sort-by-title block-sm">Ordenar resultados por:</h4>
                            <ul class="sort-bar clearfix block-sm">
                                <li class="sort-by-name"><a class="sort-by-container" href="#"><span>Nombre</span></a></li>
                                <li class="sort-by-price"><a class="sort-by-container" href="#"><span>País</span></a></li>
                                <li class="clearer visible-sms"></li>
                                <li class="sort-by-rating active"><a class="sort-by-container" href="#"><span>Productor</span></a></li>
                            </ul>
                        </div>
                        
                        <div class="hotel-list listing-style3 hotel">
                            @foreach ($marcas as $marca)
                                <?php 
                                    $cont = 0;
                                    $productos = DB::table('producto')
                                                ->select('id')
                                                ->where('marca_id', '=', $marca->id)
                                                ->get();

                                    foreach ($productos as $producto)
                                        $cont++;
                                 ?>
                                <!-- INICIO DE UNA MARCA -->
                                <article class="box">
                                    <figure class="col-sm-5 col-md-4">
                                        <a class=""><img width="270" height="160" alt="" src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}"></a>
                                    </figure>
                                    <div class="details col-sm-7 col-md-8">
                                        <div>
                                            <div>
                                                <h4 class="box-title">{{$marca->nombre}}<small><i class="soap-icon-departure yellow-color"></i> {{$marca->pais->pais}}</small></h4>
                                            </div>
                                            <div>
                                                <div class="five-stars-container">
                                                    <span class="five-stars" style="width: 80%;"></span>
                                                </div>
                                                <span class="review">270 Demandas</span>
                                            </div>
                                        </div>
                                        <div>
                                            <p>{{$marca->descripcion}}</p>
                                            <div>
                                                <span class="price"><small>PRODUCTOS</small>{{$cont}}</span>
                                                <a class="button btn-small full-width text-center" title="" href="{{route('frontend.marca', $marca->id)}}">VER MÁS</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <!-- FIN DE UNA MARCA -->
                            @endforeach
                        </div>
                        <center>{{$marcas->render()}}</center>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
