<?php

use App\Core\Templating;
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;
$post = $postsData->find($params['id']);

$twig = new Templating;
$twig->template('pages/posts/post.html.twig');

require(ROOT . '/app/Views/posts/post.php');
