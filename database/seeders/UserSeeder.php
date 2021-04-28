<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'adminAlpha',
            'email' => 'admin@hotmail.com',
            'description' => 'Administrador para primeira conta, recomenda-se apaga-lo depois',
            'password' => password_hash(123, PASSWORD_DEFAULT),
            'approved' => true,
            'adm' => true,
        ]);
    }
}
