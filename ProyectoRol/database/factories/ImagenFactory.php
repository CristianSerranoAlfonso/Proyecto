<?php

namespace Database\Factories;

use App\Models\Aventura;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as faker;

class AventuraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Aventura::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nombre"=>$this->faker->name
        ];
    }
}
