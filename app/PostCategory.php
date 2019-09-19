<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = 'posts_category_relationship';
    protected $fillable = [
        'post_id', 'category_id'
    ];
}
