<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pizza::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomDigitNotNull,
            'properties' => $this->faker->randomElement($array = [
                'vegan',
                'vegetarian',
                'glutenfree',
                'spicy',
                'sweet'
            ])
        ];
    }
}
