<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Movimiento;

use App\User;

use App\Conjunto;

use App\Deudor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disponible = 0;
        $efectivo = 0;
        $transferencia = 0;
        $bancos = [
            'Chase' => 0,
            'BanPan' => 0,
            'BofA' => 0
        ];
        $movimientosPorMes = [];

        // Movimientos del usuario logueado

        $movimientos = Movimiento::where('id_user',auth()->user()->id)
                        ->orderBy('fecha', 'DESC')->get();
        foreach ($movimientos as $movimiento) 
        {
            if($movimiento["medio"] == "efectivo")
            {
                $movimiento["monto"] = $movimiento["monto"];
                if ($movimiento["tipo"] == "+") {
                    $efectivo += $movimiento["monto"];
                }
                elseif ($movimiento["tipo"] == "-") {
                    $efectivo -= $movimiento["monto"];
                }
            }
            elseif($movimiento["medio"] == "transferencia")
            {
                $movimiento["monto"] = $movimiento["monto"];
                if ($movimiento["tipo"] == "+") {
                    $transferencia += $movimiento["monto"];
                    $bancos[$movimiento['banco']] += $movimiento["monto"];
                }
                elseif ($movimiento["tipo"] == "-") {
                    $transferencia -= $movimiento["monto"];
                    $bancos[$movimiento['banco']] -= $movimiento["monto"];
                }
            }

            $anio = date('Y',strtotime($movimiento['fecha']));
            $mes = date('m',strtotime($movimiento['fecha']));

            $movimientosPorMes[$anio][$mes][] = $movimiento;
        }

        $disponible = $efectivo + $transferencia;

        $b_conjunto = 0;

        // Movimientos deudores del usuario logueado

        $b_deudores = 0;
        $deudores = Deudor::where('id_user',auth()->user()->id)->get();
        foreach ($deudores as $deudor) 
            $b_deudores += $deudor["monto"];

        $balance = $disponible + $b_conjunto + $b_deudores;

        ksort($movimientosPorMes);
        ksort($movimientosPorMes['2019']);
        foreach ($movimientosPorMes as $keyAnio => $anio)
        {
            foreach ($anio as $keyMes => $mes)
            {
                $ingresos = 0;
                $egresos = 0;
                $gastosHogar = 0;
                $gastosCarro = 0;
                $gastosSalida = 0;
                $gastosAyuda = 0;
                $gastosMedicina = 0;
                $otrosGastos = 0;

                if(intval($keyMes) < 10)
                {
                    if(isset($movimientosPorMes[$keyAnio]['0'.strval(intval($keyMes)-1)]['disponible']))
                        $disponibleMensual = $movimientosPorMes[$keyAnio]['0'.strval(intval($keyMes)-1)]['disponible'];
                    else
                        $disponibleMensual = 0;
                }
                else
                {
                    if(isset($movimientosPorMes[$keyAnio][strval(intval($keyMes)-1)]['disponible']))
                        $disponibleMensual = $movimientosPorMes[$keyAnio][strval(intval($keyMes)-1)]['disponible'];
                    else
                        $disponibleMensual = 0;
                }

                foreach ($mes as $movimiento)
                {
                    if($movimiento["tipo"] == "-") {
                        $egresos += $movimiento["monto"];

                        if ($movimiento["gasto"] == "Hogar")
                            $gastosHogar += $movimiento["monto"];
                        elseif ($movimiento["gasto"] == "Carro")
                            $gastosCarro += $movimiento["monto"];
                        elseif ($movimiento["gasto"] == "Salida")
                            $gastosSalida += $movimiento["monto"];
                        elseif ($movimiento["gasto"] == "Ayuda familiar")
                            $gastosAyuda += $movimiento["monto"];
                        elseif ($movimiento["gasto"] == "Medicinas")
                            $gastosMedicina += $movimiento["monto"];
                        elseif ($movimiento["gasto"] == "Otros")
                            $otrosGastos += $movimiento["monto"];
                    }
                    elseif($movimiento["tipo"] == "+") {
                        $ingresos += $movimiento["monto"];
                    }
                }

                $movimientosPorMes[$keyAnio][$keyMes]['ingresos'] = $ingresos;
                $movimientosPorMes[$keyAnio][$keyMes]['egresos'] = $egresos;
                $movimientosPorMes[$keyAnio][$keyMes]['gastosHogar'] = $gastosHogar;
                $movimientosPorMes[$keyAnio][$keyMes]['gastosCarro'] = $gastosCarro;
                $movimientosPorMes[$keyAnio][$keyMes]['gastosSalida'] = $gastosSalida;
                $movimientosPorMes[$keyAnio][$keyMes]['gastosAyuda'] = $gastosAyuda;
                $movimientosPorMes[$keyAnio][$keyMes]['gastosMedicina'] = $gastosMedicina;
                $movimientosPorMes[$keyAnio][$keyMes]['otrosGastos'] = $otrosGastos;
                $movimientosPorMes[$keyAnio][$keyMes]['disponible'] = $disponibleMensual + $ingresos - $egresos;
            }
        }

        return view('home')
                ->with("movimientos",$movimientos)
                ->with("balance",$balance)
                ->with("disponible",$disponible)
                ->with("b_conjunto",$b_conjunto)
                ->with("deudores",$deudores)
                ->with("b_deudores",$b_deudores)
                ->with("efectivo",$efectivo)
                ->with("transferencia",$transferencia)
                ->with("movimientosPorMes",$movimientosPorMes)
                ->with("bancos",$bancos);
    }
}
