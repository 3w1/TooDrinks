@extends('frontend.plantillas.main')

@section('content')
	<!-- BREADCRUMBS -->
	<div class="page-title-container">
    	<div class="container">
        	<div class="page-title pull-left">
            	<h2 class="entry-title">Noticias</h2>
        	</div>
        	<ul class="breadcrumbs pull-right">
            	<li><a href="{{route('frontend.index')}}">INICIO</a></li>
            	<li class="active">NOTICIAS</li>
        	</ul>
    	</div>
	</div>
	<!-- FIN DEL BREADCRUMBS -->

	<section id="content">
        <div class="container block">
            <div class="row">
                <div id="main" class="col-md-9">
                	<!-- INICIO DE UNA NOTICIA -->
                    <div class="travel-story-container box">
                        <div class="travel-story-content">
                            <div class="avatar">
                                <img src="http://placehold.it/90x90" width="90" height="90" alt="">
                            </div>
                            <div class="description">
                                <h4 class="skin-color">Best Adventure Trip ever with Travelo</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's stand dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </div>
                        <div class="travel-story-meta clearfix">
                            <div class="story-meta">
                                <span class="date"><i class="soap-icon-clock"></i>11 NOV 2013</span>
                                <a class="likes button" href="#"><i class="soap-icon-heart"></i>22 Likes</a>
                                <span class="entry-tags"><i class="soap-icon-features"></i><span><a href="#">Adventure</a>, <a href="#">Romance</a></span></span>
                            </div>
                        </div>
                    </div>
                    <!-- FIN DE UNA NOTICIA -->

                    <!-- INICIO DE UNA NOTICIA -->
                    <div class="travel-story-container box">
                        <div class="travel-story-content">
                            <div class="avatar">
                                <img src="http://placehold.it/90x90" width="90" height="90" alt="">
                            </div>
                            <div class="description">
                                <h4 class="skin-color">Best Adventure Trip ever with Travelo</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's stand dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </div>
                        <div class="travel-story-meta clearfix">
                            <div class="story-meta">
                                <span class="date"><i class="soap-icon-clock"></i>11 NOV 2013</span>
                                <a class="likes button" href="#"><i class="soap-icon-heart"></i>22 Likes</a>
                                <span class="entry-tags"><i class="soap-icon-features"></i><span><a href="#">Adventure</a>, <a href="#">Romance</a></span></span>
                            </div>
                        </div>
                    </div>
                    <!-- FIN DE UNA NOTICIA -->

                    <!-- INICIO DE UNA NOTICIA -->
                    <div class="travel-story-container box">
                        <div class="travel-story-content">
                            <div class="avatar">
                                <img src="http://placehold.it/90x90" width="90" height="90" alt="">
                            </div>
                            <div class="description">
                                <h4 class="skin-color">Best Adventure Trip ever with Travelo</h4>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's stand dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </div>
                        <div class="travel-story-meta clearfix">
                            <div class="story-meta">
                                <span class="date"><i class="soap-icon-clock"></i>11 NOV 2013</span>
                                <a class="likes button" href="#"><i class="soap-icon-heart"></i>22 Likes</a>
                                <span class="entry-tags"><i class="soap-icon-features"></i><span><a href="#">Adventure</a>, <a href="#">Romance</a></span></span>
                            </div>
                        </div>
                    </div>
                    <!-- FIN DE UNA NOTICIA -->
                        
                    <a class="button btn-large full-width">CARGAR MÁS NOTICIAS</a>
                </div>
                
                <div class="sidebar col-md-3">
                    <div class="travelo-box">
                        <h5 class="box-title">Buscar Noticias</h5>
                        <div class="with-icon full-width">
                            <input type="text" class="input-text full-width" placeholder="nombre de la noticia">
                            <button class="icon green-bg white-color"><i class="soap-icon-search"></i></button>
                        </div>
                    </div>
                    
                    <div class="travelo-box filters-container">
                        <h4 class="box-title">Categorías</h4>
                        <ul class="check-square categories-filter filters-option">
                            <li><a href="#">Todas<small>(722)</small></a></li>
                            <li><a href="#">Vino<small>(982)</small></a></li>
                            <li><a href="#">Cerveza<small>(127)</small></a></li>
                            <li><a href="#">Whiskey<small>(222)</small></a></li>
                            <li><a href="#">Vodka<small>(158)</small></a></li>
                            <li><a href="#">Grappa<small>(439)</small></a></li>
                            <li><a href="#">Sake<small>(52)</small></a></li>
                        </ul>
                        <a class="button btn-mini">MÁS</a>
                    </div>
                        
                    <div class="tab-container box post-list">
                        <ul class="tabs full-width">
                            <li><a data-toggle="tab" href="#recent-posts">Reciente</a></li>
                            <li class="active"><a data-toggle="tab" href="#popular-posts">Popular</a></li>
                            <li><a data-toggle="tab" href="#new-posts">Nuevo</a></li>
                        </ul>
                        <div class="tab-content">
                        	<!-- PANEL DE NOTICIAS RECIENTES -->
                            <div id="recent-posts" class="tab-pane fade">
                                <div class="image-box style14">
                                    <article class="box">
                                        <figure><a href="#" title="" class="avatar"><img width="64" height="64" src="http://placehold.it/64x64" alt=""></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a href="#">Excellent choice</a></h5>
                                            <p>Lorem Ipsum is sim dumy text of the printing.</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <!-- FIN DEL PANEL DE NOTICIAS RECIENTES -->

                            <!-- PANEL DE NOTICIAS POPULARES -->
                            <div id="popular-posts" class="tab-pane fade in active">
                                <div class="image-box style14">
                                    <article class="box">
                                        <figure><a href="#" title="" class="avatar"><img width="64" height="64" src="http://placehold.it/64x64" alt=""></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a href="#">Excellent choice</a></h5>
                                            <p>Lorem Ipsum is sim dumy text of the printing.</p>
                                        </div>
                                    </article>

                                     <article class="box">
                                        <figure><a href="#" title="" class="avatar"><img width="64" height="64" src="http://placehold.it/64x64" alt=""></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a href="#">Excellent choice</a></h5>
                                            <p>Lorem Ipsum is sim dumy text of the printing.</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <!-- FIN DEL PANEL DE NOTICIAS POPULARES -->
                            
                            <!-- PANEL DE NOTICIAS NUEVAS -->
                            <div id="new-posts" class="tab-pane fade">
                                <div class="image-box style14">
                                    <article class="box">
                                        <figure><a href="#" title="" class="avatar"><img width="64" height="64" src="http://placehold.it/64x64" alt=""></a></figure>
                                        <div class="details">
                                            <h5 class="box-title"><a href="#">Excellent choice</a></h5>
                                            <p>Lorem Ipsum is sim dumy text of the printing.</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <!-- FIN DEL PANEL DE NOTICIAS NUEVAS -->
  						</div>
                    </div>
                        
                    <div class="travelo-box twitter-box">
                        <h4 class="box-title">Twitter Feeds</h4>
                        <div class="twitter-holder">
                            <ul>
                                <li class="tweet">
                                    <p class="tweet-text">
                                        <a href="#">@Travelo</a>, Proin feugiat mattis a sed adipiscing velit sodales.
                                    </p>
                                    <a class="tweet-date" href="http://twitter.com/">25 Minutes ago</a>
                                </li>

                                <li class="tweet">
                                    <p class="tweet-text">
                                        <a href="#">@Travelo</a>, Proin feugiat mattis a sed adipiscing velit sodales.
                                    </p>
                                    <a class="tweet-date" href="http://twitter.com/">25 Minutes ago</a>
                                </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection