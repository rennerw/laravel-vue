<?php

use Illuminate\Database\Seeder;
//use Faker\Generator;

class ArtigoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = new Faker\Generator();
        for ($i=0; $i < 36; $i++) { 
            DB::table('artigos')->insert([
                'titulo' => "Titulo ".$i,
                'texto' => "Texto asdaksidji asdiaosoidm asm ".$i,
            ]);
        }
    }
}
