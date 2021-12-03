<?php

namespace Database\Factories;

use App\Models\PreferenciaPersona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreferenciaPersonaFactory extends Factory
{
    protected $model = PreferenciaPersona::class;
    public static $EMAIL;
    public static $ID;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'email' => self::$EMAIL,
            'id_preferencia' => self::$ID,
            'intensidad' => rand(0,100)
        ];
    }
}
