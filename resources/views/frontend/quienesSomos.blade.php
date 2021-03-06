@extends('frontend.plantillas.main')

@section('content')
	<!-- BREADCRUMBS -->
	<div class="page-title-container">
    	<div class="container">
        	<div class="page-title pull-left">
            	<h2 class="entry-title">¿Quiénes Somos?</h2>
        	</div>
        	<ul class="breadcrumbs pull-right">
            	<li><a href="{{route('frontend.index')}}">INICIO</a></li>
            	<li class="active">¿QUIÉNES SOMOS?</li>
        	</ul>
    	</div>
	</div>
	<!-- FIN DEL BREADCRUMBS -->

	<section id="content">
        <div class="container">
            <div id="main">
                <div class="large-block image-box style6">
                    <article class="box">
                        <figure class="col-md-5">
                            <a href="#" title="" class="middle-block"><img class="middle-item" src="http://placehold.it/476x318" alt="" width="476" height="318" /></a>
                        </figure>
                        <div class="details col-md-offset-5">
                            <h4 class="box-title">¿Quiénes Somos?</h4>
                            <p>Vivamus a mauris vel nunc tristique volutpat. Aenean eu faucibus enim. Aenean blandit arcu lectus, in cursus elit porttitor non. Curabitur risus eros, mattis vitae nisl consequat, tincidunt commodo purus. Maecenas eu risus ac risus tempus iaculis. Duis cursus lectus sed dui imperdiet, id pharetra nunc ullamcorper. Donec luctus blandit metus, sed ultrices ipsum facilisis sit amet. Morbi congue ligula sit amet urna tincidunt.</p>
                        </div>
                    </article>
                        
                    <article class="box">
                        <figure class="col-md-5 pull-right middle-block">
                            <a href="#" title=""><img class="middle-item" src="http://placehold.it/476x318" alt="" width="476" height="318" /></a>
                        </figure>
                        <div class="details col-md-7">
                            <h4 class="box-title">¿Qué Hacemos?</h4>
                            <p>Vivamus a mauris vel nunc tristique volutpat. Aenean eu faucibus enim. Aenean blandit arcu lectus, in cursus elit porttitor non. Curabitur risus eros, mattis vitae nisl consequat, tincidunt commodo purus. Maecenas eu risus ac risus tempus iaculis. Duis cursus lectus sed dui imperdiet, id pharetra nunc ullamcorper. Donec luctus blandit metus, sed ultrices ipsum facilisis sit amet. Morbi congue ligula sit amet urna tincidunt.</p>
                        </div>
                    </article>

                    <article class="box">
                        <figure class="col-md-5">
                            <a href="#" title="" class="middle-block"><img class="middle-item" src="http://placehold.it/489x489" alt="" /></a>
                        </figure>
                        <div class="details col-md-offset-5">
                            <h4 class="box-title">¿Cómo funciona TooDrinks?</h4>
                            <p>Vivamus a mauris vel nunc tristique volutpat. Aenean eu faucibus enim. Aenean blandit arcu lectus, in cursus elit porttitor non. Curabitur risus eros, mattis vitae nisl consequat, tincidunt commodo purus. Maecenas eu risus ac risus tempus iaculis. Duis cursus lectus sed dui imperdiet, id pharetra nunc ullamcorper. Donec luctus blandit metus, sed ultrices ipsum facilisis sit amet. Morbi congue ligula sit amet urna tincidunt.</p>
                        </div>
                    </article>
                </div>

                <div class="row large-block">
                    <div class="col-md-6">
                        <h2>Conoce más acerca de nosotros</h2>
                        <div class="toggle-container box" id="accordion1">
                            <div class="panel style1">
                                <h4 class="panel-title">
                                    <a href="#acc1" data-toggle="collapse" data-parent="#accordion1">Travel Insurance Single Person</a>
                                </h4>
                                <div class="panel-collapse collapse in" id="acc1">
                                    <div class="panel-content">
                                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed pulvinar massa idend porta nequetiam elerisque mi id habitant morbi isnot possible nowadays tristique senectus et netus et malesuada fames. </p>
                                    </div><!-- end content -->
                                </div>
                            </div>
                                
                            <div class="panel style1">
                                <h4 class="panel-title">
                                    <a class="collapsed" href="#acc2" data-toggle="collapse" data-parent="#accordion1">Inflight Dinner/ Lunch Deal</a>
                                </h4>
                                <div class="panel-collapse collapse" id="acc2">
                                    <div class="panel-content">
                                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed pulvinar massa iden porta nequetiam elerisque mi id habitant morbi tristique senectus.</p>
                                    </div><!-- end content -->
                                </div>
                            </div>
                                
                            <div class="panel style1">
                                <h4 class="panel-title">
                                    <a class="collapsed" href="#acc3" data-toggle="collapse" data-parent="#accordion1">Luxury Appartment for Family</a>
                                </h4>
                                <div class="panel-collapse collapse" id="acc3">
                                    <div class="panel-content">
                                        <p>Nunc cursus libero purus ac congue ar lorem cursus ut sed pulvinar massa iden porta nequetiam elerisque mi id habitant morbi tristique senectus.</p>
                                    </div><!-- end content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h2>Nuestro Núcleo de Valores</h2>
                        <div class="tab-container">
                            <ul class="tabs">
                                <li><a href="#satisfied-customers" data-toggle="tab">Miembros Satisfechos</a></li>
                                <li class="active"><a href="#tours-suggestions" data-toggle="tab">Calidad de Servicios</a></li>
                                <li><a href="#careers" data-toggle="tab">Seguridad</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="satisfied-customers">
                                    <img src="http://placehold.it/140x140" alt="" class="pull-left" />
                                    <h4>Ocean Park Tour</h4>
                                    <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Vivamus elementum, ligula vehicula enenatis semper, magna lorem aliquet lacus, in euismod sem lectus. ligula vehicula enenatis semper, magna lorem aliquet lacus euismod sem velit ve.
									<br /><br />
									Ligula vehicula enenatis semper, magna lorem aliquet lacusin ante dapibus dictum. fugats vitaes nemo minima rerums unsers sadips amets.</p>
                                </div>
                                <div class="tab-pane fade in active" id="tours-suggestions">
                                    <img src="http://placehold.it/140x140" alt="" class="pull-left" />
                                    <h4>Ocean Park Tour</h4>
                                    <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Vivamus elementum, ligula vehicula enenatis semper, magna lorem aliquet lacus, in euismod sem lectus. ligula vehicula enenatis semper, magna lorem aliquet lacus euismod sem velit ve.
									<br /><br />
									Ligula vehicula enenatis semper, magna lorem aliquet lacusin ante dapibus dictum. fugats vitaes nemo minima rerums unsers sadips amets.</p>
                                    </div>
                                <div class="tab-pane fade" id="careers">
                                    <h4>Careers</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              	<div class="large-block">
                    <h2>Equipo de TooDrinks</h2>
                    <div class="row image-box style1 team">
                        <div class="col-sm-6 col-md-3">
                           	<article class="box">
                               	<figure>
                                   	<a href="#"><img src="http://placehold.it/270x263" alt="" width="270" height="263" /></a>
                               	</figure>
                                <div class="details">
                                    <h4 class="box-title"><a href="#">Jessica Brown<small>Chief Executive</small></a></h4>
                                    <p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam.</p>
                                    <ul class="social-icons clearfix">
                                        <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                                        <li class="googleplus"><a title="googleplus" href="#" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                                        <li class="facebook"><a title="facebook" href="#" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                                        <li class="linkedin"><a title="linkedin" href="#" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                                        <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                                        <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <article class="box">
                                <figure>
                                    <a href="#"><img src="http://placehold.it/270x263" alt="" width="270" height="263" /></a>
                                </figure>
                                <div class="details">
                                    <h4 class="box-title"><a href="#">David Jackson<small>Director - Hotels</small></a></h4>
                                    <p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam.</p>
                                    <ul class="social-icons clearfix">
                                        <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                                        <li class="googleplus"><a title="googleplus" href="#" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                                        <li class="facebook"><a title="facebook" href="#" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                                        <li class="linkedin"><a title="linkedin" href="#" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                                        <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                                        <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <article class="box">
                                <figure>
                                    <a href="#"><img src="http://placehold.it/270x263" alt="" width="270" height="263" /></a>
                                </figure>
                                <div class="details">
                                    <h4 class="box-title"><a href="#">Kyle Martin<small>Chief Operating Officer</small></a></h4>
                                    <p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam.</p>
                                    <ul class="social-icons clearfix">
                                        <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                                        <li class="googleplus"><a title="googleplus" href="#" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                                        <li class="facebook"><a title="facebook" href="#" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                                        <li class="linkedin"><a title="linkedin" href="#" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                                        <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                                        <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <article class="box">
                                <figure>
                                    <a href="#"><img src="http://placehold.it/270x263" alt="" width="270" height="263" /></a>
                                </figure>
                                <div class="details">
                                    <h4 class="box-title"><a href="#">David Robets<small>Founder &amp; Director</small></a></h4>
                                    <p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam.</p>
                                    <ul class="social-icons clearfix">
                                        <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                                        <li class="googleplus"><a title="googleplus" href="#" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                                        <li class="facebook"><a title="facebook" href="#" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                                        <li class="linkedin"><a title="linkedin" href="#" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                                        <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                                        <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
			</div>
        </div>
   	</section>
@endsection