<?php 
    $paises = DB::table('pais')
        ->orderBy('pais', 'ASC')
        ->pluck('pais', 'id');

    $bebidas = DB::table('bebida')
        ->orderBy('nombre', 'ASC')
        ->pluck('nombre', 'id');
 ?>
<div class="search-box-wrapper">
    <div class="search-box container">
        <ul class="search-tabs clearfix">
            <li class="active"><a href="#marcas-tab" data-toggle="tab">MARCAS</a></li>
            <li><a href="#productos-tab" data-toggle="tab">PRODUCTOS</a></li>
        </ul>
        <div class="visible-mobile">
            <ul id="mobile-search-tabs" class="search-tabs clearfix">
                <li class="active"><a href="#hotels-tab">MARCAS</a></li>
                <li><a href="#flights-tab">PRODUCTOS</a></li>
            </ul>
        </div>
                    
        <div class="search-tab-content">
            <div class="tab-pane fade active in" id="marcas-tab">
                <form action="" method="post">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-3">
                            <h4 class="title">¿Cuál?</h4>
                            <label>Marca</label>
                            <input type="text" class="input-text full-width" placeholder="ingrese el nombre de una marca" />
                        </div>

                        <div class="form-group col-sm-6 col-md-3">
                            <h4 class="title">¿Quién?</h4>
                            <label>Productor</label>
                            <input type="text" class="input-text full-width" placeholder="ingrese el nombre de un productor" />
                        </div>
                                        
                        <div class="form-group col-sm-6 col-md-3">
                            <h4 class="title">¿Dónde?</h4>
                            <label>País</label>
                            {!! Form::select('pais_id', $paises, null, ['class' => 'input-text full-width', 'placeholder' => 'Seleccione un país..']) !!}
                        </div>
                                    
                        <div class="form-group col-sm-6 col-md-2 fixheight">
                            <label class="hidden-xs">&nbsp;</label>
                            <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1">BUSCAR AHORA</button>
                        </div>
                    </div>
                </form>
            </div>
                       
            <div class="tab-pane fade" id="productos-tab">
                <form action="" method="post">
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-2">
                            <h4 class="title">¿Cuál?</h4>
                            <label>Producto</label>
                            <input type="text" class="input-text full-width" placeholder="ingrese el nombre de un producto" />
                        </div>

                        <div class="form-group col-sm-6 col-md-2">
                            <h4 class="title">¿Qué?</h4>
                            <label>Marca</label>
                            <input type="text" class="input-text full-width" placeholder="ingrese el nombre de una marca" />
                        </div>

                        <div class="form-group col-sm-6 col-md-2">
                            <h4 class="title">¿Dónde?</h4>
                            <label>País</label>
                            {!! Form::select('pais_id', $paises, null, ['class' => 'input-text full-width', 'placeholder' => 'Seleccione un país..']) !!}
                        </div>

                        <div class="form-group col-sm-6 col-md-4">
                            <h4 class="title">¿Qué?</h4>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Bebida</label>
                                    {!! Form::select('bebida_id', $bebidas, null, ['class' => 'input-text full-width', 'placeholder' => 'Seleccione un bebida..']) !!}
                                </div>
                                <div class="col-xs-6">
                                    <label>Categoría</label>
                                    <select class="input-select full-width">
                                        <option value="">Seleccione una categoría..</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                                    
                        <div class="form-group col-sm-6 col-md-2 fixheight">
                            <label class="hidden-xs">&nbsp;</label>
                            <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1">BUSCAR AHORA</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>