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

Route::get('registrarse/{tipo}${id}${token}', 'Auth\RegisterController@registrarse')->name('registrarse');
// ./RUTAS DE INICIO Y AUTENTICACIÓN ./

//  RUTAS PARA LOS USUARIOS
Route::get('confirmar-correo/{id}${token}', 'UsuarioController@confirmar_correo');

Route::post('usuario/cambiar-perfil', 'UsuarioController@cambiar_perfil')->name('usuario.cambiar-perfil');
Route::get('usuario/inicio', 'UsuarioController@inicio')->name('usuario.inicio');

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
Route::get('productor/marcas-sin-propietario', 'ProductorController@listado_marcas')->name('productor.marcas-disponibles');
Route::get('productor/reclamar-marca/{id}', 'ProductorController@reclamar_marca')->name('productor.reclamar-marca');

Route::get('productor/confirmar-importadores', 'ProductorController@confirmar_importadores')->name('productor.confirmar-importadores');
Route::get('productor/confirmar-importador/{id}-{tipo}-{imp}', 'ProductorController@confirmar_importador')->name('productor.confirmar-importador');

Route::get('productor/confirmar-distribuidores', 'ProductorController@confirmar_distribuidores')->name('productor.confirmar-distribuidores');
Route::get('productor/confirmar-distribuidor/{id}-{tipo}-{dist}', 'ProductorController@confirmar_distribuidor')->name('productor.confirmar-distribuidor');

Route::get('productor/confirmar-productos', 'ProductorController@confirmar_productos')->name('productor.confirmar-productos');
Route::get('productor/confirmar-producto/{id}-{tipo}', 'ProductorController@confirmar_producto')->name('productor.confirmar-producto');

Route::get('productor/ver-listado-importadores', 'ProductorController@listado_importadores')->name('productor.listado-importadores');

Route::get('productor/seleccionar-paises', 'ProductorController@listado_paises')->name('productor.paises');
Route::post('productor/guardar-paises', 'ProductorController@guardar_paises')->name('productor.guardar-paises');

Route::post('productor/updateAvatar', 'ProductorController@updateAvatar')->name('productor.updateAvatar');
Route::resource('productor','ProductorController');
// ./RUTAS PARA LOS PRODUCTORES ./

// RUTAS PARA LOS IMPORTADORES
Route::get('importador/ver-marcas-disponibles', 'ImportadorController@listado_marcas')->name('importador.marcas-disponibles');
Route::get('importador/asociar-marca/{id}', 'ImportadorController@asociar_marca')->name('importador.asociar-marca');

Route::get('importador/ver-ofertas-disponibles', 'ImportadorController@listado_ofertas')->name('importador.ofertas-disponibles');

Route::get('importador/ver-listado-distribuidores', 'ImportadorController@listado_distribuidores')->name('importador.listado-distribuidores');

Route::post('importador/updateAvatar', 'ImportadorController@updateAvatar')->name('importador.updateAvatar');

Route::resource('importador','ImportadorController');
// ./RUTAS PARA LOS IMPORTADORES ./

// RUTAS PARA LOS DISTRIBUIDORES
Route::get('distribuidor/ver-marcas-disponibles', 'DistribuidorController@listado_marcas')->name('distribuidor.marcas-disponibles');
Route::get('distribuidor/asociar-marca/{id}', 'DistribuidorController@asociar_marca')->name('distribuidor.asociar-marca');

Route::get('distribuidor/ver-ofertas-disponibles', 'DistribuidorController@listado_ofertas')->name('distribuidor.ofertas-disponibles');

Route::post('distribuidor/updateAvatar', 'DistribuidorController@updateAvatar')->name('distribuidor.updateAvatar');

Route::resource('distribuidor','DistribuidorController');
// ./RUTAS PARA LOS DISTRIBUIDORES ./

// RUTAS PARA LOS HORECAS
Route::get('horeca/ver-ofertas-disponibles', 'HorecaController@listado_ofertas')->name('horeca.ofertas-disponibles');

Route::post('horeca/updateAvatar', 'HorecaController@updateAvatar')->name('horeca.updateAvatar');

Route::resource('horeca','HorecaController');
// ./RUTAS PARA LOS HORECAS ./

// RUTAS PARA LAS MARCAS 
Route::get('marca/descripcion/{id}', 'MarcaController@descripcion')->name('marca.descripcion');

Route::post('marca/cambiar-logo', 'MarcaController@updateLogo')->name('marca.updateLogo');

Route::resource('marca','MarcaController');
// ./RUTAS PARA LAS MARCAS ./

// RUTAS PARA LAS BEBIDAS
Route::resource('bebida','BebidaController');
// ./RUTAS PARA LAS BEBIDAS ./

// RUTAS PARA LOS PRODUCTOS
Route::get('producto/agregar/{id}-{marca}', 'ProductoController@agregar')->name('producto.agregar');
Route::get('producto/listado-de-productos/{id}-{marca}', 'ProductoController@listado')->name('producto.listado');
Route::get('producto/detalle-de-producto/{id}', 'ProductoController@detalle')->name('producto.detalle');

Route::get('producto/seleccionar-productos/{id}', 'ProductoController@seleccionar_productos')->name('producto.seleccionar');
Route::post('producto/asociar-productos', 'ProductoController@asociar_productos')->name('producto.asociar-productos');
Route::get('producto/verificar-producto/{id}', 'ProductoController@verificar_producto');

Route::post('producto/updateImagen', 'ProductoController@updateImagen')->name('producto.updateImagen');
Route::resource('producto','ProductoController');
// ./RUTAS PARA LOS PRODUCTOS ./

// RUTAS PARA LAS OFERTAS
Route::prefix('oferta')->group(function () {
    Route::get('{id}-{producto}/crear-oferta', 'OfertaController@crear_oferta')->name('oferta.crear-oferta');
    
    Route::get('ofertas-disponibles', 'OfertaController@ofertas_disponibles')->name('oferta.disponibles');
    Route::get('ver-detalle-oferta/{id}', 'OfertaController@detalle_oferta')->name('oferta.detalle');
    Route::get('marcar-oferta/{id}', 'OfertaController@marcar_oferta')->name('oferta.marcar');

    Route::get('cambiar-status/{id}', 'OfertaController@cambiar_status')->name('oferta.status');
});
Route::resource('oferta','OfertaController');
// ./RUTAS PARA LAS OFERTAS ./

// RUTAS PARA LAS DEMANDAS DE IMPORTADORES
Route::prefix('demanda-importador')->group(function () {
    Route::get('demandas-disponibles', 'DemandaImportacionController@demandas_disponibles')
    ->name('demanda-importador.demandas-disponibles');

    Route::get('marcar-demanda/{id}', 'DemandaImportacionController@marcar_demanda')->name('demanda-importador.marcar');
});
Route::resource('demanda-importador','DemandaImportacionController');
// ./RUTAS PARA LAS DEMANDAS DE IMPORTADORES ./

// RUTAS PARA LAS DEMANDAS DE DISTRIBUIDORES
Route::prefix('demanda-distribuidor')->group(function () {
    Route::get('demandas-disponibles', 'DemandaDistribucionController@demandas_disponibles')
    ->name('demanda-distribuidor.demandas-disponibles');

     Route::get('marcar-demanda/{id}', 'DemandaDistribucionController@marcar_demanda')->name('demanda-distribuidor.marcar');
});
Route::resource('demanda-distribuidor','DemandaDistribucionController');
// ./RUTAS PARA LAS DEMANDAS DE DISTRIBUIDORES ./

// RUTAS PARA LAS DEMANDAS DE PRODUCTOS 
Route::prefix('demanda-producto')->group(function () {
    Route::get('demandas-productos-disponibles', 'DemandaProductoController@demandas_productos_disponibles')
    ->name('demanda-producto.demandas-productos-disponibles');

    Route::get('demandas-bebidas-disponibles', 'DemandaProductoController@demandas_bebidas_disponibles')
    ->name('demanda-producto.demandas-bebidas-disponibles');

    Route::get('marcar-demanda/{id}', 'DemandaProductoController@marcar_demanda')->name('demanda-producto.marcar');
});
Route::resource('demanda-producto','DemandaProductoController');
// ./RUTAS PARA LAS DEMANDAS DE PRODUCTOS ./

// RUTAS PARA LAS DEMANDAS DE IMPORTACIÓN
Route::prefix('solicitar-importacion')->group(function () {
    Route::get('marcar-solicitud/{id}', 'SolicitudImportacionController@marcar_solicitud')->name('solicitar-importacion.marcar');
});
Route::get('demandas-importacion', 'SolicitudImportacionController@demandas_importacion')->name('demandas-importacion');
Route::resource('solicitar-importacion', 'SolicitudImportacionController');
// ./RUTAS PARA LAS DEMANDAS DE IMPORTACIÓN ./

// RUTAS PARA LAS DEMANDAS DE DISTRIBUCIÓN
Route::prefix('solicitar-distribucion')->group(function () {
    Route::get('marcar-solicitud/{id}', 'SolicitudDistribucionController@marcar_solicitud')->name('solicitar-distribucion.marcar');
});
Route::get('demandas-distribucion', 'SolicitudDistribucionController@demandas_distribucion')->name('demandas-distribucion');
Route::resource('solicitar-distribucion', 'SolicitudDistribucionController');
// ./RUTAS PARA LAS DEMANDAS DE DISTRIBUCIÓN ./

// RUTAS PARA LOS CRÉDITOS
Route::prefix('credito')->group(function () {
    Route::get('compra/{id}','CreditoController@compra')->name('credito.compra');
    Route::get('historial-de-planes', 'CreditoController@historial_planes')->name('credito.historial-planes');
    Route::get('generar_factura/{id}','CreditoController@generar_factura')->name('credito.generar-factura');

    Route::get('historial-de-gastos', 'CreditoController@historial_gastos')->name('credito.historial-gastos');
    Route::get('detalles-gasto/{tipo}/{id}', 'CreditoController@detalles_gasto');

    Route::get('gastar-creditos-co/{cant}/{id}', 'CreditoController@gastar_creditos_CO')->name('credito.gastar-creditos-co');
    Route::get('gastar-creditos-di/{cant}/{id}', 'CreditoController@gastar_creditos_DI')->name('credito.gastar-creditos-di');
    Route::get('gastar-creditos-dd/{cant}/{id}', 'CreditoController@gastar_creditos_DD')->name('credito.gastar-creditos-dd');
    Route::get('gastar-creditos-dp/{cant}/{id}', 'CreditoController@gastar_creditos_DP')->name('credito.gastar-creditos-dp');
    Route::get('gastar-creditos-db/{cant}/{id}', 'CreditoController@gastar_creditos_DB')->name('credito.gastar-creditos-db');
    Route::get('gastar-creditos-dip/{cant}/{id}', 'CreditoController@gastar_creditos_DIP')->name('credito.gastar-creditos-dip');
    Route::get('gastar-creditos-ddp/{cant}/{id}', 'CreditoController@gastar_creditos_DDP')->name('credito.gastar-creditos-ddp');
});
Route::resource('credito','CreditoController');
// ./RUTAS PARA LOS CRÉDITOS ./

// RUTAS PARA LAS NOTIFICACIONES
Route::get('notificacion/notificar-productor/{tipo}/{descripcion}/{id}', 'NotificacionController@notificar_p')
->name('notificar_p');

Route::get('notifiacion/marcar-leida/{id}', 'NotificacionController@marcar_leida')
->name('notificacion.leida');

Route::resource('notificacion', 'NotificacionController');
// ./RUTAS PARA LAS NOTIFICACIONES ./

// RUTAS PARA LAS SUSCRIPCIONES
Route::resource('suscripcion', 'SuscripcionController');
// ./RUTAS PARA LAS SUSCRIPCIONES ./

// RUTAS PARA LAS OPINIONES
Route::resource('opinion','OpinionController');
// ./RUTAS PARA LAS OPINIONES ./

//RUTAS PARA LOS BANNERS
Route::prefix('banner-publicitario')->group(function () {
    Route::post('cambiar-imagen', 'BannerController@updateImagen')->name('banner-publicitario.updateImagen');
    Route::get('detalles/{id}', 'BannerController@detalles')->name('banner-publicitario.detalles');

    Route::get('solicitar-publicacion/{id}', 'BannerController@solicitar_publicacion')
    ->name('banner-publicitario.solicitar-publicacion');
    Route::get('consultar-disponibilidad/{pais}/{dias}', 'BannerController@consultar_disponibilidad')
    ->name('banner-publicitario.consultar-disponibilidad');
    Route::post('guardar-solicitud', 'BannerController@guardar_solicitud')
    ->name('banner-publicitario.guardar-solicitud');
    Route::get('confirmar-solicitud/{id}', 'BannerController@confirmar_solicitud')
    ->name('banner-publicitario.confirmar-solicitud');    
    Route::get('confirmar-pago/{id}', 'BannerController@confirmar_pago')->name('banner-publicitario.confirmar-pago');    

    Route::get('mis-publicidades', 'BannerController@mis_publicidades')
    ->name('banner-publicitario.publicidades');
    Route::get('detalle-publicacion/{id}', 'BannerController@detalle_publicacion')
    ->name('banner-publicitario.detalle-publicacion');
    Route::get('corregir-solicitud/{id}', 'BannerController@corregir_solicitud')
    ->name('banner-publicitario.corregir-solicitud');

    Route::get('cargar-correcciones/{id}', 'BannerController@cargar_correcciones')
    ->name('banner-publicitario.cargar-correcciones');
});
Route::resource('banner-publicitario', 'BannerController');
// ./RUTAS PARA LOS BANNERS ./

// RUTAS PARA LOS PAISES
Route::get('pais/paises-destino', 'PaisController@paises_destino');
Route::resource('pais', 'PaisController');
// ./RUTAS PARA LOS PAISES ./

// RUTAS PARA LOS MAILS
Route::get('notificaciones_productor', 'MailsController@notificaciones_productor')->name('mails.notificaciones-p');
Route::get('notificaciones_importador', 'MailsController@notificaciones_importador')->name('mails.notificaciones-i');
Route::get('notificaciones_distribuidor', 'MailsController@notificaciones_distribuidor')->name('mails.notificaciones-d');

Route::post('correo-invitacion', 'MailsController@correo_invitacion')->name('mails.invitacion');

Route::resource('mails', 'MailsController');
// ./RUTAS PARA LOS MAILS ./

// RUTAS PARA EL ADMIN WEB
Route::prefix('admin')->group(function () {
    Route::get('marcas-sin-aprobar', 'AdminController@marcas_sin_aprobar')->name('admin.marcas-sin-aprobar');
    Route::get('aprobar-marca/{id}', 'AdminController@aprobar_marca')->name('admin.aprobar-marca');
    Route::get('rechazar-marca/{id}', 'AdminController@rechazar_marca')->name('admin.rechazar-marca');

    Route::get('productos-sin-aprobar', 'AdminController@productos_sin_aprobar')->name('admin.productos-sin-aprobar');
    Route::get('aprobar-producto/{id}', 'AdminController@aprobar_producto')->name('admin.aprobar-producto');
    Route::get('rechazar-producto/{id}', 'AdminController@rechazar_producto')->name('admin.rechazar-producto');

    Route::get('marcas-sin-propietario', 'AdminController@marcas_sin_propietario')->name('admin.marcas-sin-propietario');
    Route::post('asociar-marca-productor', 'AdminController@asociar_marca_productor')->name('admin.asociar-marca-productor');

    Route::get('confirmar-importadores-marcas', 'AdminController@confirmar_importadores')->name('admin.confirmar-importadores');
    Route::get('confirmar-importador-marca/{id}/{tipo}', 'AdminController@confirmar_importador')->name('admin.confirmar-importador');

   	Route::get('confirmar-distribuidores-marcas', 'AdminController@confirmar_distribuidores')->name('admin.confirmar-distribuidores');
    Route::get('confirmar-distribuidor-marca/{id}/{tipo}', 'AdminController@confirmar_distribuidor')->name('admin.confirmar-distribuidor');

    Route::get('marcas', 'MarcaController@index')->name('admin.marcas');
    Route::get('crear-marca', 'MarcaController@create')->name('admin.crear-marca');
    Route::get('detalle-de-marca/{id}', 'MarcaController@show')->name('admin.detalle-marca');

    Route::get('productos', 'ProductoController@index')->name('admin.productos');
    Route::get('crear-producto', 'ProductoController@create')->name('admin.crear-producto');
    Route::get('crear-producto/{id}/{marca}', 'ProductoController@agregar')->name('admin.crear-producto-marca');
	Route::get('detalle-de-producto/{id}', 'ProductoController@detalle')->name('admin.detalle-producto');
	Route::get('catalogo-de-productos/{id}/{marca}', 'ProductoController@listado')->name('admin.productos-marca');

	Route::get('crear-productor', 'ProductorController@create')->name('admin.crear-productor');
	Route::get('crear-importador', 'ImportadorController@create')->name('admin.crear-importador');
	Route::get('crear-distribuidor', 'DistribuidorController@create')->name('admin.crear-distribuidor');
	Route::get('crear-horeca', 'HorecaController@create')->name('admin.crear-horeca');

    Route::get('banners-sin-aprobar', 'AdminController@banners_sin_aprobar')->name('admin.banners-sin-aprobar');
    Route::get('aprobar-banner/{id}', 'AdminController@aprobar_banner')->name('admin.aprobar-banner');
    Route::get('sugerir-correcciones-banner/{id}', 'AdminController@sugerir_correcciones_banner')
    ->name('admin.sugerir-correcciones-banner');
    Route::post('guardar-sugerencias', 'AdminController@guardar_sugerencias_banner')->name('admin.guardar-sugerencias-banner');
    Route::get('banners-sin-publicar', 'AdminController@banners_sin_publicar')->name('admin.banners-sin-publicar');
    Route::get('asignar-fechas/{id}', 'AdminController@asignar_fecha')->name('admin.asignar-fechas');
     Route::post('guardar-fechas', 'AdminController@guardar_fechas')->name('admin.guardar-fechas');

	Route::get('listado-de-suscripciones', 'SuscripcionController@index')->name('admin.suscripciones');

	Route::get('listado-de-planes-de-credito', 'CreditoController@index')->name('admin.creditos');
	Route::get('modificar-plan-de-credito/{id}', 'CreditoController@edit')->name('admin.modificar-credito');

	Route::get('correo-de-invitacion', 'AdminController@correo_invitacion')->name('admin.correo-invitacion');
});
Route::resource('admin', 'AdminController');
// ./RUTAS PARA EL ADMIN WEB ./

Route::get('payment', array(
    'as' => 'payment',
    'uses' => 'PaypalController@postPayment',
));
 
Route::get('payment/status', array(
    'as' => 'payment.status',
    'uses' => 'PaypalController@getPaymentStatus',
));

