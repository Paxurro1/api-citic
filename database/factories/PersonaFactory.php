<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'email' => $this->faker->email,
            'nombre' => $this->faker->name,
            'pass' => Hash::make('patata'),
            'f_nac' => $this->faker->date('d-m-Y', '01-01-2003'),
            'ciudad' => $this->faker->city,
            'descripcion' => $this->faker->text(255),
            'tipo_relacion' => $this->faker->randomElement(['Seria', 'Esporádica', 'Indiferente']),
            'tieneHijos' => rand(0,1),
            'quiereHijos' => rand(0,1),
            'foto' => '',
            'conectado' => 0,
            'activo' => 0,
            'tema' => rand(0,1),
            'id_genero' => rand(0,1)
        ];
    }
}
