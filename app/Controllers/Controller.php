<?php
namespace App\Controllers;

use App\Core\Router;
use App\Models\ArticlesModel;
use App\Models\UsersModel;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    private FilesystemLoader $loader;

    protected Environment $twig;

    protected ArticlesModel $articles;

    protected UsersModel $users;

    public function __construct()
    {
        // Initialize the Twig template engine
        $this->loader = new FilesystemLoader(ROOT . '/app/Views');
        $this->twig = new Environment($this->loader, [
            'cache' => false // ROOT . '/tmp/cache',
        ]);

        // Initialize models
        $this->articles = new ArticlesModel;
        $this->users = new UsersModel;
    }

    public function view(string $path, $datas = [])
    {
        echo $this->twig->render($path, $datas);
    }

}
