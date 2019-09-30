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
    	$movimientos = Movimiento::where('id','>=',1);
    	$deudores = Deudor::where('id','>=',1);

        $egresos = clone $movimientos;
        $egresos = $egresos->where('tipo','-')->get();

        $egresosAll = [
			"value" => $egresos->sum('monto'),
			"value_sin" => [
				"cambios" => $egresos->whereNotIn('gasto',["Cambios"])->sum('monto')
			],
        	"transferencia" => $egresos->where('medio','transferencia')->sum('monto'),
        	"efectivo" => $egresos->where('medio','efectivo')->sum('monto'),
        	"chase" => $egresos->where('medio','transferencia')->where('banco','Chase')->sum('monto'),
        	"banpan" => $egresos->where('medio','transferencia')->where('banco','BanPan')->sum('monto'),
        	"bofa" => $egresos->where('medio','transferencia')->where('banco','bofa')->sum('monto')
        ];

        $ingresos = $movimientos->where('tipo','+')->get();

        $ingresosAll = [
			"value" => $ingresos->sum('monto'),
			"value_con" => [
				"es_mensualidad" => $ingresos->where('es_mensualidad',"1")->sum('monto')
			],
        	"transferencia" => $ingresos->where('medio','transferencia')->sum('monto'),
        	"efectivo" => $ingresos->where('medio','efectivo')->sum('monto'),
        	"chase" => $ingresos->where('medio','transferencia')->where('banco','Chase')->sum('monto'),
        	"banpan" => $ingresos->where('medio','transferencia')->where('banco','BanPan')->sum('monto'),
        	"bofa" => $ingresos->where('medio','transferencia')->where('banco','bofa')->sum('monto')
        ];

        $deudores = $deudores->get()->sum('monto');

        $disponible = $ingresosAll['value'] - $egresosAll['value'];

        $nombre_gastos = ['Hogar','Carro', 'Medicinas', 'Ayuda familiar', 'Salida', 'Comisiones', 'Cambios', 'Prestamos', 'Otros'];
        $gastos = [];
        foreach ($nombre_gastos as $nombre_gasto) {
        	$gastos[$nombre_gasto] = $egresos->where('gasto',$nombre_gasto)->sum('monto');
        }

        $gastosPorMes = [];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        // {name: 'Hogar', data: {'Enero':120, 'Febrero':235, 'Marzo':352}
        foreach ($nombre_gastos as $nombre_gasto) {
        	$mes = 1;
        	$data = [];
        	while ($mes <= 12) {
        		$data[$meses[$mes - 1]] = Movimiento::where('tipo','-')->where('gasto', $nombre_gasto)->whereMonth('fecha', $mes)->get()->sum('monto');
        		$mes++;
	        }

	        $gastosPorMes[] = [
    			"name" => $nombre_gasto,
    			"data" => $data
    		];
		}
		
		$ingresosVsEgresosPorMes = [];
		foreach (['Ingresos', 'Egresos'] as $actividad) {
        	$mes = 1;
			$data = [];

        	while ($mes <= 12) {
				$movimiento = Movimiento::whereMonth('fecha', $mes);

				if($actividad == "Ingresos")
					$movimiento = $movimiento->where('tipo','+')->where('es_mensualidad',"1");
				elseif($actividad == "Egresos")
					$movimiento = $movimiento->where('tipo','-')->whereNotIn('gasto',["Cambios"]);

				$data[$meses[$mes - 1]] = $movimiento->get()->sum('monto');
        		$mes++;
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
