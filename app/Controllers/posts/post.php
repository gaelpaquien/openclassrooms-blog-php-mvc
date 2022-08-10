<?php

use App\Core\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$postTable = new PostTable($pdo);

$post = $postTable->find($params['id']);

require(dirname(__DIR__) . '/../Views/posts/post.php');