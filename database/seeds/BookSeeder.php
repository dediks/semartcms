<?php

use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Book::class, 50)->create()->each(function ($book) {
            $book->categories()->save(factory(App\Category::class)->make());
        });
    }
}
