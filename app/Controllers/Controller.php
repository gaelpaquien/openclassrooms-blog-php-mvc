<?php
namespace App\Controllers;

use App\Helpers\Date;
use App\Helpers\FormValidator;
use App\Helpers\Pagination;
use App\Helpers\Superglobal;
use App\Helpers\Text;
use App\Models\Article\ArticleModel;
use App\Models\Comment\CommentModel;
use App\Models\Contact\ContactModel;
use App\Models\User\UserModel;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller 
{

    private FilesystemLoader $loader;

    protected Environment $twig;

    protected ArticleModel $article;

    protected CommentModel $comment;

    protected UserModel $user;

    protected ContactModel $contact;

    protected FormValidator $formValidator;

    protected Text $text;

    protected Date $date;

    protected Pagination $pagination;

    protected Superglobal $superglobal;

    protected array $params;

    public function __construct()
    {
        // Twig
        $this->loader = new FilesystemLoader(ROOT . '/app/Views');
        $this->twig = new Environment($this->loader, [
            'cache' => ROOT . '/tmp/cache'
        ]);

        // Models
        $this->article = new ArticleModel;
        $this->comment = new CommentModel;    
        $this->user = new UserModel;
        $this->contact = new ContactModel;
       
        // Helpers
        $this->formValidator = new FormValidator;
        $this->text = new Text;
        $this->date = new Date;
        $this->pagination = new Pagination;
        $this->superglobal = new Superglobal;
    }

    public function checkAuth(): array
    {
        $auth = [
            'isLogged' => false,
            'isAdmin' => false
        ];
        
        // Check if user is logged in
        if (isset($this->superglobal->get_SESSION()['user_id'])) {
            $auth['isLogged'] = true;
            // Check if user is admin
            if ($this->superglobal->get_SESSION()['user_admin'] === 1) {
                $auth['isAdmin'] = true;
            }
        }   
        
        return $auth;
    }

    public function view(string $path, $datas = []): void
    {
        // Defines Twig global variable containing authentication status
        $auth = $this->checkAuth();
        $this->twig->addGlobal('auth', $auth);
        // Defines Twig global variable containing form token to prevent CSRF attack
        $token = md5(uniqid(mt_rand(), true));
        $_SESSION['token'] = $token;
        $this->twig->addGlobal('formToken', $token);

        // Display Twig render
        print_r($this->twig->render($path, $datas));
    }

    public function setParams(array $params): void
    {
        // Get URL parameters from router
        $this->params = $params;
    }

}
