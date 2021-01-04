<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        \App\Models\Group::factory(3)->create();


        \App\Models\Level::factory()->create(['name'=>'gold']);
        \App\Models\Level::factory()->create(['name'=>'silver']);
        \App\Models\Level::factory()->create(['name'=>'bronze']);

    }
}
