<?php
namespace App\Controllers;

use App\Helpers\Date;
use App\Helpers\Text;
use App\Models\ArticlesModel;
use App\Models\UsersModel;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    private FilesystemLoader $loader;

    protected Environment $twig;

    protected ArticlesModel $articles;

    protected UsersModel $users;

    protected Text $text;

    protected Date $date;

    protected array $params;

    public function __construct()
    {
        // Initialize Twig
        $this->loader = new FilesystemLoader(ROOT . '/app/Views');
        $this->twig = new Environment($this->loader, [
            'cache' => false // ROOT . '/tmp/cache',
        ]);

        // Initialize Models
        $this->articles = new ArticlesModel;
        $this->users = new UsersModel;

        // Initialize Helpers class
        $this->text = new Text;
        $this->date = new Date;
    }

    // Display the Twig renderer
    public function view(string $path, $datas = []): void
    {
        echo $this->twig->render($path, $datas);
    }

    // Get the URL parameters from the router
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

}
