<?php
use App\Models\Posts;

$post = new Posts;
$post->update(['title' => $_POST['title']], $params['id']);