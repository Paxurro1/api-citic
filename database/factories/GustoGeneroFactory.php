<?php

namespace Database\Factories;

use App\Models\GustoGenero;
use Illuminate\Database\Eloquent\Factories\Factory;

class GustoGeneroFactory extends Factory
{
    protected $model = GustoGenero::class;
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
            'email'=>self::$EMAIL,
            'id_genero'=>self::$ID
        ];
    }
}
