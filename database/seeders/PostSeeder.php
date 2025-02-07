<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $tagIds = Tag::pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            $post = Post::create([
                'title' => $faker->sentence,
                'content' => $faker->paragraph,
                'image' => $faker->imageUrl($width = 640, $height = 480),
                'category_id' => $faker->numberBetween($min = 1, $max = 20),
            ]);

            $randomTags = $faker->randomElements($tagIds, $faker->numberBetween(1, 5));

            $post->tags()->sync($randomTags);
        }
    }
}
