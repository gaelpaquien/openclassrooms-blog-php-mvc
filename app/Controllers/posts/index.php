<?php

use App\Core\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$postTable = new PostTable($pdo);

$posts = $postTable->all();

require(dirname(__DIR__) . '/../Views/posts/index.php');