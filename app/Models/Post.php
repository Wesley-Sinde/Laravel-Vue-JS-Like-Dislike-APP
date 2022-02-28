<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description'
    ];
    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
// //and then
// factory(\App\Models\Post::class,20)->
