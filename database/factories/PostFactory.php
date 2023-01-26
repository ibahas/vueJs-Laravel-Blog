<?php

namespace Database\Factories;

use App\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence(rand(4, 8));
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraph(rand(1, 3)),
            'user_id' => Rand(1, 10),
            'category_id' => Rand(1, 10),
            'photo' => fake()->randomElement([url('/') . 'storage/2.png', url('/') .  'storage/1.png']),
        ];
    }
}
