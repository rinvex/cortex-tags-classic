<?php

declare(strict_types=1);

namespace Cortex\Tags\Database\Factories;

use Cortex\Tags\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [$this->faker->languageCode => $this->faker->title],
            'slug' => $this->faker->slug,
        ];
    }
}
