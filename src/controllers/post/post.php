<?php

use App\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$postTable = new PostTable($pdo);

$post = $postTable->find($params['id']);