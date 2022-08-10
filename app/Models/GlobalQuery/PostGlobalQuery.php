<?php
namespace App\Models\GlobalQuery;

use App\Models\GlobalQuery\GlobalQuery;
use App\Models\Post;

final class PostGlobalQuery extends GlobalQuery {
    
    protected $table = "article";
    protected $class = Post::class;

}
