<?php

use Illuminate\Database\Seeder;

use App\Movimiento;

class MovimientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movimiento::create(array(
            'id_user'     => '1',
            'fecha'		  => now(),
            'concepto'	  => 'Demo',
            'tipo'		  => '+',
            'monto' 	  => Hash::make('200') // Hash::make() nos va generar una cadena con nuestra contraseña encriptada
        )); 
    }
}
