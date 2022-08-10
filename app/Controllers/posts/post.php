<?php
use App\Models\GlobalQuery\PostGlobalQuery;

$postGlobalQuery = new PostGlobalQuery();

$post = $postGlobalQuery->find($params['id']);

require(dirname(__DIR__) . '/../Views/posts/post.php');
