<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favorite::factory()
            ->count(5)
            ->create();

        // Seed favorites for users
        $users = User::all();
        foreach ($users as $user) {
            $randomUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
            $user->favorites()->create([
                'favoritable_id' => $randomUser->id,
                'favoritable_type' => User::class,
            ]);
        }
    }
}
