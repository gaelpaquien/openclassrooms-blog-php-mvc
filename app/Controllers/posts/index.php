<?php

use App\Core\Templating;
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;
$posts = $postsData->all();

$twig = new Templating;
$twig->template('pages/posts/index.html.twig');

require(ROOT . '/app/Views/posts/index.php');
