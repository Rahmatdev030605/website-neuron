<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portofolio;

class PortofolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'customer_name' => $this->faker->name,
            'desc' => $this->faker->sentence,
            'link' => $this->faker->url,
            'created_at' => $this->faker->date,
            'image' => $this->faker->imageUrl,
            'our_solution' => $this->faker->paragraph,
            'details' => $this->faker->text,
            'successProject' => $this->faker->randomElement(['true', 'false']),
            'service_id' =>  $this->faker->randomElement([1,2,3,4,5]),
        ];
    }
}
