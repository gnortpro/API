<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'posts_category';
    protected $fillable = [
        'category_id', 'name', 'slug'
    ];
}
