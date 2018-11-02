<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(LinksTableSeeder::class);
        $this->call(OlifyCategorySeeder::class);
        $this->call(OlifyMarketSeeder::class);
        $this->call(OlifyProductSeeder::class);
    }
}