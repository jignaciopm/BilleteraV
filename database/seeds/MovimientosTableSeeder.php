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
            'tipo'		  => '-',
            'monto' 	  => '100',
            'medio'       => 'Efectivo',
            'gasto'       => 'Comisiones'
        )); 

        Movimiento::create(array(
            'id_user'     => '1',
            'fecha'		  => now(),
            'concepto'	  => 'Demo',
            'tipo'		  => '-',
            'monto' 	  => '100',
            'medio'       => 'Efectivo',
            'gasto'       => 'Medicinas'
        )); 
    }
}
