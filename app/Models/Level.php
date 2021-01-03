<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function posts() {
        return $this->hasManyThrough(Post::class, User::class);
    }

    public function videos() {
        return $this->hasManyThrough(Video::class, User::class);
    }
}
