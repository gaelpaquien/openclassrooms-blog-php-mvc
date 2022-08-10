<?php
namespace App\Table;

use App\Models\Post;

final class PostTable extends Table {
    
    protected $table = "article";
    protected $class = Post::class;

}