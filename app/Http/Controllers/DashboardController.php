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
        $this->middleware('jwt.auth'/*, ['except' => ['login']]*/);
    }

    public function index(Request $request) 
    {
    	$movimientos = Movimiento::where('id','>=',1);
    	$deudores = Deudor::where('id','>=',1);

        $egresos = clone $movimientos;
        $egresos = $egresos->where('tipo','-')->get()->sum('monto');
        $ingresos = $movimientos->where('tipo','+')->get()->sum('monto');

        $disponible = $ingresos - $egresos;

        $deudores = $deudores->get()->sum('monto');

        return [

        	"balance" => $disponible + $deudores,
        	"disponible" => $disponible,
        	"deudores" => $deudores

        ];
    }
}
