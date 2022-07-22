<?php

use App\Database;
use App\Table\PostTable;

$pdo = Database::getPDO();

$post = new PostTable($pdo);

$posts = $post->all();