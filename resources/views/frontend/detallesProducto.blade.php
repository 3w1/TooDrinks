@extends('frontend.plantillas.main')

@section('content')
    
    <!-- BREADCRUMBS -->
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Producto</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="{{route('frontend.index')}}">INICIO</a></li>
                <li><a href="{{route('frontend.marcas')}}">PRODUCTOS</a></li>
                <li class="active">{{$producto->nombre}}</li>
            </ul>
        </div>
    </div>
    <!-- FIN DEL BREADCRUMBS -->

    <section id="content" class="gray-area">
        <div class="container car-detail-page">
            <div class="row">
                <div id="main" class="col-md-9">
                    <div class="featured-image box">
                        <img src="{{ asset('imagenes/productos/thumbnails/')}}/{{ $producto->imagen }}" alt="" />
                    </div>
                    <div class="tab-container">
                        <ul class="tabs">
                            <li class="active">
                                <a href="#marca-details" data-toggle="tab">Detalles del Producto</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="marca-details">
                                <div class="intro box table-wrapper full-width hidden-table-sms">
                                    <div class="col-sm-12 table-cell travelo-box">
                                        <dl class="term-description">
                                            <dt>Nombre SEO:</dt><dd>{{$producto->nombre_seo}}</dd>
                                            <dt>Marca:</dt><dd>{{$producto->marca->nombre}}</dd>
                                            <dt>bebida:</dt><dd>{{$producto->bebida->nombre}} <small>({{$producto->clase_bebida->clase}}</small> </dd>
                                            <dt>País Originario:</dt><dd>{{$producto->pais->pais}}</dd>
                                            <dt>Año de Producción:</dt><dd>{{$producto->ano_produccion}}</dd>
                                        </dl>
                                    </div>
                                </div>
                                <h2>Descripción del Producto</h2>
                                <p>{{$producto->descripcion}}</p>
                                <br />
                            </div>   
                        </div>
                    </div>
                </div>
                
                <div class="sidebar col-md-3">
                    <div class="travelo-box">
                        <h4>Productos Similares</h4>
                        <div class="image-box style14">
                            @foreach($productos as $p)
                                <article class="box">
                                    <figure>
                                        <a href="#"><img src="{{ asset('imagenes/productos/thumbnails/')}}/{{ $p->imagen }}" alt="" /></a>
                                    </figure>
                                    <div class="details">
                                        <h5 class="box-title"><a href="{{route('frontend.producto', $p->id)}}">{{$p->nombre}}</a></h5>
                                        <div class="five-stars-container pull-right">
                                            <span class="five-stars" style="width: 80%;"></span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

