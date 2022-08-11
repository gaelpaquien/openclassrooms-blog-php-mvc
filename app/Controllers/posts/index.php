<?php
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;

$posts = $postsData->all();

$twig->template('posts/index.html.twig');

require(ROOT . '/app/Views/posts/index.php');
