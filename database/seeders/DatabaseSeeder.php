<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\ReadingInterval;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reading intervals for the scenario example
        $readingIntervals = [
            ['user_id' => 1, 'book_id' => 1, 'start_page' => 10, 'end_page' => 30],
            ['user_id' => 2, 'book_id' => 1, 'start_page' => 2, 'end_page' => 25],
            ['user_id' => 1, 'book_id' => 2, 'start_page' => 40, 'end_page' => 50],
            ['user_id' => 3, 'book_id' => 2, 'start_page' => 1, 'end_page' => 10],
        ];
        User::factory(10)->create();
        User::factory(10)->create();
        Book::factory(10)->create();
        ReadingInterval::insert($readingIntervals);
    }
}
