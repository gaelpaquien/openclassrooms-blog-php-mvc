<?php
use App\Models\GlobalQuery\PostGlobalQuery;

$postGlobalQuery = new PostGlobalQuery();

$posts = $postGlobalQuery->all();

require(dirname(__DIR__) . '/../Views/posts/index.php');
