# ELOQUENT ORM RELATIONSHIPS ADVANCED 

## Description

This repository is a Software of Application with Laravel.

## Installation

Using Laravel 8.5 preferably.

## DataBase

Using MySQL preferably.
Create a MySQL database and configure the .env file.

## Apps

Using Postman,Talend API Tester,Insomnia,etc

## Usage

```html
$ git clone https://github.com/DanielArturoAlejoAlvarez/Eloquent-ORM-Laravel-8.5-Relationships-Advanced[NAME APP]

$ composer install

$ copy .env.example .env

$ php artisan key:generate

$ php artisan migrate:refresh --seed

$ php artisan serve

```

Follow the following steps and you're good to go! Important:

![alt text](https://i.imgur.com/Npm1yYE.gif)

## Coding

### Factories
```php
...
public function definition()
    {
        return [
            'level_id'          =>  $this->faker->randomElement([null,1,2,3]),
            'name'              =>  $this->faker->name,
            'email'             =>  $this->faker->unique()->safeEmail,
            'email_verified_at' =>  now(),
            'password'          =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    =>  Str::random(10),
        ];
    }
...
```

### Seeders
```php
...
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
...
```

### Routes
```php
...
Route::get('/', function () {

    $users = App\Models\User::get();
    return view('welcome', ['users'=>$users]);
});

Route::get('/profile/{id}', function($id) {
    $user = App\Models\User::find($id);    
    //dd($user->name);
    
    $posts = $user->posts()
    ->with('category','image','tags')
    ->withCount('comments')->get();
    $videos = $user->videos()
    ->with('category','image','tags')
    ->withCount('comments')->get();

    return view('profile', [
        'user'  =>  $user,
        'posts' =>  $posts,
        'videos'=>  $videos
    ]);
})->name('profile');

Route::get('/level/{id}', function($id) {
    $level = App\Models\Level::find($id);    
    //dd($level->name);
    
    $posts = $level->posts()
    ->with('category','image','tags')
    ->withCount('comments')->get();
    $videos = $level->videos()
    ->with('category','image','tags')
    ->withCount('comments')->get();

    return view('level', [
        'level'  =>  $level,
        'posts' =>  $posts,
        'videos'=>  $videos
    ]);
})->name('level');
...
```

### Models

```php
...
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function level() {
        return $this->belongsTo(Level::class);
    }

    public function groups() {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function location() {
        return $this->hasOneThrough(Location::class, Profile::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function image() {
        return $this->morphOne(Image::class, 'imageable');
    }

}
...

```



## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/DanielArturoAlejoAlvarez/Eloquent-ORM-Laravel-8.5-Relationships-Advanced. This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.

## License

The gem is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).

```

```