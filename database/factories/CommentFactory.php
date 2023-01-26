<?php
namespace Database\Factories;

use App\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            return [
                'body' => fake()->paragraph(rand(10, 30)),
                'user_id' => rand(1,10),
                'post_id' => rand(1,10)
            ];
    }
}
