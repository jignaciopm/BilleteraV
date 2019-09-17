<?php

namespace App\Http\Controllers;

use App\Http\Helper;

use Illuminate\Http\Request;

use App\Movimiento;

use App\Deudor;

use Route;

use Validator;

use Carbon\Carbon;


class MovimientosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('jwt.auth'/*, ['except' => ['login']]*/);
    }

    public function index(Request $request, $user_id = null)
    {
        $movimientos = Movimiento::where('id','>=',1);
        $limit = $request->get('limit') ? $request->get('limit') : 10;

        $movimientos = filtersModel($movimientos, $request);

        // Como el concepto esta encrypt, no podemos hacer uso de where(.., like, ..)
        if($request->has('search'))
        {
            $search = $request->get('search');
            $movimientosSearch = [];
            foreach($movimientos->get() as $movimiento)
            {
                // $movimiento->concepto posee un Accessor para decrypt su contenido
                if(containSearch($search, $movimiento->concepto))
                    $movimientosSearch[] = $movimiento;
            }

            return response()->json(paginateCollection($movimientosSearch, $limit));
        }

        return response()->json($movimientos->paginate($limit));
    }

    public function amountTotal(Request $request)
    {
        $movimientos = Movimiento::where('id','>=',1);

        /*
        if($user_id != null)
            $movimientos = $movimientos->where('id_user',$user_id);
        */

        $movimientos = filtersModel($movimientos, $request);

        return response()->json($movimientos->get()->sum('monto'));
    }

    public function registrarMovimiento()
    {
    	return view("auth.movimientos.registrar-movimiento");
    }

    public function registrarMovimientoPost(Request $request)
    {
    	$reglas = [
			'fecha' => 'required|date_format:Y-m-d',
			'concepto' => 'required|string',
	        'tipo' => 'required|in:+,-',
	        'monto' => 'required|numeric',
            'medio' => 'required|in:efectivo,transferencia'
	    ];

        if($request['tipo'] == "-")
            $reglas['gasto'] = "required|in:Hogar,Carro,Medicinas,Ayuda familiar,Salida,Comisiones,Cambios,Prestamos,Otros";

        if($request['medio'] == "transferencia")
            $reglas['banco'] = "required|in:BanPan,Chase,BofA";

        $credentials = $this->validate(request(), $reglas);

        $newMovimiento = [
            'id_user'     => (int)auth()->user()->id,
            'fecha'		  => $credentials["fecha"],
            'concepto'	  => $credentials["concepto"],
            'tipo'		  => $credentials["tipo"],
            'monto' 	  => $credentials["monto"],
            'medio'       => $credentials["medio"]
        ];

        if($credentials["tipo"] == "-")
        	$newMovimiento["gasto"] = $credentials["gasto"];
        
        if($credentials['medio'] == "transferencia")
        	$newMovimiento["banco"] = $credentials["banco"];

	    $movimiento = Movimiento::create($newMovimiento);

        if(isset($request['deudor']))
        {
            $idDeudor = $request['deudor'];
            $deudorById = Deudor::where('id',$idDeudor);

            if($deudorById->first())
                $deudorById->delete();
        }

        session()->flash("success-registrar-movimiento", "");
        return redirect()->route("registrar-movimiento");
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'fecha' => 'required|date_format:Y-m-d',
                'concepto' => 'required|string',
                'tipo' => 'required|in:+,-',
                'monto' => 'required|numeric',
                'medio' => 'required|in:efectivo,transferencia'
            ];
    
            if($request['tipo'] == "-")
                $rules['gasto'] = "required|in:Hogar,Carro,Medicinas,Ayuda familiar,Salida,Comisiones,Cambios,Prestamos,Otros";
    
            if($request['medio'] == "transferencia")
                $rules['banco'] = "required|in:BanPan,Chase,BofA";
    
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) 
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
        
            $movimiento = new Movimiento();

            $movimiento->fecha = $request["fecha"];
            $movimiento->concepto = $request["concepto"];
            $movimiento->tipo = $request["tipo"];
            $movimiento->monto = $request["monto"];
            $movimiento->medio = $request["medio"];
    
            if($request["tipo"] == "-")
                $movimiento->gasto = $request["gasto"];
            
            if($request['medio'] == "transferencia")
                $movimiento->banco = $request["banco"];
    
            if( $movimiento->user()->associate(auth()->user()) )
                $movimiento->save();
        } 
        catch (\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()],500);
        }

        return response()->json(['success' => true, 'movimiento' => $movimiento]);
    }

    public function modificarMovimiento($id)
    {
        $movimiento = Movimiento::where("id","=",$id)->first();

        $movimiento["concepto"] = decrypt($movimiento["concepto"]);
        $movimiento["monto"] = decrypt($movimiento["monto"]);

        return view("auth.movimientos.modificar-movimiento")->with("movimiento",$movimiento);
    }

    public function modificarMovimientoPost($id, Request $request)
    {
        $reglas = [
            'fecha' => 'required|date_format:Y-m-d',
            'concepto' => 'required|string',
            'tipo' => 'required|in:+,-',
            'monto' => 'required|numeric'
        ];

        $referenciasEcrypt = [];
        $referencias = $request["referencia"];

        foreach ($referencias as $primaryKey => $referencia) {
            foreach ($referencia as $key => $value) {
                if($key == "denominacion" && $value == null)
                    $reglas["referencia[".$primaryKey."][".$key."]"] = 'required|numeric';
                elseif($key == "serial" && $value == null)
                    $reglas["referencia[".$primaryKey."][".$key."]"] = 'required|string';

                $referenciasEcrypt[$primaryKey][$key] = encrypt($value);
            }
        }

        $credentials = $this->validate(request(), $reglas);

        $movimiento = Movimiento::where("id", "=", $id)->update(array(
            'referencia'  => json_encode($referenciasEcrypt)
        ));

        session()->flash("success-registrar-movimiento", "");
        return redirect()->route("modificar-movimiento", $id);
    }
}
