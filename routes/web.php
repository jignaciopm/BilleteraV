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

use App\Movimiento;

Route::get('/', function () {
    return redirect()->route("login");
});

Auth::routes();

Route::prefix('/home')->group(function(){

	Route::get('/','HomeController@index')->name('home');

	Route::prefix('/movimientos')->group(function(){

		Route::get('/', 'MovimientosController@index')
		->name('movimientos.like');

		Route::get('/registrar', 'MovimientosController@registrarMovimiento')
		->name('registrar-movimiento');

		Route::post('/registrar', 'MovimientosController@registrarMovimientoPost')
		->name('registrar-movimiento-post');

		Route::prefix('/view/{id}')->group(function(){

			Route::get('/', 'MovimientosController@modificarMovimiento')
			->name('modificar-movimiento');

			Route::post('/', 'MovimientosController@modificarMovimientoPost')
			->name('modificar-movimiento-post');

		});

		Route::get('/serial/{serial}',function($serial){
			$movimiento = Movimiento::where("id","=",12)->select("referencia")->get();
			//$movimiento = Movimiento::where("referencia->ref_serial","=",encrypt($serial))->get();
			return $movimiento;
		});

	});

	Route::prefix('/deudores')->group(function(){

		Route::get('/registrar', 'DeudoresController@registrarDeudor')
		->name('registrar-deudor');

		Route::post('/registrar', 'DeudoresController@registrarDeudorPost')
		->name('registrar-deudor-post');

		Route::get('/saldar/{idDeudor}', 'DeudoresController@saldarDeudor')
		->name('saldar-deudor');

		Route::post('/saldar/{idDeudor}', 'DeudoresController@saldarDeudorPost')
		->name('saldar-deudor-post');

	});

});
