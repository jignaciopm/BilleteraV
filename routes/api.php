<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::prefix('/dashboard')->middleware('api')->group(function(){

    Route::get('/', 'DashboardController@index');

});

Route::prefix('/movimientos')->middleware('api')->group(function(){

    Route::get('/', 'MovimientosController@index');

    Route::get('/monto-total', 'MovimientosController@amountTotal');

    Route::post('/', 'MovimientosController@store');

    /*Route::get('/registrar', 'MovimientosController@registrarMovimiento')
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
    });*/

});

/*Route::prefix('/home')->group(function(){

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

});*/
