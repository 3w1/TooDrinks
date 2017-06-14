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
//

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

Route::get('usuario/registrar-producto', 'UsuarioController@registrar_producto')->name('usuario.registrar-producto');
Route::get('usuario/productos', 'UsuarioController@ver_productos')->name('usuario.productos');

Route::get('usuario/productores-sin-propietario', 'UsuarioController@listado_productores')->name('usuario.productores-disponibles');
Route::get('usuario/reclamar-productor/{id}', 'UsuarioController@reclamar_productor')->name('usuario.reclamar-productor');

Route::get('usuario/importadores-sin-propietario', 'UsuarioController@listado_importadores')->name('usuario.importadores-disponibles');
Route::get('usuario/reclamar-importador/{id}', 'UsuarioController@reclamar_importador')->name('usuario.reclamar-importador');

Route::get('usuario/distribuidores-sin-propietario', 'UsuarioController@listado_distribuidores')->name('usuario.distribuidores-disponibles');
Route::get('usuario/reclamar-distribuidor/{id}', 'UsuarioController@reclamar_distribuidor')->name('usuario.reclamar-distribuidor');

Route::get('usuario/horecas-sin-propietario', 'UsuarioController@listado_horecas')->name('usuario.horecas-disponibles');
Route::get('usuario/reclamar-horeca/{id}', 'UsuarioController@reclamar_horeca')->name('usuario.reclamar-horeca');

Route::post('usuario/updateAvatar', 'UsuarioController@updateAvatar')->name('usuario.updateAvatar');

Route::resource('usuario','UsuarioController');
// ./RUTAS PARA LOS USUARIOS./

// RUTAS PARA LOS PRODUCTORES
/*Route::get('productor/registrar-importador', 'ProductorController@registrar_importador')->name('productor.registrar-importador');
Route::get('productor/mis-importadores', 'ProductorController@ver_importadores')->name('productor.importadores');

Route::get('productor/registrar-distribuidor', 'ProductorController@registrar_distribuidor')->name('productor.registrar-distribuidor');
Route::get('productor/mis-distribuidores', 'ProductorController@ver_distribuidores')->name('productor.distribuidores');
*/
Route::get('productor/registrar-marca', 'ProductorController@registrar_marca')->name('productor.registrar-marca');
Route::get('productor/mis-marcas', 'ProductorController@ver_marcas')->name('productor.marcas');
Route::get('productor/ver-marca/{id}-{marca}', 'ProductorController@ver_detalle_marca')->name('productor.marca');

Route::get('productor/{id}-{marca}/registrar-producto', 'ProductorController@registrar_producto')->name('productor.registrar-producto');
Route::get('productor/{id}-{marca}/productos', 'ProductorController@ver_productos')->name('productor.productos');
Route::get('productor/ver-producto/{id}-{producto}', 'ProductorController@ver_detalle_producto')->name('productor.producto');

Route::get('productor/{id}-{producto}/registrar-oferta', 'ProductorController@registrar_oferta')->name('productor.registrar-oferta');
Route::get('productor/mis-ofertas', 'ProductorController@ver_ofertas')->name('productor.ofertas');
Route::get('productor/ver-oferta/{id}', 'ProductorController@ver_detalle_oferta')->name('productor.oferta');

Route::get('productor/solicitar-importador', 'ProductorController@solicitar_importador')->name('productor.solicitar-importador');
Route::get('productor/mis-demandas-importadores', 'ProductorController@ver_demandas_importadores')->name('productor.demandas-importadores');
Route::get('productor/editar-demanda-importador/{id}', 'ProductorController@editar_demanda_importacion')->name('productor.editarDemandaImp');

Route::get('productor/solicitar-distribuidor', 'ProductorController@solicitar_distribuidor')->name('productor.solicitar-distribuidor');
Route::get('productor/mis-demandas-distribuidores', 'ProductorController@ver_demandas_distribuidores')->name('productor.demandas-distribuidores');
Route::get('productor/editar-demanda-distribuidor/{id}', 'ProductorController@editar_demanda_distribucion')->name('productor.editarDemandaDist');

Route::get('productor/marcas-sin-propietario', 'ProductorController@listado_marcas')->name('productor.marcas-disponibles');
Route::get('productor/reclamar-marca/{id}', 'ProductorController@reclamar_marca')->name('productor.reclamar-marca');

Route::get('productor/confirmar-importadores', 'ProductorController@confirmar_importadores')->name('productor.confirmar-importadores');
Route::post('productor/updateAvatar', 'ProductorController@updateAvatar')->name('productor.updateAvatar');
Route::resource('productor','ProductorController');
// ./RUTAS PARA LOS PRODUCTORES ./

// RUTAS PARA LOS IMPORTADORES
/*Route::get('importador/registrar-distribuidor', 'ImportadorController@registrar_distribuidor')->name('importador.registrar-distribuidor');
Route::get('importador/mis-distribuidores', 'ImportadorController@ver_distribuidores')->name('importador.distribuidores');
*/
//Route::get('importador/registrar-marca', 'ImportadorController@registrar_marca')->name('importador.registrar-marca');
Route::get('importador/mis-marcas', 'ImportadorController@mis_marcas')->name('importador.marcas');
Route::get('importador/ver-marca/{id}-{marca}', 'ImportadorController@ver_detalle_marca')->name('importador.marca');
Route::get('importador/ver-marcas-disponibles', 'ImportadorController@listado_marcas')->name('importador.marcas-disponibles');
Route::get('importador/asociar-marca/{id}', 'ImportadorController@asociar_marca')->name('importador.asociar-marca');

//Route::get('importador/{id}-{marca}/registrar-producto', 'ImportadorController@registrar_producto')->name('importador.registrar-producto');
Route::get('importador/{id}-{marca}/productos', 'ImportadorController@ver_productos')->name('importador.productos');
Route::get('importador/ver-producto/{id}-{producto}', 'ImportadorController@ver_detalle_producto')->name('importador.producto');

Route::get('importador/{id}-{producto}/registrar-oferta', 'ImportadorController@registrar_oferta')->name('importador.registrar-oferta');
Route::get('importador/mis-ofertas', 'ImportadorController@mis_ofertas')->name('importador.ofertas');
Route::get('importador/ver-oferta/{id}', 'ImportadorController@ver_detalle_oferta')->name('importador.oferta');
Route::get('importador/ver-ofertas-disponibles', 'ImportadorController@listado_ofertas')->name('importador.ofertas-disponibles');

Route::post('importador/updateAvatar', 'ImportadorController@updateAvatar')->name('importador.updateAvatar');

Route::resource('importador','ImportadorController');
// ./RUTAS PARA LOS IMPORTADORES ./

// RUTAS PARA LOS DISTRIBUIDORES
Route::get('distribuidor/registrar-marca', 'DistribuidorController@registrar_marca')->name('distribuidor.registrar-marca');
Route::get('distribuidor/mis-marcas', 'DistribuidorController@ver_marcas')->name('distribuidor.marcas');
Route::get('distribuidor/ver-marca/{id}-{marca}', 'DistribuidorController@ver_detalle_marca')->name('distribuidor.marca');

Route::get('distribuidor/{id}-{marca}/registrar-producto', 'DistribuidorController@registrar_producto')->name('distribuidor.registrar-producto');
Route::get('distribuidor/{id}-{marca}/productos', 'DistribuidorController@ver_productos')->name('distribuidor.productos');
Route::get('distribuidor/ver-producto/{id}-{producto}', 'DistribuidorController@ver_detalle_producto')->name('distribuidor.producto');

Route::get('distribuidor/{id}-{producto}/registrar-oferta', 'DistribuidorController@registrar_oferta')->name('distribuidor.registrar-oferta');
Route::get('distribuidor/mis-ofertas', 'DistribuidorController@mis_ofertas')->name('distribuidor.ofertas');
Route::get('distribuidor/ver-oferta/{id}', 'DistribuidorController@ver_detalle_oferta')->name('distribuidor.oferta');
Route::get('distribuidor/ver-ofertas-disponibles', 'DistribuidorController@listado_ofertas')->name('distribuidor.ofertas-disponibles');

Route::post('distribuidor/updateAvatar', 'DistribuidorController@updateAvatar')->name('distribuidor.updateAvatar');

Route::resource('distribuidor','DistribuidorController');
// ./RUTAS PARA LOS DISTRIBUIDORES ./

// RUTAS PARA LOS HORECAS
Route::post('horeca/updateAvatar', 'HorecaController@updateAvatar')->name('horeca.updateAvatar');

Route::resource('horeca','HorecaController');
// ./RUTAS PARA LOS HORECAS ./

// RUTAS PARA LAS MARCAS 
Route::get('marca/{id}/registrar-producto', 'MarcaController@registrar_producto')->name('marca.registrar-producto');

Route::post('marca/cambiar-logo', 'MarcaController@updateLogo')->name('marca.updateLogo');

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

Route::resource('mails', 'MailsController');

Route::get('registrarse/{tipo}${id}${token}', 'Auth\RegisterController@registrarse');
Route::get('confirmar-correo/{id}${token}', 'UsuarioController@confirmar_correo');


