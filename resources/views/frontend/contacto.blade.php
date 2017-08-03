@extends('frontend.plantillas.main')

@section('content')

    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">CONTÁCTANOS</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="#">INICIO</a></li>
                <li class="active">CONTACTO</li>
            </ul>
        </div>
    </div>

    <section id="content">
        <div class="container">
            <div id="main">
                <div class="travelo-google-map block"></div>
                <div class="contact-address row block">
                    <div class="col-md-4">
                        <div class="icon-box style5">
                            <i class="soap-icon-phone"></i>
                            <div class="description">
                                <small>Atención 24/7</small>
                                <h5>Local: 1-800-123-TOODRINKS</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box style5">
                            <i class="soap-icon-message"></i>
                            <div class="description">
                                <small>Envíanos un correo</small>
                                <h5>contacto@toodrinks.com</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box style5">
                            <i class="soap-icon-address"></i>
                            <div class="description">
                                <small>Visítanos</small>
                                <h5>USA, P.O Box, 353 Three Avenue</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="travelo-box box-full">
                    <div class="contact-form">
                        <h2>Déjanos un mensaje</h2>
                        <form class="contact-form" action="contact-us-handler.php" method="post" onsubmit="return false;">
                            <div class="alert small-box" style="display: none;"></div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tu Nombre</label>
                                        <input type="text" name="name" class="input-text full-width">
                                    </div>
                                    <div class="form-group">
                                        <label>Tu Correo</label>
                                        <input type="text" name="email" class="input-text full-width">
                                    </div>
                                    <div class="form-group">
                                        <label>Asunto</label>
                                        <input type="text" name="subject" class="input-text full-width">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Tu Mensaje</label>
                                        <textarea name="message" rows="11" class="input-text full-width" placeholder="escribe el mensaje aquí"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sms-offset-6 col-sm-offset-6 col-md-offset-8 col-lg-offset-9">
                                <button type="submit" class="btn-medium full-width">ENVIAR MENSAJE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection