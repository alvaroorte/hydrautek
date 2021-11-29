<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\UserContorller;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



//rutas para los usuarios
Route::resource('/users', UserController::class)->middleware('can:users.index');
Route::get('/editarusuario/{id}','UserController@EditarUser');
Route::post('/updateusuario','UserController@UpdateUser');
Route::get('/listausuario','UserController@Index');
Route::get('/editarusuario/{user}','UserController@Edit');
Route::get('/crearusuario','UserController@Create');
Route::post('/crearusuario','UserController@store');



Route::get('/home', 'HomeController@index')->name('home');


//rutas para los pagos
Route::post('/crearpago','PagoController@CrearPago');

//rutas para los bancos
Route::get('/mostrarbancos','BancoController@ListaBanco');
Route::get('/movimientobanco/{id}','BancoController@MovimientoBanco');
Route::post('/crearbanco','BancoController@CrearBanco');
Route::get('/encontrarbanco/{id}','BancoController@EncontrarBanco');
Route::post('/updatebanco','BancoController@UpdateBanco');
Route::delete('/eliminarbanco/{id}','BancoController@EliminarBanco');
Route::get('/pdfbanco/{id}','BancoController@PdfBanco');
Route::get('/excelbanco','BancoController@ExcelBanco');
Route::get('/reportefechabanco','BancoController@ReporteFechaBancoForm');
Route::post('/reportefechabanco','BancoController@ReporteFechaBanco');
Route::post('/crearmovbanco','MovimientoBancoController@CrearMovimientoBanco');
Route::post('/movimientobancofecha','BancoController@MovimientoBancoFecha');




//rutas para la caja
Route::get('/mostrarcaja','CajaController@ListaCaja');
Route::get('/crearsaldoini','CajaController@MostrarForm');
Route::post('/crearsaldoini','CajaController@CrearSaldoIni');
Route::post('/crearcaja','CajaController@CrearCaja');
Route::get('/pdfcaja','CajaController@PdfCaja');
Route::get('/excelcaja','CajaController@ExcelCaja');
Route::get('/reportefechacaja','CajaController@ReporteFechaCajaForm');
Route::post('/reportefechacaja','CajaController@ReporteFechaCaja');
Route::post('/mostrarcajafecha','CajaController@ListaCajaFecha');
Route::get('/mostrarcajafecha','CajaController@ListaCajaFecha');
Route::get('/reportefechaentradames','CajaController@ReporteGastosForm');
Route::post('/reportefechaentradames','CajaController@ReporteGastos');
Route::get('/reportefechasalidadia','CajaController@ReporteFechaSalidaDiaForm');
Route::post('/reportefechasalidadia','CajaController@ReporteFechaSalidaDia');

//rutas para los creditos
Route::get('/mostrarcreditos/{tipo}','CreditoController@ListaCredito');
Route::get('/creditodetalladoe/{id}/{tipo}','CreditoController@CreditoDetalladoEntrada');
Route::get('/creditodetallados/{id}/{tipo}','CreditoController@CreditoDetalladoSalida');
Route::post('/crearcredito','CreditoController@CrearCredito');


//rutas para los reportes
Route::get('/crearreportesalida','SalidaController@ReporteForm');
Route::post('/salidareporte','SalidaController@ReporteFechaSalida');
Route::get('/crearreporteentrada','EntradaController@ReporteForm');
Route::post('/entradareporte','EntradaController@ReporteFechaEntrada');

//rutas para los clientes
Route::get('/mostrarclientes','ClienteController@ListaClientes');
Route::post('/crearcliente','ClienteController@CrearCliente');
Route::get('/buscarcliente/{id}','ClienteController@BuscarCliente');
Route::get('/buscarclienteci/{id}','ClienteController@BuscarClienteCi');
Route::get('/buscarclientecodigo/{id}','ClienteController@BuscarClienteCodigo');
Route::post('/updatecliente','ClienteController@UpdateCliente');
Route::delete('/eliminarcliente/{id}','ClienteController@EliminarCliente');

//rutas para los Proveedores
Route::get('/mostrarproveedores','ProveedorController@ListaProveedores');
Route::post('/crearproveedor','ProveedorController@CrearProveedor');
Route::get('/buscarproveedor/{id}','ProveedorController@BuscarProveedor');
Route::get('/buscarproveedornit/{id}','ProveedorController@BuscarProveedorNit');
Route::get('/buscarproveedorcodigo/{id}','ProveedorController@BuscarProveedorCod');
Route::post('/updateproveedor','ProveedorController@UpdateProveedor');
Route::delete('/eliminarproveedor/{id}','ProveedorController@EliminarProveedor');

//rutas para las entradas
Route::get('/mostrarentradas','EntradaController@ListaEntrada');
Route::post('/crearEntrada','EntradaController@crearEntrada');
Route::get('/reporteentrada','EntradaController@reporteEntrada');
Route::get('/entradadetallada/{id}','EntradaController@EntradaDetallada');
Route::get('/buscarentrada/{id}','EntradaController@BuscarEntrada')->middleware('can:editcompra')->name('editarcompra');
Route::get('/encontrarentradas/{id}','EntradaController@BuscarEntradas');
Route::get('/encontrarpeps/{id}','PepsController@EncontrarPeps');
Route::post('/updateentrada','EntradaController@UpdateEntrada');
Route::post('/updatedatosentrada','EntradaController@UpdateDatosEntrada');
Route::delete('/eliminarentrada/{id}','EntradaController@EliminarEntrada')->middleware('can:deletecompra')->name('eliminarcompra');
Route::get('/reportefechaentrada','EntradaController@ReporteFechaEntradaForm');
Route::post('/reportefechaentrada','EntradaController@ReporteFechaEntrada');
Route::get('/excelentrada','EntradaController@ExcelEntrada');
Route::get('/librodecompras','EntradaController@LibroDeComprasForm');
Route::post('/librodecompras','EntradaController@LibroDeCompras');

//rutas para las salidas
Route::get('/mostrarsalidas','SalidaController@Listasalida');
Route::get('/mostrarerror','SalidaController@crearSalida');
Route::get('/mostrarservicioform','SalidaController@MostrarFormServicio');
Route::post('/crearsalida','SalidaController@crearSalida');
Route::get('/reportesalida/{id}','SalidaController@ReporteSalida');
Route::get('/salidadetallada/{id}','SalidaController@SalidaDetallada');
Route::get('/reportefechasalida','SalidaController@ReporteFechaSalidaForm');
Route::post('/reportefechasalida','SalidaController@ReporteFechaSalida');
Route::get('/librodeventas','SalidaController@LibroDeVentasForm');
Route::post('/librodeventas','SalidaController@LibroDeVentas');
Route::get('/encontrarultimaventa/{id}','SalidaController@EncontrarUltimaVenta');
Route::delete('/eliminarsalida/{id}','SalidaController@EliminarSalida');

//rutas para las cotizaciones
Route::get('/mostrarcotizaciones','CotizacionController@ListaCotizacion');
Route::get('/cotizacionServicioform','CotizacionController@MostrarFormServicio');
Route::post('/crearcotizacion','CotizacionController@CrearCotizacion');
Route::get('/reportecotizacion','CotizacionController@ReporteCotizacion');
Route::get('/cotizaciondetallada/{id}','CotizacionController@CotizacionDetallada');
Route::get('/buscarcotizacion/{id}','CotizacionController@BuscarCotizacion');
Route::get('/encontrarcotizaciones/{id}','CotizacionController@BuscarCotizaciones');
Route::post('/updatecotizacion','CotizacionController@UpdateCotizacion');
Route::delete('/eliminarcotizacion/{id}','CotizacionController@EliminarCotizacion');


//rutas para las reservas
Route::get('/mostrarreservas','ReservaController@ListaReserva');
Route::get('/reservaServicioform','ReservaController@MostrarFormServicio');
Route::post('/crearreserva','ReservaController@CrearReserva');
Route::get('/reportereserva','ReservaController@ReporteReserva');
Route::get('/reservadetallada/{id}','ReservaController@ReservaDetallada');
Route::get('/buscarreserva/{id}','ReservaController@BuscarReserva');
Route::get('/encontrarreservas/{id}','ReservaController@BuscarReservas');
Route::post('/updatereserva','ReservaController@UpdateReserva');
Route::delete('/eliminarreserva/{id}','ReservaController@EliminarReserva');

//rutas para los bienes
Route::get('/mostrarbienes','BienController@ListaBien');
Route::post('/crearbien','BienController@crearBien');
Route::get('/editarbien/{id}','BienController@editarbien');
Route::post('/mostrarbienes','BienController@updatebien');

//rutas para los operadores
Route::get('/mostraroperadores','OperadorController@ListaOperador');
Route::post('/crearoperador','OperadorController@CrearOperador');
Route::get('/editaroperador/{id}','OperadorController@EditarOperador');
Route::post('/mostraroperadores','OperadorController@UpdateOperador');

//rutas para los articulos
Route::get('/encontrararticulos/{id}','ArticuloController@EncontrarArticulos');
Route::get('/encontrararticulo/{id}','ArticuloController@EncontrarArticulo');
Route::get('/encontrararticulocodigobarra/{id}','ArticuloController@EncontrarArticuloBarra');
Route::get('/encontrararticulocodigoempresa/{id}','ArticuloController@EncontrarArticuloEmpresa');
Route::get('/encontrararticulocodigoempresas/{id}/{id2}','ArticuloController@EncontrarArticuloEmpresa2');
Route::get('/encontrararticulocodigofabrica/{id}','ArticuloController@EncontrarArticuloFabrica');
Route::get('/encontrararticulocodigofabricas/{id}/{id2}','ArticuloController@EncontrarArticuloFabrica2');
Route::get('/mostrararticulos/{id}','ArticuloController@ListaArticulo');
Route::post('/creararticulo','ArticuloController@crearArticulo');
Route::get('/editararticulo/{id}','ArticuloController@editarArticulo');
Route::post('/mostrararticulos','ArticuloController@updateArticulo');
Route::get('/mostrararticuloproducto/{id}','ArticuloController@KardexArticuloProducto');
Route::post('/mostrarkardexarticuloporfecha','ArticuloController@KardexArticuloFecha');
Route::post('/mostrararticuloporfecha','ArticuloController@InventarioDetalladoFecha');
Route::post('/mostrararticuloporfechasf','ArticuloController@InventarioDetalladoFechasf');
Route::get('/mostrararticuloproductosf/{id}','ArticuloController@KardexArticuloProductosf');
Route::post('/mostrarkardexarticuloporfechasf','ArticuloController@KardexArticuloFechasf');
Route::get('/mostrarinventario','ArticuloController@ListaInventario')->middleware('can:inventario')->name('inventario');
Route::get('/mostrarinventariotodo','ArticuloController@ListaInventarioTodo')->name('inventariotodo');
Route::get('/mostrarinventariotodosaldo','ArticuloController@ListaInventarioTodoSaldo');
Route::get('/mostrarinventariotodosf','ArticuloController@ListaInventarioTodosf');
Route::get('/mostrarinventariotodosaldosf','ArticuloController@ListaInventarioTodoSaldosf');
Route::get('/inventariodetallado/{id}','ArticuloController@InventarioDetallado')->name('inventariodet');
Route::get('/mostrararticulosmenoresa','ArticuloController@ArticulosMenoresAForm');
Route::post('/mostrararticulosmenoresa','ArticuloController@ArticulosMenoresA');


