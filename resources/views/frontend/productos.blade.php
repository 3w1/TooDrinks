@extends('frontend.plantillas.main')

@section('content')
    <!-- BREADCRUMBS -->
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Productos</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="{{route('frontend.index')}}">INICIO</a></li>
                <li class="active">PRODUCTOS</li>
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
                                                <label>Nombre del Producto</label>
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
                                    <a data-toggle="collapse" href="#marca-search-panel" class="collapsed">Marca</a>
                                </h4>
                                <div id="marca-search-panel" class="panel-collapse collapse">
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
                                    <a data-toggle="collapse" href="#pais-search-panel" class="collapsed">Sitio de Fabricación</a>
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

                            <div class="panel style1 arrow-right">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#bebida-search-panel" class="collapsed">Tipo de Bebida</a>
                                </h4>
                                <div id="bebida-search-panel" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Seleccione una bebida</label>
                                                {!! Form::select('bebida', $bebidas, null, ['class' => 'input-select full-width'])!!}
                                            </div>
                                            <div class="form-group">
                                                <label>Seleccione una categoría</label>
                                                <select class="input-select full-width">
                                                    <option value="0">Todas</option>
                                                </select>
                                            </div>
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

                            <div class="panel style1 arrow-right">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#price-filter" class="collapsed">Valoración</a>
                                </h4>
                                <div id="price-filter" class="panel-collapse collapse">
                                    <div class="panel-content">
                                        <div class="five-stars-container">
                                            <span class="five-stars" style="width: 80%;"></span>
                                        </div>
                                        <br />
                                        <button class="btn-medium icon-check uppercase full-width">BUSCAR</button>
                                    </div><!-- end content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-8 col-md-9">
                        <div class="sort-by-section clearfix box">
                            <h4 class="sort-by-title block-sm">Ordenar resultados por:</h4>
                            <ul class="sort-bar clearfix block-sm">
                                <li class="sort-by-name"><a class="sort-by-container" href="#"><span>Nombre</span></a></li>
                                <li class="sort-by-price"><a class="sort-by-container" href="#"><span>Marca</span></a></li>
                                <li class="sort-by-rating active"><a class="sort-by-container" href="#"><span>Valoración</span></a></li>
                            </ul>
                        </div>
                        
                        <div class="flight-list row image-box listing-style2 flight">
                            @foreach($productos as $producto)
                                <div class="col-sms-6 col-sm-6 col-md-4">
                                    <article class="box">
                                        <figure>
                                            <span><img src="{{ asset('imagenes/productos/thumbnails/')}}/{{ $producto->imagen }}" alt="" width="270" height="160" /></span>
                                        </figure>
                                        <div class="details">
                                            <a title="View all" href="{{route('frontend.producto', $producto->id)}}" class="pull-right button btn-mini uppercase">Ver Más</a>
                                            <h4 class="box-title">{{$producto->nombre}}</h4>
                                            <div class="five-stars-container">
                                                <span class="five-stars" style="width: 80%;"></span>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                        <center>{{$productos->render()}}</center>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
