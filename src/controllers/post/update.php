<?php

use App\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$postTable = new PostTable($pdo);

$postTable->update(['title' => $_POST['title']], $params['id']);