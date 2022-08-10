<?php
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;

$post = $postsData->find($params['id']);

require(ROOT . '../app/Views/posts/post.php');
