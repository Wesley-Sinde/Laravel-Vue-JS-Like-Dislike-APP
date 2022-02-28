<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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

        $factory->define(Post::class, function (Faker $faker) {
            return [
                'title' => $faker->sentence,
                'slug' => \Str::slug($faker->sentence),
                'user_id' => 1
            ];
        });
    }
}

/** @var \Illuminate\Database\Eloquent\Factory $factory */

