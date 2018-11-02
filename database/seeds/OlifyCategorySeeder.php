<?php

use Illuminate\Database\Seeder;

class OlifyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 100)->create();
    }
}
