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


        \App\Models\User::factory(5)->create()->each(function($user) {
            $profile = $user->profile()->save(\App\Models\User::factory()->make());
            $profile->location()->save(\App\Models\Location::factory()->make());

            $user->groups()->attach($this->arrayNum(rand(1,3)));

            $user->image()->save(\App\Models\Image::factory()
                        ->make(['url'=>$this->getAvatar(['men','women'],rand(1,99))]));
        });


        \App\Models\Category::factory(4)->create();
        \App\Models\Tag::factory(12)->create();



    }

    private function arrayNum($max) {
        $values = [];

        for ($i=0; $i < $max; $i++) { 
            $values[] = $i;
        }

        return $values;
    }

    private function getPic($max) {
        return 'https://picsum.photos/id/'.$max.'/1024/';
    }

    private function getAvatar($arr,$max) {
        $arr_index = array_rand($arr);
        $index = $arr[$arr_index];
        return 'https://randomuser.me/api/portraits/'.$index.'/'.$max.'.jpg';
    }
}
