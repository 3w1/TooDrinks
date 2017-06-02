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
Route::get('usuario/{id}/mis-productores', 'UsuarioController@ver_productores')->name('usuario.productores');
Route::get('usuario/{id}/mis-importadores', 'UsuarioController@ver_importadores')->name('usuario.importadores');
Route::get('usuario/{id}/mis-distribuidores', 'UsuarioController@ver_distribuidores')->name('usuario.distribuidores');
Route::get('usuario/{id}/mis-horecas', 'UsuarioController@ver_horecas')->name('usuario.horecas');

Route::get('usuario/registrar-productor', 'UsuarioController@registrar_productor')->name('usuario.registrar-productor');
Route::get('usuario/registrar-importador', 'UsuarioController@registrar_importador')->name('usuario.registrar-importador');
Route::get('usuario/registrar-distribuidor', 'UsuarioController@registrar_distribuidor')->name('usuario.registrar-distribuidor');
Route::get('usuario/registrar-horeca', 'UsuarioController@registrar_horeca')->name('usuario.registrar-horeca');

Route::post('usuario/updateAvatar', 'UsuarioController@updateAvatar')->name('usuario.updateAvatar');

Route::resource('usuario','UsuarioController');

// ./RUTAS PARA LOS USUARIOS./

// RUTAS PARA LOS PRODUCTORES
Route::post('productor/updateAvatar', 'ProductorController@updateAvatar')->name('productor.updateAvatar');

Route::get('productor/registrar-distribuidor', 'ProductorController@registrar_distribuidor')->name('productor.registrar-distribuidor');
Route::get('productor/registrar-importador', 'ProductorController@registrar_importador')->name('productor.registrar-importador');

Route::get('productor/mis-importadores', 'ProductorController@ver_importadores')->name('productor.importadores');
Route::get('productor/mis-distribuidores', 'ProductorController@ver_distribuidores')->name('productor.distribuidores');

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

Route::get('credito/compra','CreditoController@compra')->name('compra');

Route::resource('producto','ProductoController');

Route::resource('marca','MarcaController');

Route::resource('credito','CreditoController');

Route::resource('bebida','BebidaController');

Route::resource('oferta','OfertaController');

Route::resource('demanda-producto','DemandaProductoController');

Route::resource('demanda-importador','DemandaImportacionController');

Route::resource('demanda-distribuidor','DemandaDistribucionController');

Route::resource('suscripcion', 'SuscripcionController');

Route::resource('opinion','OpinionController');


