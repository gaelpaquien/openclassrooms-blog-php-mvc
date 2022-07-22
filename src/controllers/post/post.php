<?php

use App\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$posts = new PostTable($pdo);

$post = $posts->find($match['params']['id']);