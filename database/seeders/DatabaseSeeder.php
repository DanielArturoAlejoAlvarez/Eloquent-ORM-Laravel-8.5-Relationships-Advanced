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
            $profile = $user->profile()->save(\App\Models\Profile::factory()->make());
            $profile->location()->save(\App\Models\Location::factory()->make());

            $user->groups()->attach($this->arrayNum(rand(1,3)));

            $user->image()->save(\App\Models\Image::factory()
                        ->make(['url'=>$this->getAvatar(['men','women'],rand(1,99))]));
        });


        \App\Models\Category::factory(4)->create();
        \App\Models\Tag::factory(12)->create();


        \App\Models\Post::factory(40)->create()->each(function($post) {
            $post->image()->save(\App\Models\Image::factory()->make(['url'=>$this->getPic(rand(1,249))]));
            $post->tags()->attach($this->arrayNum(rand(1,12)));

            $num_comments = rand(1,6);
            for ($i=0; $i < $num_comments; $i++) { 
                $post->comments()->save(\App\Models\Comment::factory()->make());
            }
        });

        \App\Models\Video::factory(40)->create()->each(function($video) {
            $video->image()->save(\App\Models\Image::factory()->make(['url'=>$this->getPic(rand(250,500))]));
            $video->tags()->attach($this->arrayNum(rand(1,12)));

            $num_comments = rand(1,6);
            for ($i=0; $i < $num_comments; $i++) { 
                $video->comments()->save(\App\Models\Comment::factory()->make());
            }
        });

    }

    private function arrayNum($max) {
        $values = [];

        for ($i=1; $i < $max; $i++) { 
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
