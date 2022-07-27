<?php 

require(dirname(__DIR__) . '/../controllers/post/update.php');

header('Location: ' . $router->generate('articles'));
