<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'body' => $this->faker->text,
            'author' => $this->faker->name,
            'image' => $this->faker->imageUrl,
            'user_id' => \App\Models\User::all()->random()->id,
            'articles_categories_id' => \App\Models\ArticleCategory::all()->random()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
