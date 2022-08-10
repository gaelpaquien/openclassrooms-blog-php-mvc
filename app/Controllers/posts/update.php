<?php

use App\Core\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$postTable = new PostTable($pdo);

$postTable->update(['title' => $_POST['title']], $params['id']);

require(dirname(__DIR__) . '/../Views/posts/update.php');