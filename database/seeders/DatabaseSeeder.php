<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'John Wick',
        ]);
        Post::factory(3)->create([
            'user_id' => $user->id,
        ]);

        $user = User::factory()->create([
            'name' => 'Rick Morty',
        ]);
        Post::factory(3)->create([
            'user_id' => $user->id,
        ]);
    }
}
