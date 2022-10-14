<?php
namespace App\Controllers;

use App\Helpers\Date;
use App\Helpers\ErrorsHandling;
use App\Helpers\FormValidator;
use App\Helpers\Pagination;
use App\Helpers\Superglobals;
use App\Helpers\Text;
use App\Models\Articles\ArticlesModel;
use App\Models\Comments\CommentsModel;
use App\Models\Users\UsersModel;
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

    protected Pagination $pagination;

    protected Superglobals $superglobals;

    protected array $params;

    public function __construct()
    {
        // Twig
        $this->loader = new FilesystemLoader(ROOT . '/app/Views');
        $this->twig = new Environment($this->loader, [
            'cache' => false // ROOT . '/tmp/cache'
        ]);

        // Models
        $this->articles = new ArticlesModel;
        $this->comments = new CommentsModel;
        $this->users = new UsersModel;

        // Helpers
        $this->formValidator = new FormValidator;
        $this->errorsHandling = new ErrorsHandling;
        $this->text = new Text;
        $this->date = new Date;
        $this->pagination = new Pagination;
        $this->superglobals = new Superglobals;
    }

    public function checkAuth(): array
    {
        $auth = [
            'isLogged' => false,
            'isAdmin' => false
        ];
        
        // Check if user is logged in
        if (isset($this->superglobals->get_SESSION()['user_id'])) {
            $auth['isLogged'] = true;
            // Check if user is admin
            if ($this->superglobals->get_SESSION()['user_admin'] === 1) {
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
        print_r($this->twig->render($path, $datas));
    }

    // Get URL parameters from router
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

}
