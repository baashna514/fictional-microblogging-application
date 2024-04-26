<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        return [
//            'post_id' => \App\Models\Post::factory(),
//            'user_id' => \App\Models\User::factory(),
//        ];

        return [
            'user_id' => \App\Models\User::factory(),
            'favoritable_id' => function () {// Generate a random post ID
                return \App\Models\Post::inRandomOrder()->first()->id;
            },
            'favoritable_type' => \App\Models\Post::class,
        ];
    }
}
