<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'title' => str_random(60),
            'author' => str_random(60),
            'pages' => rand(1, 1000),
            'marker' => 1,
            'user_id' => 1

        ]);        
    }
}
