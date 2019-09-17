<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConjuntoController extends Controller
{
    public function registrarConjunto()
    {
    	return view("auth.conjunto.registrar-conjunto");
    }
}
