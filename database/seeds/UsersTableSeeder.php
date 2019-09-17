<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'email'     => 'jignaciopm13@gmail.com',
            'name'=> 'José Ignacio',
            'password' => Hash::make('13031995') // Hash::make() nos va generar una cadena con nuestra contraseña encriptada
        ));    }
}
