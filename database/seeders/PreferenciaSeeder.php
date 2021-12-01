<?php

namespace Database\Seeders;

use App\Models\Preferencia;
use Illuminate\Database\Seeder;

class PreferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Preferencia::create([
            'descripcion' => 'Deporte'
        ]);
        Preferencia::create([
            'descripcion' => 'Arte'
        ]);
        Preferencia::create([
            'descripcion' => 'Política'
        ]);
        Preferencia::create([
            'descripcion' => 'Música'
        ]);
        Preferencia::create([
            'descripcion' => 'Viajar'
        ]);
    }
}
