<?php

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
        // $this->call(UniversitySeeder::class);
        // $this->call(FacultySeeder::class);
        $this->call(AdminSeeder::class);
    }
}
