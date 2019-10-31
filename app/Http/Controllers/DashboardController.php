<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimiento;
use App\Deudor;

class DashboardController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('jwt.auth');
    }

    public function index(Request $request) 
    {
        $egresosAll = auth()->user()->totalByType('-');
        $ingresosAll = auth()->user()->totalByType();

        $deudores = auth()->user()->deudores()->get()->sum('monto');

        $disponible = $ingresosAll['value'] - $egresosAll['value'];

        $nombre_gastos = getExpensesTypeNames();
        $gastos = [];
        foreach ($nombre_gastos as $nombre_gasto) {
			$gastos[$nombre_gasto] = auth()->user()->expenses()
										->where('gasto',$nombre_gasto)->sum('monto');
        }

        $gastosPorMes = [];
        $meses = getMonthNames();
        // {name: 'Hogar', data: {'Enero':120, 'Febrero':235, 'Marzo':352}
        foreach ($nombre_gastos as $nombre_gasto) {
			$data = [];
			for ($mes = 1; $mes <= 12 ; $mes++) { 
				$data[$meses[$mes - 1]] = auth()->user()->expenses()
											->where('gasto', $nombre_gasto)
											->whereMonth('fecha', $mes)->get()->sum('monto');
			}

	        $gastosPorMes[] = [
    			"name" => $nombre_gasto,
    			"data" => $data
    		];
		}
		
		$ingresosVsEgresosPorMes = [];
		foreach (['Ingresos', 'Egresos'] as $actividad) {
			$data = [];
        	for ($mes = 1; $mes <= 12 ; $mes++) {
				if($actividad == "Ingresos") {
					$movimiento = auth()->user()->incomes()->where('es_mensualidad',"1");
				} elseif($actividad == "Egresos") {
					$movimiento = auth()->user()->expenses()
									->whereMonth('fecha', $mes)->where('tipo','-')
									->whereNotIn('gasto',["Cambios"]);
				}

				$data[$meses[$mes - 1]] = $movimiento->get()->sum('monto');
	        }

	        $ingresosVsEgresosPorMes[] = [
    			"name" => $actividad,
    			"data" => $data
    		];
	    }

        return response()->json([
        	"ingresos" => $ingresosAll,
        	"egresos" => $egresosAll,
        	"deudores" => $deudores,
        	"balance" => $disponible + $deudores,
        	"disponible" => $disponible,
        	"transferencia" => $ingresosAll['transferencia'] - $egresosAll['transferencia'],
        	"efectivo" => $ingresosAll['efectivo'] - $egresosAll['efectivo'],
        	"chase" => $ingresosAll['chase'] - $egresosAll['chase'],
        	"banpan" => $ingresosAll['banpan'] - $egresosAll['banpan'],
        	"bofa" => $ingresosAll['bofa'] - $egresosAll['bofa'],
        	"gastos" => $gastos,
			"gastosPorMes" => $gastosPorMes,
			"ingresosVsEgresosPorMes" => $ingresosVsEgresosPorMes
		], 200);
    }
}
