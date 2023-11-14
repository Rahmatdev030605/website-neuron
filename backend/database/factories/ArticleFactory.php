<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Article;
use App\Models\ArticleCategory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ambil semua kategori artikel yang ada
        $categories = ArticleCategory::all();

        return [
            'title' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'body' => $this->faker->text,
            'author' => $this->faker->name,
            'image' => $this->faker->imageUrl,
            'user_id' => \App\Models\User::all()->random()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
