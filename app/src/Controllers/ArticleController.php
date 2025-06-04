<?php
namespace App\Controllers;

class ArticleController extends Controller
{

    public function index(): void
    {
        // Pagination (6 articles per page)
        $countArticles = $this->article->countAll('articles');
        $nbArticles = (int) $countArticles->nb_articles;
        $pages = $this->pagination->pagination($nbArticles, 6);

        // Get data of all articles
        $articles = $this->article->findAll($pages[0]['limitFirst'], $pages[0]['perPage']);

        // Render
        $this->view('pages/article/index.html.twig', [
            'lastPage' => $pages[0]['lastPage'],
            'currentPage' => $pages[0]['currentPage'],
            'articles' => $articles
        ]);
    }

    public function show(): void
    {
        $commentSent = false;
        $isLogged = false;
        $isAdmin = false;
        $isAuthor = false;
        
        // Check if comment as sent
        if (isset($this->superglobal->get_GET()['commentSent'])) {
            $commentSent = true;
        }

        // Get data of current article and associated user
        $data = $this->article->find($this->params['id']);
        $article = $data[0];
        $user = $data[1];

        // Pagination (3 comments per page)
        $countComments = $this->comment->countAllValidFromArticle($this->params['id']);
        $nbComments = (int) $countComments->nb_comments;
        $pages = $this->pagination->pagination($nbComments, 3);

        // Get validate comments of current article
        $comments = $this->comment->findAllValidFromArticle($this->params['id'], $pages[0]['limitFirst'], $pages[0]['perPage']);
        
        // Check if user is logged in
        if ($this->checkAuth()['isLogged'] === true) {
            $isLogged = true; 
            // Check if user is author of article
            if ($this->superglobal->get_SESSION()['user_id'] === $article->getAuthor_id()) {
                $isAuthor = true;
            }
            // Check if user is admin
            if ($this->checkAuth()['isAdmin'] === true) {
                $isAdmin = true;
            }
        }

        // Render
        $this->view('pages/article/show.html.twig', [
            'article' => $article, 
            'user' => $user, 
            'comments' => $comments,
            'lastPage' => $pages[0]['lastPage'],
            'currentPage' => $pages[0]['currentPage'],
            'isLogged' => $isLogged,
            'isAuthor' => $isAuthor,
            'isAdmin' => $isAdmin,
            'commentSent' => $commentSent,
        ]);
    }

    public function create(): void
    {
        $error = null;

        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit');
        } 

        // Check if form as sent
        if (empty($this->superglobal->get_POST())) {
            $this->view('pages/article/create.html.twig', ['error' => $error]);
            return;
        }

        // Check token form to prevent CSRF attack
        if (false === $this->formValidator->checkToken($this->superglobal->get_POST()['token'])) {
            $error = "Une erreur est survenue lors de l'envoi du formulaire.";
            $this->view('pages/article/create.html.twig', ['error' => $error]);
            return;
        };

        // Check if title already exists
        $checkTitle = $this->article->checkExists('articles', 'title', $this->superglobal->get_POST()['title']);
        if (true === $checkTitle) {
            $error = "Ce titre existe déjà.";
            $this->view('pages/article/create.html.twig', ['error' => $error]);
            return;
        }

        // Slug of article
        $slug = $this->text->slugify($this->superglobal->get_POST()['title']);

        // File management (image of article)
        $file = '01default.jpg'; // Default image
        if (!empty($this->superglobal->get_FILES()['image']['name'])) {
            // Get file extension
            $fileExtension = explode('.', $this->superglobal->get_FILES()['image']['name']);
            $extension = strtolower(end($fileExtension));
            // Check file extension
            $permittedExtension = ['jpg', 'png', 'jpeg'];
            if (in_array($extension, $permittedExtension)) {
                // Save file
                $file = $slug . '.' . $extension;
                move_uploaded_file($this->superglobal->get_FILES()['image']['tmp_name'], ROOT . '/public/assets/img/articles/' . $file);
            }
        }

        // Add data of article in array
        $article = [
            'title' => $this->superglobal->get_POST()['title'],
            'slug' => $slug,
            'caption' => $this->superglobal->get_POST()['caption'],
            'content' => $this->superglobal->get_POST()['content'],
            'author_id' => $this->superglobal->get_SESSION()['user_id'],
            'image' => $file,
            'updated_at' => $this->date->getDateNow()
        ];

        // Check if form data is ok
        $error = $this->formValidator->checkArticleForm($article);
        if (null === $error) {
            // Creation of article and redirection
            $hydratedDataArticle = $this->article->hydrate($article);
            $this->article->create('articles', $hydratedDataArticle); 
            header('Location: ' . '/articles'); 
        }
        
        // Render if form data is not ok
        $this->view('pages/article/create.html.twig', ['error' => $error]); 
    }

    public function update(): void
    {
        $error = null;
        
        // Get data of current article and associated user
        $data = $this->article->find($this->params['id']);
        $article = $data[0];
        $user = $data[1];

        // Checks if user is logged in and if he is author of article or admin
        if ($this->checkAuth()['isLogged'] !== true && (($this->superglobal->get_SESSION()['user_id'] !== $article->getAuthor_id() || $this->checkAuth()['isAdmin'] !== true))) {
            header('Location: /erreur/acces-interdit');  
        }

        // Get admin user data (id, firstname, lastname)
        $admins = $this->user->findAllAdmin();
        $listAdmins = [];
        foreach ($admins as $admin) {
            if ($admin->id != $article->getAuthor_id()) {
                $listAdmin = [
                    'id' => $admin->id,
                    'firstname' => $admin->firstname,
                    'lastname' => $admin->lastname
                ];
                array_push($listAdmins, $listAdmin);
            }  
        } 

        // Check if form as sent
        if (empty($this->superglobal->get_POST())) {      
            $this->view('pages/article/update.html.twig', [
                'error' => $error,
                'article' => $article, 
                'user' => $user, 
                'admins' => $listAdmins
            ]);
            return;            
        }

        // Check token form to prevent CSRF attack
        if (false === $this->formValidator->checkToken($this->superglobal->get_POST()['token'])) {
            $error = "Une erreur est survenue lors de l'envoi du formulaire.";
            $this->view('pages/article/update.html.twig', [
                'error' => $error,
                'article' => $article, 
                'user' => $user, 
                'admins' => $listAdmins
            ]);
            return;
        };

        // Check if title exist and if title is not equal to current title
        $checkTitle = $this->article->checkExists('articles', 'title', $this->superglobal->get_POST()['title']);  
        if ($checkTitle === true && $this->superglobal->get_POST()['title'] !== $article->getTitle()) {
            $error = "Ce titre existe déjà.";
            $this->view('pages/article/update.html.twig', [
                'error' => $error,
                'article' => $article, 
                'user' => $user, 
                'error' => $error,
                'admins' => $listAdmins
            ]);
            return;     
        }

        // Prepare to check form data
        $error = $this->formValidator->checkArticleForm([
            'title' => $this->superglobal->get_POST()['title'],
            'caption' => $this->superglobal->get_POST()['caption'],
            'content' => $this->superglobal->get_POST()['content'],
            'author_id' => $this->superglobal->get_POST()['author'],
        ]);

        // Check if form data is ok
        if (null === $error) {
            // Update article and redirection
            $this->article->setId($this->params['id'])
                        ->setTitle($this->superglobal->get_POST()['title'])
                        ->setSlug($this->text->slugify($this->superglobal->get_POST()['title']))
                        ->setContent($this->superglobal->get_POST()['content'])
                        ->setCaption($this->superglobal->get_POST()['caption'])
                        ->setAuthor_id($this->superglobal->get_POST()['author'])
                        ->setUpdated_at($this->date->getDateNow())
                        ->update('articles', $this->params['id']);
            header('Location: /article/' . $this->article->getSlug() . '/' . $this->article->getId()); 
        }
        
        // Render if form data is not ok
        $this->view('pages/article/update.html.twig', [
            'article' => $article, 
            'user' => $user, 
            'error' => $error,
            'admins' => $listAdmins
        ]);  
    }

    public function delete(): void
    {
        // Get data of current article
        $data = $this->article->find($this->params['id']);
        $article = $data[0];

        // Check if user is logged in and if he is author of article or admin
        if ($this->checkAuth()['isLogged'] !== true && ($this->superglobal->get_SESSION()['user_id'] !== $article->getAuthor_id() || $this->checkAuth()['isAdmin'] !== true)) {
            header('Location: /erreur/acces-interdit');  
        }

        // Delete image file associated with article if it is not the default image
        $image = $article->getImage();
        if ($image !== '01default.jpg') {
            unlink(ROOT . '/public/assets/img/articles/' . $image);
        }

        // Delete comments associated with article
        $comments = $this->comment->findAllBy('comments', 'article_id', $this->params['id']);
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $this->comment->delete('comments', $comment->id);
            }
        }
        
        // Delete article and redirection
        $this->article->delete('articles', $this->params['id']);
        header('Location: /articles'); 
    }

}
