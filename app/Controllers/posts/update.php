<?php

use App\Core\Templating;
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;
$postsData->update(['title' => $_POST['title']], $params['id']);

$twig = new Templating;
$twig->template('pages/posts/update.html.twig');

require(ROOT . '/app/Views/posts/update.php');
