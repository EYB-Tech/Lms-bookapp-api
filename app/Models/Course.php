<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
