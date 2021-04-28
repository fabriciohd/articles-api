<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText($maxNbChars = 15, $indexSize = 1),
            'resume' => $this->faker->realText($maxNbChars = 120, $indexSize = 1),
            'coverUrl' => $this->faker->image(storage_path()),
            'content' => $this->faker->realText($maxNbChars = 2500, $indexSize = 5),
            'userId' => rand(1, 6),
            'categoryId' => rand(1, 2),
        ];
    }
}
