<?php

namespace Database\Seeders;

use App\Models\GustoGenero;
use Illuminate\Database\Seeder;
use App\Models\Persona;
use App\Models\Preferencia;
use App\Models\PreferenciaPersona;
use App\Models\RolAsig;
use Database\Factories\GustoGeneroFactory;
use Database\Factories\PreferenciaPersonaFactory;
use Database\Factories\RolAsigFactory;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 0; $i < 50; $i++) {
            $pers = Persona::factory()->create();
            $email = $pers->email;
            RolAsigFactory::$EMAIL = $email;
            RolAsig::factory()->create();
            GustoGeneroFactory::$EMAIL = $email;
            if ($i % 2 == 0 || $i % 3 == 0) {
                GustoGeneroFactory::$ID = 1;
                GustoGenero::factory()->create();
            }
            if ($i % 2 != 0 || $i % 3 == 0) {
                GustoGeneroFactory::$ID = 2;
                GustoGenero::factory()->create();
            }

            for ($j = 1; $j <= Preferencia::all()->count(); $j++) {
                PreferenciaPersonaFactory::$EMAIL = $email;
                PreferenciaPersonaFactory::$ID = $j;
                PreferenciaPersona::factory()->create();
            }
        }
    }
}
