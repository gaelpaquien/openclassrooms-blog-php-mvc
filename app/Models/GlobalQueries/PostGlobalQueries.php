<?php
namespace App\Models\GlobalQueries;

use App\Models\GlobalQueries\GlobalQueries;
use App\Models\Post;

final class PostGlobalQueries extends GlobalQueries {
    
    protected $table = "article";
    protected $class = Post::class;

}
