<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Genero::create([
            'descripcion' => 'Hombre'
        ]);
        Genero::create([
            'descripcion' => 'Mujer'
        ]);
    }
}
