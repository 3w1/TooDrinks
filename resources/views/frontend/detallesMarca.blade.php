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
                <li><a href="{{route('frontend.marcas')}}">MARCAS</a></li>
                <li class="active">{{$marca->nombre}}</li>
            </ul>
        </div>
    </div>
    <!-- FIN DEL BREADCRUMBS -->

    <section id="content" class="gray-area">
        <div class="container car-detail-page">
            <div class="row">
                <div id="main" class="col-md-9">
                    <div class="featured-image box">
                        <img src="{{ asset('imagenes/marcas/thumbnails/')}}/{{ $marca->logo }}" alt="" />
                    </div>
                    <div class="tab-container">
                        <ul class="tabs">
                            <li class="active">
                                <a href="#marca-details" data-toggle="tab">Detalles de la Marca</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="marca-details">
                                <div class="intro box table-wrapper full-width hidden-table-sms">
                                    <div class="col-sm-12 table-cell travelo-box">
                                        <dl class="term-description">
                                            <dt>Nombre SEO:</dt><dd>{{$marca->nombre_seo}}</dd>
                                            <dt>Productor:</dt><dd>{{$marca->productor->nombre}}</dd>
                                            <dt>País:</dt><dd>{{$marca->pais->pais}}</dd>
                                            <dt>Sitio Web:</dt><dd>{{$marca->website}}</dd>
                                        </dl>
                                    </div>
                                </div>
                                <h2>Descripción de la Marca</h2>
                                <p>{{$marca->descripcion}}</p>
                                <br />
                                <div class="car-features box">
                                    <div class="row add-clearfix">
                                        <div class="col-sms-6 col-sm-6 col-md-4">
                                            <span class="icon-box style2">
                                                <i class="soap-icon-user circle"></i>{{$cont}} Productos
                                            </span>
                                        </div>
                                        <div class="col-sms-6 col-sm-6 col-md-4">
                                            <span class="icon-box style2">
                                                <i class="soap-icon-suitcase circle"></i>2 Demandas
                                            </span>
                                        </div>
                                        <div class="col-sms-6 col-sm-6 col-md-4">
                                            <span class="icon-box style2">
                                                <i class="soap-icon-aircon circle"></i>5 Solicitudes
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
                
                <div class="sidebar col-md-3">
                    @foreach ($productos as $producto)
                        <article class="detailed-logo">
                            <figure>
                                <img width="114" height="85" src="{{ asset('imagenes/productos/thumbnails/')}}/{{ $producto->imagen }}" alt="">
                            </figure>
                            <div class="details">
                                <h2 class="box-title">{{$producto->nombre}}</h2>
                                <span class="price clearfix">
                                    <small class="pull-left">Valoración</small>
                                    <div class="five-stars-container pull-right">
                                        <span class="five-stars" style="width: 80%;"></span>
                                    </div>
                                </span>
                                <div class="mile clearfix">
                                    <span class="skin-color">Bebida:</span>
                                    <span class="mileage pull-right"><strong>{{$producto->bebida->nombre}}</strong> <small>({{$producto->clase_bebida->clase}})</small></span>
                                </div>
                                <a class="button yellow full-width uppercase btn-small" href="#">Ver Producto</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

