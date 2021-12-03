<?php

namespace Database\Factories;

use App\Models\RolAsig;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolAsigFactory extends Factory
{
    protected $model = RolAsig::class;
    public static $EMAIL;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'id_rol'=>1,
            'email'=>self::$EMAIL

        ];
    }
}
