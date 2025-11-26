<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed categories
        \App\Models\Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Technology related posts'
        ]);

        \App\Models\Category::create([
            'name' => 'Business',
            'slug' => 'business',
            'description' => 'Business related posts'
        ]);

        \App\Models\Category::create([
            'name' => 'Lifestyle',
            'slug' => 'lifestyle',
            'description' => 'Lifestyle related posts'
        ]);

        // Seed tags
        \App\Models\Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        \App\Models\Tag::create([
            'name' => 'PHP',
            'slug' => 'php'
        ]);

        \App\Models\Tag::create([
            'name' => 'Web Development',
            'slug' => 'web-development'
        ]);

        // Seed books
        \App\Models\Book::factory(10)->create();

        // Seed alumni
        $this->call(AlumniSeeder::class);
    }
}
