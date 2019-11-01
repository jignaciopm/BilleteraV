<?php

use Illuminate\Http\Request;
use Carbon\Carbon;

function paginateCollection($items, $perPage = 15, $page = null, $options = [])
{
    $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
    return new \Illuminate\Pagination\LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    //ref for array_values() fix: https://stackoverflow.com/a/38712699/3553367
}

function containSearch($search, $string)
{
    return preg_match("/".strtolower($search)."/", strtolower($string));
}

function filtersModel($model, Request $request)
{
    if($request->has('fecha'))
    {
        $fecha = $request->get('fecha');
        $model = $model->where('fecha',$fecha);
    }

    if($request->has('tipo'))
    {
        $tipo = $request->get('tipo');
        if($tipo == "incomes" || $tipo == "+")
            $model = $model->where('tipo','+');
        else
        {
            if($tipo == "expenses" || $tipo == "-")
                $model = $model->where('tipo','-');
        }
    }

    if($request->has('medio'))
    {
        $medio = $request->get('medio');
        $model = $model->where('medio',$medio);
    }

    if($request->has('banco'))
    {
        $banco = $request->get('banco');
        $model = $model->where('banco',$banco);
    }

    if($request->has('gasto'))
    {
        $gasto = $request->get('gasto');
        $model = $model->where('gasto',$gasto);
    }

    if($request->has('es_mensualidad'))
    {
        $es_mensualidad = $request->get('es_mensualidad');
        $model = $model->where('es_mensualidad',$es_mensualidad);
    }

    if($request->has('mes'))
    {
        $mes = $request->get('mes');
        if(strtolower($mes) == "enero" || $mes == 1)
            $model = $model->whereMonth('fecha','01');
        elseif(strtolower($mes) == "febrero" || $mes == 2)
            $model = $model->whereMonth('fecha','02');
        elseif(strtolower($mes) == "marzo" || $mes == 3)
            $model = $model->whereMonth('fecha','03');
        elseif(strtolower($mes) == "abril" || $mes == 4)
            $model = $model->whereMonth('fecha','04');
        elseif(strtolower($mes) == "mayo" || $mes == 5)
            $model = $model->whereMonth('fecha','05');
        elseif(strtolower($mes) == "junio" || $mes == 6)
            $model = $model->whereMonth('fecha','06');
        elseif(strtolower($mes) == "julio" || $mes == 7)
            $model = $model->whereMonth('fecha','07');
        elseif(strtolower($mes) == "agosto" || $mes == 8)
            $model = $model->whereMonth('fecha','08');
        elseif(strtolower($mes) == "septiembre" || $mes == 9)
            $model = $model->whereMonth('fecha','09');
        elseif(strtolower($mes) == "octubre" || $mes == 10)
            $model = $model->whereMonth('fecha','10');
        elseif(strtolower($mes) == "noviembre" || $mes == 11)
            $model = $model->whereMonth('fecha','11');
        elseif(strtolower($mes) == "diciembre" || $mes == 12)
            $model = $model->whereMonth('fecha','12');
    }

    if($request->has('anio'))
    {
        $anio = $request->get('anio');
        $model = $model->whereYear('fecha',$anio);
    }
    else
        $model = $model->whereYear('fecha', Carbon::now()->format("Y"));

    return $model;
}

/*function ($movimientos) {
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
}*/