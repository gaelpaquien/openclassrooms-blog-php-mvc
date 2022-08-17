<?php
use App\Core\Templating;

$twig = new Templating;
$twig->view('pages/errors/404.html.twig');