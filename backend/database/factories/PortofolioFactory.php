<?php

namespace Database\Factories;

use App\Models\Portofolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortofolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $portofolio = Portofolio::all();

        return [
            'name' => $this->faker->word,
            'category' => $this->faker->randomElement(['Web App', 'Mobile App', 'Workflow Management System', 'System Integrator', 'Business Intelligence', 'CRM App']),
            'customer_name' => $this->faker->name,
            'desc' => $this->faker->sentence,
            'link' => $this->faker->url,
            'date' => $this->faker->date,
            'image' => $this->faker->imageUrl,
            'our_solution' => $this->faker->paragraph,
            'details' => $this->faker->text,
            'successProject' => $this->faker->randomElement(['true', 'false']),
            'service_id' => Portofolio::factory(),
        ];
    }
}
