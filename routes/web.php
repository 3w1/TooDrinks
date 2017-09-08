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

// ******* RUTAS DEL FRONTEND ******* //
Route::get('main', 'FrontendController@index')->name('frontend.index');
Route::get('noticias', 'FrontendController@noticias')->name('frontend.noticias');
Route::get('marcas', 'FrontendController@marcas')->name('frontend.marcas');
Route::get('productos', 'FrontendController@productos')->name('frontend.productos');
Route::get('quienes-somos', 'FrontendController@quienes_somos')->name('frontend.quienes-somos');
Route::get('contacto', 'FrontendController@contacto')->name('frontend.contacto');

Route::get('marcas/{id}', 'FrontendController@detalle_marca')->name('frontend.marca');
Route::get('productos/{id}', 'FrontendController@detalle_producto')->name('frontend.producto');
// *** FIN DE RUTAS DEL FRONTEND *** //


//RUTAS DE INICIO Y AUTENTICACIÓN
Auth::routes();
Route::get('iniciar-sesion', 'Auth\LoginController@iniciar_sesion')->name('iniciar-sesion');
Route::get('/home', 'FrontendController@index')->name('welcome');

Route::get('/', function () {
    return redirect()->action('FrontendController@index');
});

Route::get('/inicio', 'UsuarioController@index')->name('inicio');
Route::get('registrarse', 'Auth\RegisterController@registrarse')->name('registrarse');
Route::get('registrarse-con-invitacion/{tipo}${id}${token}', 'Auth\RegisterController@registrarse_invitacion')->name('registrarse-invitacion');
// ./RUTAS DE INICIO Y AUTENTICACIÓN ./

//  RUTAS PARA LOS USUARIOS
Route::prefix('usuario')->group(function (){
    Route::get('confirmar-correo/{id}${token}', 'UsuarioController@confirmar_correo');
    Route::get('confirmar-cuenta', 'UsuarioController@confirmar_cuenta')->name('usuario.confirmar-cuenta');

    Route::post('cambiar-perfil', 'UsuarioController@cambiar_perfil')->name('usuario.cambiar-perfil');
    Route::get('inicio', 'UsuarioController@inicio')->name('usuario.inicio');

    Route::post('updateAvatar', 'UsuarioController@updateAvatar')->name('usuario.updateAvatar');
});
Route::resource('usuario','UsuarioController');
// ./RUTAS PARA LOS USUARIOS./

// RUTAS PARA LOS PRODUCTORES
Route::prefix('productor')->group(function (){
    Route::get('inicio', 'ProductorController@inicio')->name('productor.inicio');
    
    Route::post('asociar-producto', 'ProductorController@asociar_producto')->name('productor.asociar-producto');

    Route::get('confirmar-importadores', 'ProductorController@confirmar_importadores')->name('productor.confirmar-importadores');
    Route::get('confirmar-importador/{id}-{tipo}-{imp}', 'ProductorController@confirmar_importador')->name('productor.confirmar-importador');

    Route::get('confirmar-distribuidores', 'ProductorController@confirmar_distribuidores')->name('productor.confirmar-distribuidores');
    Route::get('confirmar-distribuidor/{id}-{tipo}-{dist}', 'ProductorController@confirmar_distribuidor')->name('productor.confirmar-distribuidor');

    Route::get('confirmar-productos', 'ProductorController@confirmar_productos')->name('productor.confirmar-productos');
    Route::get('confirmar-producto/{id}-{tipo}', 'ProductorController@confirmar_producto')->name('productor.confirmar-producto');

    Route::get('asociar-marca/{id}/{nombre}', 'ProductorController@asociar_marca')->name('productor.asociar-marca');

    Route::get('ver-listado-importadores', 'ProductorController@listado_importadores')->name('productor.listado-importadores');

    Route::post('updateAvatar', 'ProductorController@updateAvatar')->name('productor.updateAvatar');
});
Route::resource('productor','ProductorController');
// ./RUTAS PARA LOS PRODUCTORES ./

// RUTAS PARA LOS IMPORTADORES
Route::prefix('importador')->group(function (){
    Route::get('asociar-marca/{id}/{nombre}', 'ImportadorController@asociar_marca')->name('importador.asociar-marca');

    Route::get('ver-listado-distribuidores', 'ImportadorController@listado_distribuidores')->name('importador.listado-distribuidores');

    //Consulta AJAX
    Route::get('datos/{id}', 'ImportadorController@datos');
    
    Route::post('updateAvatar', 'ImportadorController@updateAvatar')->name('importador.updateAvatar');
});
Route::resource('importador','ImportadorController');
// ./RUTAS PARA LOS IMPORTADORES ./

// RUTAS PARA LOS IMPORTADORES
Route::resource('multinacional', 'MultinacionalController');
// ./RUTAS PARA LOS IMPORTADORES ./ //

// RUTAS PARA LOS DISTRIBUIDORES
Route::prefix('distribuidor')->group(function (){
    Route::get('asociar-marca/{id}/{nombre}', 'DistribuidorController@asociar_marca')->name('distribuidor.asociar-marca');

    //Consulta AJAX
    Route::get('datos/{id}', 'DistribuidorController@datos');

    Route::post('updateAvatar', 'DistribuidorController@updateAvatar')->name('distribuidor.updateAvatar');
});
Route::resource('distribuidor','DistribuidorController');
// ./RUTAS PARA LOS DISTRIBUIDORES ./

// RUTAS PARA LOS HORECAS
Route::prefix('horeca')->group(function (){
    Route::get('distribuidores-locales', 'HorecaController@distribuidores_locales')->name('horeca.distribuidores');
    
    Route::post('updateAvatar', 'HorecaController@updateAvatar')->name('horeca.updateAvatar');
});
Route::resource('horeca','HorecaController');
// ./RUTAS PARA LOS HORECAS ./

// RUTAS PARA LAS MARCAS 
Route::prefix('marca')->group(function (){ 
    Route::get('descripcion/{id}', 'MarcaController@descripcion');
    Route::post('cambiar-logo', 'MarcaController@updateLogo')->name('marca.updateLogo');

    Route::get('{id}/{nombre_seo}', 'MarcaController@show')->name('marca.detalles');

    //Agregar una marca al listado de una entidad (Marcas Mundiales)
    Route::get('agregar-marca', 'MarcaController@agregar_marca')->name('marca.agregar-marca');
    
    //Peticiones AJAX
    Route::get('prueba/{nombre}', 'MarcaController@buscar_por_nombre');
    Route::get('buscar-por-productor/{productor}', 'MarcaController@buscar_por_productor');
    Route::get('buscar-por-pais/{pais}', 'MarcaController@buscar_por_pais');
    Route::get('detalles-marca/{id}', 'MarcaController@detalles_marca');
});
Route::resource('marca','MarcaController');

Route::get('buscar-marca-por-nombre/{nombre}', 'MarcaController@buscar_por_nombre');
Route::get('buscar-marca-por-productor/{productor}', 'MarcaController@buscar_por_productor');
Route::get('buscar-marca-por-pais/{pais}', 'MarcaController@buscar_por_pais');
Route::get('detalles-marca/{id}', 'MarcaController@detalles_marca');
// ./RUTAS PARA LAS MARCAS ./

// RUTAS PARA LAS BEBIDAS
Route::prefix('bebida')->group(function () {
    Route::get('clases/{id}', 'BebidaController@clases')->name('bebida.clases');
});
Route::resource('bebida','BebidaController');
// ./RUTAS PARA LAS BEBIDAS ./

// RUTAS PARA LOS PRODUCTOS
Route::prefix('producto')->group(function (){
    //Agregar un producto al listado de una entidad (Productos Mundiales)
    Route::get('agregar-producto', 'ProductoController@agregar_producto')->name('producto.agregar-producto');

    Route::get('agregar/{id}-{marca}', 'ProductoController@agregar')->name('producto.agregar');
    Route::get('listado-de-productos/{id}-{marca}', 'ProductoController@listado')->name('producto.listado');
    Route::get('detalle-de-producto/{id}/{nombre_seo}', 'ProductoController@detalle')->name('producto.detalle');
    Route::get('seleccionar-productos/{id}', 'ProductoController@seleccionar_productos')->name('producto.seleccionar');
    Route::post('asociar-productos', 'ProductoController@asociar_productos')->name('producto.asociar-productos');
    Route::get('verificar-producto/{id}', 'ProductoController@verificar_producto');
    Route::get('mis-productos/{filtro}', 'ProductoController@mis_productos')->name('producto.mis-productos');
   // Route::get('productos-m', 'ProductoController@productos_mundiales')->name('producto.mundiales');
    Route::get('asociar-producto/{id}', 'ProductoController@asociar_producto')->name('producto.asociar-producto');
    //Peticiones AJAX
    Route::get('productos-por-clase/{bebida}/{clase}', 'ProductoController@productos_por_clase');
    Route::get('productos-por-pais/{bebida}/{pais}', 'ProductoController@productos_por_pais');

    Route::post('updateImagen', 'ProductoController@updateImagen')->name('producto.updateImagen');
});
Route::resource('producto','ProductoController');
// ./RUTAS PARA LOS PRODUCTOS ./

// RUTAS PARA LAS OFERTAS
Route::prefix('oferta')->group(function () {
    Route::get('crear-oferta/{id}/{producto}', 'OfertaController@crear_oferta')->name('oferta.crear-oferta');
    
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

    Route::get('marcar-demanda/{id}/{check}', 'DemandaImportacionController@marcar_demanda')
    ->name('demanda-importador.marcar');
    Route::get('demandas-de-interes', 'DemandaImportacionController@demandas_interes')
    ->name('demanda-importador.demandas-interes');

    Route::post('cambiar-status', 'DemandaImportacionController@cambiar_status')
    ->name('demanda-importador.status');
});
Route::resource('demanda-importador','DemandaImportacionController');
// ./RUTAS PARA LAS DEMANDAS DE IMPORTADORES ./

// RUTAS PARA LAS DEMANDAS DE DISTRIBUIDORES
Route::prefix('demanda-distribuidor')->group(function () {
    Route::get('demandas-disponibles', 'DemandaDistribucionController@demandas_disponibles')
    ->name('demanda-distribuidor.demandas-disponibles');

    Route::get('marcar-demanda/{id}/{check}', 'DemandaDistribucionController@marcar_demanda')->name('demanda-distribuidor.marcar');
    Route::get('demandas-de-interes', 'DemandaDistribucionController@demandas_interes')
    ->name('demanda-distribuidor.demandas-interes');

    Route::post('cambiar-status', 'DemandaDistribucionController@cambiar_status')
    ->name('demanda-distribuidor.status');
});
Route::resource('demanda-distribuidor','DemandaDistribucionController');
// ./RUTAS PARA LAS DEMANDAS DE DISTRIBUIDORES ./

// RUTAS PARA LAS DEMANDAS DE PRODUCTOS 
Route::prefix('demanda-producto')->group(function () {
    Route::get('demandas-productos-disponibles', 'DemandaProductoController@demandas_productos_disponibles')
    ->name('demanda-producto.demandas-productos-disponibles');
    Route::get('demandas-bebidas-disponibles', 'DemandaProductoController@demandas_bebidas_disponibles')
    ->name('demanda-producto.demandas-bebidas-disponibles');

    Route::post('cambiar-status', 'DemandaProductoController@cambiar_status')
    ->name('demanda-producto.status');

    Route::get('marcar-demanda/{id}/{check}', 'DemandaProductoController@marcar_demanda')->name('demanda-producto.marcar');
    Route::get('demandas-de-interes', 'DemandaProductoController@demandas_interes')->name('demanda-producto.demandas-interes');
});
Route::resource('demanda-producto','DemandaProductoController');
// ./RUTAS PARA LAS DEMANDAS DE PRODUCTOS ./

// RUTAS PARA LAS DEMANDAS DE IMPORTACIÓN
Route::prefix('solicitud-importacion')->group(function () {
    Route::get('marcar-solicitud/{id}/{check}', 'SolicitudImportacionController@marcar_solicitud')
    ->name('solicitud-importacion.marcar');
    Route::get('demandas-de-interes', 'SolicitudImportacionController@demandas_interes')
    ->name('solicitud-importacion.demandas-interes');

    Route::post('cambiar-status', 'SolicitudImportacionController@cambiar_status')
    ->name('solicitud-importacion.status');

    Route::get('solicitudes-importacion', 'SolicitudImportacionController@solicitudes_importacion')
    ->name('solicitud-importacion.solicitudes');
});
Route::resource('solicitud-importacion', 'SolicitudImportacionController');
// ./RUTAS PARA LAS DEMANDAS DE IMPORTACIÓN ./

// RUTAS PARA LAS DEMANDAS DE DISTRIBUCIÓN
Route::prefix('solicitud-distribucion')->group(function () {
    Route::get('marcar-solicitud/{id}/{check}', 'SolicitudDistribucionController@marcar_solicitud')
    ->name('solicitud-distribucion.marcar');
    Route::get('demandas-de-interes', 'SolicitudDistribucionController@demandas_interes')
    ->name('solicitud-distribucion.demandas-interes');

    Route::post('cambiar-status', 'SolicitudDistribucionController@cambiar_status')
    ->name('solicitud-distribucion.status');

    Route::get('solicitudes-distribucion', 'SolicitudDistribucionController@solicitudes_distribucion')
    ->name('solicitud-distribucion.solicitudes');
});
Route::resource('solicitud-distribucion', 'SolicitudDistribucionController');
// ./RUTAS PARA LAS DEMANDAS DE DISTRIBUCIÓN ./

// RUTAS PARA LOS CRÉDITOS
Route::prefix('credito')->group(function () {
    Route::get('compra/{id}','CreditoController@compra')->name('credito.compra');
    Route::get('historial-de-planes', 'CreditoController@historial_planes')->name('credito.historial-planes');
    Route::get('generar_factura/{id}','CreditoController@generar_factura')->name('credito.generar-factura');

    Route::get('historial-de-gastos', 'CreditoController@historial_gastos')->name('credito.historial-gastos');
    Route::get('detalles-gasto/{tipo}/{id}', 'CreditoController@detalles_gasto');

    Route::get('gastar-creditos-co/{id}', 'CreditoController@gastar_creditos_CO')->name('credito.gastar-creditos-co');
    Route::get('gastar-creditos-di/{id}', 'CreditoController@gastar_creditos_DI')->name('credito.gastar-creditos-di');
    Route::get('gastar-creditos-dd/{id}', 'CreditoController@gastar_creditos_DD')->name('credito.gastar-creditos-dd');
    Route::get('gastar-creditos-dp/{id}', 'CreditoController@gastar_creditos_DP')->name('credito.gastar-creditos-dp');
    Route::get('gastar-creditos-db/{id}', 'CreditoController@gastar_creditos_DB')->name('credito.gastar-creditos-db');
    Route::get('gastar-creditos-si/{id}', 'CreditoController@gastar_creditos_SI')->name('credito.gastar-creditos-si');
    Route::get('gastar-creditos-sd/{id}', 'CreditoController@gastar_creditos_SD')->name('credito.gastar-creditos-sd');
    Route::get('gastar-creditos-pdi/{id}', 'CreditoController@gastar_creditos_PDI')->name('credito.gastar-creditos-pdi');
    Route::get('gastar-creditos-pdd/{id}', 'CreditoController@gastar_creditos_PDD')->name('credito.gastar-creditos-pdd');
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

    Route::get('nueva-publicacion', 'BannerController@nueva_publicacion')->name('banner-publicitario.nueva-publicacion');
    //Consulta AJAX
    Route::get('consultar-disponibilidad/{pais}/{dias}', 'BannerController@consultar_disponibilidad')
    ->name('banner-publicitario.consultar-disponibilidad');
      
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

// RUTAS PARA EL ADMIN
Route::prefix('admin')->group(function () {
    Route::get('login', 'AdminController@login')->name('admin.login');
    Route::post('loggear', 'AdminController@loggear')->name('admin.loggear');
    Route::get('logout', 'AdminController@logout')->name('admin.logout');

    //OPCIONES DE PRODUCTOR
    Route::get('crear-productor', 'ProductorController@create')->name('admin.crear-productor');
    Route::get('listado-productores', 'ProductorController@index')->name('admin.listado-productores');
    Route::get('actualizar-productor/{id}/{nombre_seo}', 'AdminController@actualizar_productor')->name('admin.actualizar-productor');
    Route::put('productor-update/{id}', 'AdminController@productor_update')->name('admin.productor-update');
    Route::post('actualizar-avatar-productor', 'AdminController@productor_updateAvatar')->name('admin.productor-update-avatar');
    
    //OPCIONES DE IMPORTADOR
    Route::get('crear-importador', 'ImportadorController@create')->name('admin.crear-importador');
    Route::get('listado-importadores', 'ImportadorController@index')->name('admin.listado-importadores');
    Route::get('actualizar-importador/{id}/{nombre_seo}', 'AdminController@actualizar_importador')->name('admin.actualizar-importador');
    Route::put('importador-update/{id}', 'AdminController@importador_update')->name('admin.importador-update');
    Route::post('actualizar-avatar-importador', 'AdminController@importador_updateAvatar')->name('admin.importador-update-avatar');
    
    //OPCIONES DE DISTRIBUIDOR
    Route::get('crear-distribuidor', 'DistribuidorController@create')->name('admin.crear-distribuidor');
    Route::get('listado-distribuidores', 'DistribuidorController@index')->name('admin.listado-distribuidores');
    Route::get('actualizar-distribuidor/{id}/{nombre_seo}', 'AdminController@actualizar_distribuidor')->name('admin.actualizar-distribuidor');
    Route::put('distribuidor-update/{id}', 'AdminController@distribuidor_update')->name('admin.distribuidor-update');
    Route::post('actualizar-avatar-distribuidor', 'AdminController@distribuidor_updateAvatar')->name('admin.distribuidor-update-avatar');
    
    //OPCIONES DE HORECA
    Route::get('crear-horeca', 'HorecaController@create')->name('admin.crear-horeca');
    Route::get('listado-horecas', 'HorecaController@index')->name('admin.listado-horecas');
    Route::get('actualizar-horeca/{id}/{nombre_seo}', 'AdminController@actualizar_horeca')->name('admin.actualizar-horeca');
    Route::put('horeca-update/{id}', 'AdminController@horeca_update')->name('admin.horeca-update');
    Route::post('actualizar-avatar-horeca', 'AdminController@horeca_updateAvatar')->name('admin.horeca-update-avatar');
    
    //OPCIONES DE MARCA
    Route::get('nueva-marca', 'AdminController@crear_marca')->name('admin.crear-marca');
    Route::post('guardar-marca', 'AdminController@marca_store')->name('admin.marca-store');
    Route::get('listado-marcas', 'AdminController@listado_marcas')->name('admin.listado-marcas');
    Route::get('marca-detallada/{id}/{nombre_seo}', 'AdminController@marca_detallada')->name('admin.marca-detallada');
    Route::post('actualizar-logo-marca', 'AdminController@update_logo_marca')->name('admin.marca-updateLogo');
    Route::put('actualizar-marca/{id}', 'AdminController@update_marca')->name('admin.marca-update');
    Route::get('marcas-sin-propietario', 'AdminController@marcas_sin_propietario')->name('admin.marcas-sin-propietario');
    Route::post('asociar-marca-productor', 'AdminController@asociar_marca_productor')->name('admin.asociar-marca-productor');

    //OPCIONES DE PRODUCTO
    Route::get('nuevo-producto', 'AdminController@crear_producto')->name('admin.crear-producto');
    Route::post('guardar-producto', 'AdminController@producto_store')->name('admin.producto-store');
    Route::get('listado-productos', 'AdminController@listado_productos')->name('admin.listado-productos');
    Route::get('producto-detallado/{id}/{nombre_seo}', 'AdminController@producto_detallado')->name('admin.producto-detallado');
    Route::post('actualizar-logo-producto', 'AdminController@update_logo_producto')->name('admin.producto-updateLogo');
    Route::put('actualizar-producto/{id}', 'AdminController@update_producto')->name('admin.producto-update');
    Route::get('productos-sin-marca', 'AdminController@productos_sin_marca')->name('admin.productos-sin-marca');
    Route::post('asociar-producto-marca', 'AdminController@asociar_producto_marca')->name('admin.asociar-producto-marca');
    
    //OPCIONES DE CONFIRMACIONES
    Route::get('marcas-sin-aprobar', 'AdminController@marcas_sin_aprobar')->name('admin.marcas-sin-aprobar');
    Route::get('aprobar-marca/{id}', 'AdminController@aprobar_marca')->name('admin.aprobar-marca');
    Route::get('productos-sin-aprobar', 'AdminController@productos_sin_aprobar')->name('admin.productos-sin-aprobar');
    Route::get('aprobar-producto/{id}', 'AdminController@aprobar_producto')->name('admin.aprobar-producto');
    
    //ENVÍO DE CORREOS
    Route::get('enviar-invitacion/{tipo}/{id}', 'MailsController@correo_invitacion')->name('admin.enviar-invitacion');

   //OPCIONES DE PUBLICIDAD
    Route::get('nuevo-banner', 'AdminController@crear_banner')->name('admin.nuevo-banner');
    Route::post('guardar-banner', 'AdminController@banner_store')->name('admin.banner-store');
    Route::get('editar-banner', 'AdminController@editar_banner')->name('admin.editar-banner'); 
    Route::post('actualizar-banner', 'AdminController@update_banner')->name('admin.banner-update');
    Route::post('actualizar-imagen-banner', 'AdminController@update_imagen_banner')->name('admin.imagen-banner-update');
    Route::get('aprobar-banners', 'AdminController@aprobar_banners')->name('admin.aprobar-banners');
    Route::get('aprobar-banner/{id}', 'AdminController@aprobar_banner')->name('admin.aprobar-banner');
    Route::get('sugerir-correcciones-banner/{id}', 'AdminController@sugerir_correcciones_banner')
    ->name('admin.sugerir-correcciones-banner');
    Route::post('guardar-sugerencias', 'AdminController@guardar_sugerencias_banner')->name('admin.guardar-sugerencias-banner');
    Route::get('publicar-banner', 'AdminController@publicar_banner')->name('admin.publicar-banner');
    Route::post('guardar-publicacion', 'AdminController@guardar_publicacion')->name('admin.guardar-publicacion');
    Route::get('publicaciones-en-curso', 'AdminController@publicaciones_en_curso')->name('admin.publicaciones-en-curso'); 
    Route::get('historial-de-publicaciones', 'AdminController@historial_de_publicaciones')->name('admin.historial-de-publicaciones');

    //OPCIONES DE NOTIFICACIONES
    Route::get('notificaciones', 'AdminController@notificaciones')->name('admin.notificaciones');
    Route::get('marcar-leida/{id}', 'AdminController@marcar_leida')->name('admin.marcar-leida');

    //OPCIONES DE FINANZAS
    Route::get('agregar-quitar-creditos', 'AdminController@agregar_quitar_creditos')->name('admin.agregar-quitar-creditos');
    Route::post('sumar-restar-creditos', 'AdminController@sumar_restar_creditos')->name('admin.sumar-restar-creditos');


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

//CONSULTAS AJAX
Route::prefix('consulta')->group(function () {
    //CONSULTA PARA PAISES Y PROVINCIAS
    Route::get('cargar-provincias/{pais}', 'ConsultasAjax@cargar_provincias');

    //CONSULTAS PARA MARCAS
    Route::get('verificar-nombre-marca/{nombre}/{id_marca}', 'ConsultasAjax@verificar_nombre_marca');

    //CONSULTAS PARA PRODUCTOS
    Route::get('verificar-nombre-producto/{nombre}/{id_producto}', 'ConsultasAjax@verificar_nombre_producto');

    Route::get('buscar-productor/{nombre}', 'ConsultasAjax@buscar_productor');
    Route::get('buscar-marca/{nombre}', 'ConsultasAjax@buscar_marca');
    Route::get('cargar-clases-bebida/{bebida}', 'ConsultasAjax@cargar_clases_bebidas');
    Route::get('cargar-descripcion-marca/{marca}', 'ConsultasAjax@cargar_descripcion_marca');
    Route::get('cargar-detalles-producto/{producto}', 'ConsultasAjax@cargar_detalles_producto');
    Route::get('cargar-entidades/{tipo}', 'ConsultasAjax@cargar_entidades');
    Route::get('cargar-detalles-banner/{id}', 'ConsultasAjax@cargar_detalles_banner');
    Route::get('cargar-datos-banner/{id}', 'ConsultasAjax@cargar_datos_banner');
    Route::get('consultar-fechas-banner/{pais}/{semanas}', 'ConsultasAjax@consultar_fechas_banner');
    Route::get('cargar-marcas/{productor}', 'ConsultasAjax@cargar_marcas');
});