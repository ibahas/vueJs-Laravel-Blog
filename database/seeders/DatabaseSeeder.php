<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\replyComment;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::factory(10)->create();
        \App\Category::factory(10)->create();
        \App\Post::factory(10)->create();
        \App\Comment::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => str::random(10),
            'admin' => 1,
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => str::random(10),
            'admin' => 0,
        ]);
        replyComment::create([
            'Comment' => 1,
            'reply' => 'reply reply reply',
            'user' => 11,
        ]);

        replyComment::create([
            'Comment' => 2,
            'reply' => 'reply reply reply',
            'user' => 11,
        ]);
        replyComment::create([
            'Comment' => 3,
            'reply' => 'reply reply reply',
            'user' => 11,
        ]);
    }
}
