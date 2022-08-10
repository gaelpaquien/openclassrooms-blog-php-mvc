<?php
use App\Models\GlobalQuery\PostGlobalQuery;

$postGlobalQuery = new PostGlobalQuery();

$postGlobalQuery->update(['title' => $_POST['title']], $params['id']);

require(dirname(__DIR__) . '/../Views/posts/update.php');
