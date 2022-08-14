<?php
use App\Core\Templating;

$twig = new Templating;
$twig->template('home.html.twig');

require(ROOT . '/app/Views/Home.php');
