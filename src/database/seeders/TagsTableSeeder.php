<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Ruby'],
            ['name' => 'Ruby on Rails'],
            ['name' => 'PHP'],
            ['name' => 'Laravel'],
            ['name' => 'CakePHP'],
            ['name' => 'Python'],
            ['name' => 'Django'],
            ['name' => 'FastAPI'],
            ['name' => 'JavaScript'],
            ['name' => 'TypeScript'],
            ['name' => 'jQuery'],
            ['name' => 'Vue.js'],
            ['name' => 'Nuxt.js'],
            ['name' => 'React'],
            ['name' => 'Next.js'],
            ['name' => 'AWS'],
            ['name' => 'heroku'],
            ['name' => 'Firebase'],
            ['name' => 'Docker'],
        ];

        DB::table('tags')->insert($tags);
    }
}
