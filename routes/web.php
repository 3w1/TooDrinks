<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//RUTAS DE INICIO Y AUTENTICACIÓN
Auth::routes();

Route::get('/home', 'UsuarioController@index')->name('dashboard');

Route::get('/', function () {
    return redirect()->action('UsuarioController@index');
});
// ./RUTAS DE INICIO Y AUTENTICACIÓN ./

//  RUTAS PARA LOS USUARIOS
Route::get('usuario/mis-productores', 'UsuarioController@ver_productores')->name('usuario.productores');
Route::get('usuario/mis-importadores', 'UsuarioController@ver_importadores')->name('usuario.importadores');
Route::get('usuario/mis-distribuidores', 'UsuarioController@ver_distribuidores')->name('usuario.distribuidores');
Route::get('usuario/mis-horecas', 'UsuarioController@ver_horecas')->name('usuario.horecas');

Route::get('usuario/registrar-productor', 'UsuarioController@registrar_productor')->name('usuario.registrar-productor');
Route::get('usuario/registrar-importador', 'UsuarioController@registrar_importador')->name('usuario.registrar-importador');
Route::get('usuario/registrar-distribuidor', 'UsuarioController@registrar_distribuidor')->name('usuario.registrar-distribuidor');
Route::get('usuario/registrar-horeca', 'UsuarioController@registrar_horeca')->name('usuario.registrar-horeca');

Route::post('usuario/updateAvatar', 'UsuarioController@updateAvatar')->name('usuario.updateAvatar');

Route::resource('usuario','UsuarioController');
// ./RUTAS PARA LOS USUARIOS./

// RUTAS PARA LOS PRODUCTORES
Route::get('productor/registrar-importador', 'ProductorController@registrar_importador')->name('productor.registrar-importador');
Route::get('productor/mis-importadores', 'ProductorController@ver_importadores')->name('productor.importadores');

Route::get('productor/registrar-distribuidor', 'ProductorController@registrar_distribuidor')->name('productor.registrar-distribuidor');
Route::get('productor/mis-distribuidores', 'ProductorController@ver_distribuidores')->name('productor.distribuidores');

Route::get('productor/registrar-marca', 'ProductorController@registrar_marca')->name('productor.registrar-marca');
Route::get('productor/mis-marcas', 'ProductorController@ver_marcas')->name('productor.marcas');

Route::get('productor/{id}-{marca}/registrar-producto', 'ProductorController@registrar_producto')->name('productor.registrar-producto');
Route::get('productor/{id}-{marca}/productos', 'ProductorController@ver_productos')->name('productor.productos');
Route::get('productor/ver-producto/{id}-{producto}', 'ProductorController@ver_detalle_producto')->name('productor.producto');

Route::get('productor/{id}-{producto}/registrar-oferta', 'ProductorController@registrar_oferta')->name('productor.registrar-oferta');
Route::get('productor/mis-ofertas', 'ProductorController@ver_ofertas')->name('productor.ofertas');
Route::get('productor/ver-oferta/{id}', 'ProductorController@ver_detalle_oferta')->name('productor.oferta');

Route::get('productor/solicitar-importador', 'ProductorController@solicitar_importador')->name('productor.solicitar-importador');
Route::get('productor/solicitar-distribuidor', 'ProductorController@solicitar_distribuidor')->name('productor.solicitar-distribuidor');

Route::post('productor/updateAvatar', 'ProductorController@updateAvatar')->name('productor.updateAvatar');
Route::resource('productor','ProductorController');
// ./RUTAS PARA LOS PRODUCTORES ./

// RUTAS PARA LOS IMPORTADORES
Route::post('importador/updateAvatar', 'ImportadorController@updateAvatar')->name('importador.updateAvatar');

Route::resource('importador','ImportadorController');
// ./RUTAS PARA LOS IMPORTADORES ./

// RUTAS PARA LOS DISTRIBUIDORES
Route::post('distribuidor/updateAvatar', 'DistribuidorController@updateAvatar')->name('distribuidor.updateAvatar');

Route::resource('distribuidor','DistribuidorController');
// ./RUTAS PARA LOS DISTRIBUIDORES ./

// RUTAS PARA LOS HORECAS
Route::post('horeca/updateAvatar', 'HorecaController@updateAvatar')->name('horeca.updateAvatar');

Route::resource('horeca','HorecaController');
// ./RUTAS PARA LOS HORECAS ./

// RUTAS PARA LAS MARCAS 
Route::get('marca/{id}/registrar-producto', 'MarcaController@registrar_producto')->name('marca.registrar-producto');

Route::resource('marca','MarcaController');
// ./RUTAS PARA LAS MARCAS ./

// RUTAS PARA LOS PRODUCTOS
Route::post('producto/updateImagen', 'ProductoController@updateImagen')->name('producto.updateImagen');

Route::resource('producto','ProductoController');
// ./RUTAS PARA LOS PRODUCTOS ./

// RUTAS PARA LAS DEMANDAS DE IMPORTADORES
Route::resource('demanda-importador','DemandaImportacionController');
// ./RUTAS PARA LAS DEMANDAS DE IMPORTADORES ./

Route::get('credito/compra','CreditoController@compra')->name('compra');

Route::resource('credito','CreditoController');

Route::resource('bebida','BebidaController');

Route::resource('oferta','OfertaController');

Route::resource('demanda-producto','DemandaProductoController');

Route::resource('demanda-distribuidor','DemandaDistribucionController');

Route::resource('suscripcion', 'SuscripcionController');

Route::resource('opinion','OpinionController');

Route::resource('pais', 'PaisController');


