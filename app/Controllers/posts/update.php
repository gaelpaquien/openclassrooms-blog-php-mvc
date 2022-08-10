<?php
use App\Models\GlobalQueries\PostGlobalQueries;

$postsData = new PostGlobalQueries;

$postsData->update(['title' => $_POST['title']], $params['id']);

require(ROOT . '../app/Views/posts/update.php');
