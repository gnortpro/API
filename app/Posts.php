<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'author_id', 'content', 'post_type', 'post_slug', 'post_status', 'menu_order', 'thumbnail', 'title'
    ];
}
