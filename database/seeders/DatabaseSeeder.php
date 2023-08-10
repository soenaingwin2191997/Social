<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(500)->create();
        Post::factory(100)->create();
        Like::factory(1000)->create();
        Comment::factory(1000)->create();

        \App\Models\User::factory()->create([
            'name' => "Soe Naing Win",
            'email' => "user@gmail.com",
            'profile_photo'=>"photo".rand(1,100).".jpg",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
