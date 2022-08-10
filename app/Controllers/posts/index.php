<?php
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;

$posts = $postsData->all();

require(ROOT . '../app/Views/posts/index.php');
