<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Deudor;

use App\Movimiento;

class DeudoresController extends Controller
{
    public function registrarDeudor()
    {
    	return view("auth.deudores.registrar-deudor");
    }

    public function registrarDeudorPost(Request $request)
    {
    	$credentials = $this->validate(request(), [
			'concepto' => 'required|string',
	        'monto' => 'required|numeric',
            'deudor' => 'required|string'
	    ]);

	    $deudor = Deudor::create(array(
            'id_user'     => (int)auth()->user()->id,
            'concepto'	  => $credentials["concepto"],
            'monto' 	  => $credentials["monto"],
            'deudor'  => $credentials["deudor"]
        ));

        session()->flash("success-registrar-deudor", "");
        return redirect()->route("registrar-deudor");
    }   

    public function saldarDeudor($idDeudor)
    {
        $deudor = Deudor::where('id',$idDeudor)->first();
        $deudor["concepto"] = $deudor["concepto"];
        $deudor["monto"] = $deudor["monto"];
        $deudor["deudor"] = $deudor["deudor"];
        return view("auth.movimientos.registrar-movimiento")
                ->with("deudor", $deudor);
    } 

    public function saldarDeudorPost($idDeudor, Request $request)
    {
        $reglas = [
            'fecha' => 'required|date_format:Y-m-d',
            'concepto' => 'required|string',
            'tipo' => 'required|in:+,-',
            'monto' => 'required|numeric',
            'medio' => 'required|in:efectivo,transferencia',
        ];

        $credentials = $this->validate(request(), $reglas);

        $movimiento = Movimiento::create(array(
            'id_user'     => (int)auth()->user()->id,
            'fecha'       => $credentials["fecha"],
            'concepto'    => $credentials["concepto"],
            'tipo'        => $credentials["tipo"],
            'monto'       => $credentials["monto"],
            'medio'       => $credentials["medio"]
        ));

        Deudor::where('id',$idDeudor)->delete();
        return redirect()->route("home");
    }
}
