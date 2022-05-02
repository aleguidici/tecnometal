<?php

use Illuminate\Support\Facades\Route;

//home
//Route::get('/', function () { return view('home');})->name("home")->middleware('auth');
Route::get('/', 'GeneralController@index')->name("home")->middleware('auth');

//clientes
Route::get('/clientes', 'ClienteController@index')->name('clientes.index')->middleware('auth');
Route::get('/clientes/crear', 'ClienteController@create')->name('clientes.create')->middleware('auth');
Route::get('/clientes/{id}/editar', 'ClienteController@edit')->name('clientes.edit')->middleware('auth');
Route::patch('/clientes/{id}', 'ClienteController@update')->name('clientes.update')->middleware('auth');
Route::post('/clientes', 'ClienteController@store')->name('clientes.store')->middleware('auth');
Route::get('/clientes/{id}', 'ClienteController@show')->name('clientes.show')->middleware('auth');
Route::delete('/clientes/{id}', 'ClienteController@destroy')->name('clientes.destroy')->middleware('auth');
Route::get('/clientes/destroy/{id}', 'ClienteController@destroy')->middleware('auth');

//Contactos
Route::post('/contactos/get_contactos','ContactoController@get_contactos')->name('contactos.get')->middleware('auth');

//proveedores
Route::get('/proveedores', 'ProveedorController@index')->name('proveedores.index')->middleware('auth');
Route::get('/proveedores/crear', 'ProveedorController@create')->name('proveedores.create')->middleware('auth');
Route::get('/proveedores/{id}/editar', 'ProveedorController@edit')->name('proveedores.edit')->middleware('auth');
Route::patch('/proveedores/{id}', 'ProveedorController@update')->name('proveedores.update')->middleware('auth');
Route::post('/proveedores', 'ProveedorController@store')->name('proveedores.store')->middleware('auth');
Route::get('/proveedores/{id}','ProveedorController@show')->name('proveedores.show')->middleware('auth');
Route::get('/proveedores/destroy/{id}', 'ProveedorController@destroy')->name('proveedores.destroy')->middleware('auth');

//Provincias
Route::post('/provincias/get_provs','ProvinciaController@get_provincias')->name('provincias.get')->middleware('auth');

//Localidades
Route::get('/localidades', 'LocalidadController@index')->name('localidades.index')->middleware('auth');
Route::get('/localidades/crear', 'LocalidadController@create')->name('localidades.create')->middleware('auth');
Route::get('/localidades/{id}/editar', 'LocalidadController@edit')->name('localidades.edit')->middleware('auth');
Route::patch('/localidades/{id}', 'LocalidadController@update')->name('localidades.update')->middleware('auth');
Route::post('/localidades', 'LocalidadController@store')->name('localidades.store')->middleware('auth');
Route::post('/localidades/store_locs','LocalidadController@store_loc')->middleware('auth');
Route::post('/localidades/get_locs','LocalidadController@get_localidades')->name('localidades.get')->middleware('auth');
Route::delete('/localidades/{id}', 'LocalidadController@destroy')->name('localidades.destroy')->middleware('auth');
Route::get('/localidades/destroy/{id}', 'LocalidadController@destroy')->middleware('auth');

//materiales
Route::get('/materiales', 'MaterialController@index')->name('materiales.index')->middleware('auth');
Route::get('/materiales/crear', 'MaterialController@create')->name('materiales.create')->middleware('auth');
Route::get('/materiales/{id}/editar', 'MaterialController@edit')->name('materiales.edit')->middleware('auth');
Route::patch('/materiales/{id}', 'MaterialController@update')->name('materiales.update')->middleware('auth');
Route::post('/materiales', 'MaterialController@store')->name('materiales.store')->middleware('auth');
Route::get('/materiales/destroy/{id}', 'MaterialController@destroy')->name('materiales.destroy')->middleware('auth');

//manos_obra
Route::get('/manos_obra', 'ManoObraController@index')->name('manos_obra.index')->middleware('auth');
Route::get('/manos_obra/crear', 'ManoObraController@create')->name('manos_obra.create')->middleware('auth');
Route::get('/manos_obra/{id}/editar', 'ManoObraController@edit')->name('manos_obra.edit')->middleware('auth');
Route::patch('/manos_obra/{id}', 'ManoObraController@update')->name('manos_obra.update')->middleware('auth');
Route::post('/manos_obra', 'ManoObraController@store')->name('manos_obra.store')->middleware('auth');
Route::get('/manos_obra/destroy/{id}', 'ManoObraController@destroy')->name('manos_obra.destroy')->middleware('auth');

//actividades_preestablecidas
Route::get('/actividades_preestablecidas', 'ActividadPreestablecidaController@index')->name('actividades_preestablecidas.index')->middleware('auth');
Route::get('/actividades_preestablecidas/crear', 'ActividadPreestablecidaController@create')->name('actividades_preestablecidas.create')->middleware('auth');
Route::get('/actividades_preestablecidas/{id}/editar', 'ActividadPreestablecidaController@edit')->name('actividades_preestablecidas.edit')->middleware('auth');
Route::post('/actividades_preestablecidas/update/', 'ActividadPreestablecidaController@update')->name('actividades_preestablecidas.update')->middleware('auth');
Route::post('/actividades_preestablecidas', 'ActividadPreestablecidaController@store')->name('actividades_preestablecidas.store')->middleware('auth');
Route::get('/actividades_preestablecidas/destroy/{id}', 'ActividadPreestablecidaController@destroy')->name('actividades_preestablecidas.destroy')->middleware('auth');
Route::get('/actividades_preestablecidas/{id}/manos_obra', 'ActividadPreestablecidaController@manos_obra')->name('actividades_preestablecidas.manos_obra')->middleware('auth');
Route::get('/actividades_preestablecidas/destroy/{ap_id}/{mano_obra_id}', 'ActividadPreestablecidaController@mano_obra_destroy')->name('actividades_preestablecidas.mano_obra_destroy')->middleware('auth');
Route::post('/actividades_preestablecidas/manos_obra/actualizar_cantidad','ActividadPreestablecidaController@mano_obra_update_amount')->name('actividades_preestablecidas.mano_obra_amount_update')->middleware('auth');
Route::post('/actividades_preestablecidas/manos_obra/asociar_a_ap','ActividadPreestablecidaController@mano_obra_save')->name('actividades_preestablecidas.mano_obra_amount_update')->middleware('auth');
Route::get('/actividades_preestablecidas/{id}/materiales/','ActividadPreestablecidaController@materiales')->name('actividades_preestablecidas.materiales')->middleware('auth');
Route::get('/actividades_preestablecidas/materiales/destroy/{id}','ActividadPreestablecidaController@material_destroy')->name('actividades_preestablecidas.materiales.destroy')->middleware('auth');
Route::post('/actividades_preestablecidas/materiales/actualizar_cantidad','ActividadPreestablecidaController@materiales_update_amount')->name('actividades_preestablecidas.materiales.update_amount')->middleware('auth');
Route::post('/actividades_preestablecidas/manos_obra/asociar_mat','ActividadPreestablecidaController@materiales_store')->name('actividades_preestablecidas.materiales.store')->middleware('auth');
Route::post('/actividades_preestablecidas/update_pendiente','ActividadPreestablecidaController@update_pendiente')->name('ap.update_pendiente')->middleware('auth');

//medidas
Route::get('/unidadesdemedida', 'UnidadDeMedidaController@index')->name('unidadesdemedida.index')->middleware('auth');

//GastosPreest
Route::get('/gastos_preest', 'GastosPreestController@index')->name('gastos_preest.index')->middleware('auth');
Route::get('/gastos_preest/{id}/editar', 'GastosPreestController@edit')->name('gastos_preest.edit')->middleware('auth');
Route::patch('/gastos_preest/{id}', 'GastosPreestController@update')->name('gastos_preest.update')->middleware('auth');
Route::post('/gastos_preest/store','GastosPreestController@store')->name('gastos_preest.store')->middleware('auth');

//Presupuestos
Route::get('/presupuestos', 'PresupuestoController@index')->name('presupuestos.index')->middleware('auth');
Route::get('/presupuestos/create','PresupuestoController@create')->name('presupuestos.create')->middleware('auth');
Route::get('/presupuestos/{id}/editar', 'PresupuestoController@edit')->name('presupuestos.edit')->middleware('auth');
Route::patch('/presupuestos/{id}', 'PresupuestoController@update')->name('presupuestos.update')->middleware('auth');
Route::post('/presupuestos', 'PresupuestoController@store')->name('presupuestos.store')->middleware('auth');
Route::get('/presupuestos/{id}','PresupuestoController@show')->name('presupuestos.show')->middleware('auth');
Route::get('/presupuestos/destroy/{id}', 'PresupuestoController@destroy')->name('presupuestos.destroy')->middleware('auth');
Route::post('/presupuestos/items/create_item_detalles/get_datos_estandar','ItemController@get_datos_estandar')->middleware('auth');
Route::post('/presupuestos/items/create','PresupuestoController@create_item')->name('presupuesto.item.create')->middleware('auth');
Route::post('/presupuestos/items/edit','PresupuestoController@edit_item')->name('presupuesto.item.edit')->middleware('auth');
Route::get('/presupuestos/items/{id}/create_detalles','ItemController@create')->name('presupuestos.create_item_detalles')->middleware('auth');
Route::get('/presupuesto/items/{id}/delete','PresupuestoController@delete_item')->name('presupuesto.item.destroy')->middleware('auth');
Route::get('/presupuestos/items/{id}','PresupuestoController@show_items')->name('presupuestos.items')->middleware('auth');
Route::post('/presupuesto/confirmar','PresupuestoController@confirmar_presupuesto')->name('presupuestos.confirmar')->middleware('auth');
Route::post('/presupuesto/aprobar','PresupuestoController@aprobar_presupuesto')->name('presupuestos.aprobar')->middleware('auth');
Route::post('/presupuesto/anular','PresupuestoController@anular_presupuesto')->name('presupuestos.anular')->middleware('auth');
Route::post('/presupuesto/booleanTablas','PresupuestoController@booleanTablas_presupuesto')->name('presupuestos.booleanTablas')->middleware('auth');
Route::post('/presupuesto/rechazar','PresupuestoController@rechazar_presupuesto')->name('presupuestos.rechazar')->middleware('auth');
Route::post('/presupuesto/update_impuestos','PresupuestoController@update_impuestos')->name('presupuesto.item.update_impuestos')->middleware('auth');
Route::post('/presupuesto/update_impuestos_cliente','PresupuestoController@update_impuestos_cliente')->name('presupuesto.update_impuestos_cliente')->middleware('auth');
Route::post('/presupuesto/reactivar_presupuesto','PresupuestoController@reactivar_presupuesto')->name('presupuesto.reactivar')->middleware('auth');

//Registro de Detalles
Route::post('/presupuestos/items/store_detalle_materiales','ItemController@store_material')->name('item.material.store')->middleware('auth');
Route::post('/presupuestos/items/store_detalle_mano_obra','ItemController@store_mano_obra')->name('item.mano_obra.store')->middleware('auth');
Route::post('/presupuesto/items/create_ap_item','ItemController@store_ap_item')->name('item.ap_item.store')->middleware('auth');

Route::post('/presupuesto/items/edit_amount_ap_item','ItemController@update_amount_ap_item')->name("item.ap_item.update_amount")->middleware('auth');
Route::post('/presupuesto/items/edit_amount_materiales','ItemController@update_amount_materiales')->name("item.material.update_amount")->middleware('auth');
Route::post('/presupuesto/items/edit_amount_mano_obra','ItemController@update_amount_mano_obra')->name("item.mano_obra.update_amount")->middleware("auth");
Route::post('/presupuesto/items/edit_pu_materiales','ItemController@update_materiales_pu')->name("item.material.update_pu")->middleware('auth');
Route::post('/presupuesto/items/edit_pu_mano_obra','ItemController@update_mano_obra_pu')->name("item.mano_obra.update_pu")->middleware("auth");
Route::post('/presupuesto/items/edit_marca_codigo','ItemController@update_materiales_marca_codigo')->name('item.material.update_marca_codigo')->middleware('auth');
Route::post('/presupuesto/items/edit_impustos','ItemController@update_impuestos')->name('item.material.update_impuestos')->middleware('auth');

Route::post('/presupuesto/items/delete_item_material','ItemController@delete_item_material')->name('item.material.delete')->middleware('auth');
Route::post('/presupuesto/items/delete_item_mano_obra','ItemController@delete_item_mano_obra')->name('item.mano_obra.delete')->middleware('auth');
Route::post('/presupuesto/items/delete_ap_item','ItemController@delete_ap_item')->name('item.ap_item.delete')->middleware('auth');
//Usuarios
Route::get('/usuarios','UserController@index')->name('usuarios.index')->middleware('auth');
Route::get('/usuarios/create','UserController@create')->name('usuarios.create')->middleware('auth');
Route::get('/usuarios/{id}/editar', 'UserController@edit')->name('usuarios.edit')->middleware('auth');
Route::patch('/usuarios/{id}','UserController@update')->name('usuarios.update')->middleware('auth');
Route::post('/usuarios', 'UserController@store')->name('usuarios.store')->middleware('auth');
Route::get('/usuarios/destroy/{id}','UserController@destroy')->name('usuarios.destroy')->middleware('auth');

Auth::routes(['register'=>false]);

//Presupuesto Imprimible
Route::get('/invoice/{id}','PresupuestoImprimible@presupuesto_cliente')->name('presupuesto.imprimible.cliente')->middleware('auth');

//Ruta tempore
Route::get('/item',function(){
    return view('presupuestos/items');
});
