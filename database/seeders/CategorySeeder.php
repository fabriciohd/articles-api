<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'PHP',
            'coverUrl' => 'storage/phpcover.jpg',
        ]);
        DB::table('categories')->insert([
            'name' => 'VUE',
            'coverUrl' => 'storage/vuecover.jpg',
        ]);
    }
}
