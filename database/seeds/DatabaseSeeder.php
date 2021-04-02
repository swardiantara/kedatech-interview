<?php

namespace Database\Seeders;
// use Database\Seeders\UserTypeSeeder;
// use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UserTypeSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([MessageSeeder::class]);
        $this->call([ReportSeeder::class]);
    }
}
