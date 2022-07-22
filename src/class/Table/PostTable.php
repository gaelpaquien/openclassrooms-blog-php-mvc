<?php
namespace App\Table;

use App\Model\Post;

final class PostTable extends Table {
    
    protected $table = "article";
    protected $class = Post::class;

}