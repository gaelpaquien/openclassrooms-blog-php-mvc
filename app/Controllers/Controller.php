<?php
namespace App\Controllers;

use App\Helpers\Date;
use App\Helpers\ErrorsHandling;
use App\Helpers\FormValidator;
use App\Helpers\Text;
use App\Models\ArticlesModel;
use App\Models\CommentsModel;
use App\Models\UsersModel;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller 
{

    private FilesystemLoader $loader;

    protected Environment $twig;

    protected ArticlesModel $articles;

    protected CommentsModel $comments;

    protected UsersModel $users;

    protected FormValidator $formValidator;

    protected ErrorsHandling $errorsHandling;

    protected Text $text;

    protected Date $date;

    protected array $params;

    public function __construct()
    {
        // Start session if is not
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Twig
        $this->loader = new FilesystemLoader(ROOT . '/app/Views');
        $this->twig = new Environment($this->loader, [
            'cache' => false // ROOT . '/tmp/cache',
        ]);

        // Models
        $this->articles = new ArticlesModel;
        $this->comments = new CommentsModel;
        $this->users = new UsersModel;

        // Helpers class
        $this->formValidator = new FormValidator;
        $this->errorsHandling = new ErrorsHandling;
        $this->text = new Text;
        $this->date = new Date;
    }

    public function checkAuth(): array
    {
        $auth = [
            'isLogged' => false,
            'isAdmin' => false
        ];
        
        // Check if user is logged in
        if (isset($_SESSION['auth'])) {
            $auth['isLogged'] = true;
            // Check if user is admin
            if ($_SESSION['auth']['user_admin'] === 1) {
                $auth['isAdmin'] = true;
            }
        }   
        
        return $auth;
    }

    // Display Twig renderer
    public function view(string $path, $datas = []): void
    {
        // Defines Twig global variable containing authentication status
        $auth = $this->checkAuth();
        $this->twig->addGlobal('auth', $auth);

        // Display Twig render
        echo $this->twig->render($path, $datas);
    }

    // Get URL parameters from router
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

}
