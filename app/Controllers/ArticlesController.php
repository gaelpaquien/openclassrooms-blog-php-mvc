<?php
namespace App\Controllers;

class ArticlesController extends Controller
{

    public function index(): void
    {
        // Pagination
        $countArticles = $this->articles->countAll('articles');
        $nbArticles = (int) $countArticles->nb_articles;
        $pages = $this->pagination->pagination($nbArticles, 6);

        // Get data of all articles
        $data = $this->articles->findAll($pages[0]['limitFirst'], $pages[0]['perPage']);

        // Render
        $this->view('pages/articles/index.html.twig', [
            'lastPage' => $pages[0]['lastPage'],
            'currentPage' => $pages[0]['currentPage'],
            'articles' => $data
        ]);
    }

    public function show(): void
    {
        $checkCommentSent = false;
        $checkAuth = false;
        $checkAdmin = false;
        $articlePermission = false;
        
        if (isset($this->superglobals->get_GET()['commentSent'])) {
            $checkCommentSent = true;
        }

        // Get data of current article
        $data = $this->articles->find($this->params['id']);

        // Pagination
        $countComments = $this->comments->countAllValidFromArticle($this->params['id']);
        $nbComments = (int) $countComments->nb_comments;
        $pages = $this->pagination->pagination($nbComments, 3);

        // Get validate comments of current article
        $comments = $this->comments->findAllValidFromArticle($this->params['id'], $pages[0]['limitFirst'], $pages[0]['perPage']);

        // Check if user is logged in
        if ($this->checkAuth()['isLogged'] === true) {
            $checkAuth = true; 
            // Check if user is author of article
            if ($this->superglobals->get_SESSION()['user_id'] === $data[0]->getAuthor_id()) {
                $articlePermission = true;
            }
            // Check if user is admin
            if ($this->checkAuth()['isAdmin'] === true) {
                $checkAdmin = true;
            }
        }

        // Render
        $this->view('pages/articles/show.html.twig', [
            'article' => $data[0], 
            'userArticle' => $data[1], 
            'comments' => $comments,
            'checkAuth' => $checkAuth,
            'articlePermission' => $articlePermission,
            'checkAdmin' => $checkAdmin,
            'checkCommentSent' => $checkCommentSent,
            'lastPage' => $pages[0]['lastPage'],
            'currentPage' => $pages[0]['currentPage'],
        ]);
    }

    public function create(): void
    {
        $error = null;

        // Checks if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit');
        } 

        // Check if form as sent
        if (empty($this->superglobals->get_POST())) {
            $this->view('pages/articles/create.html.twig', ['error' => $error]);
            return;
        }

        // Check if title already exists
        $checkTitle = $this->articles->checkExists('articles', 'title', $this->superglobals->get_POST()['title']);
        if (true === $checkTitle) {
            $error = "Ce titre existe déjà.";
            $this->view('pages/articles/create.html.twig', ['error' => $error]);
            return;
        }

        // Slug of article
        $slug = $this->text->slugify($this->superglobals->get_POST()['title']);

        // Default image of article
        $file = '01default.jpg';

        // File management (image of article)
        if (!empty($this->superglobals->get_FILES()['image']['name'])) {
            // Get file extension
            $fileExtension = explode('.', $this->superglobals->get_FILES()['image']['name']);
            $extension = strtolower(end($fileExtension));
            // Checks file extension
            $permittedExtension = ['jpg', 'png', 'jpeg'];
            if (in_array($extension, $permittedExtension)) {
                // Saves file
                $file = $slug . '.' . $extension;
                move_uploaded_file($this->superglobals->get_FILES()['image']['tmp_name'], ROOT . '/public/assets/img/articles/' . $file);
            }
        }

        // Add data of article in array
        $data = [
            'title' => $this->superglobals->get_POST()['title'],
            'slug' => $slug,
            'caption' => $this->superglobals->get_POST()['caption'],
            'content' => $this->superglobals->get_POST()['content'],
            'author_id' => $this->superglobals->get_SESSION()['user_id'],
            'image' => $file
        ];

        // If check form data is ok
        $error = $this->formValidator->checkArticleForm($data);
        if (null === $error) {
            // Creation of article and redirection
            $hydratedData = $this->articles->hydrate($data);
            $this->articles->create('articles', $hydratedData); 
            header('Location: ' . '/articles'); 
            exit();
        }
        
        // Render
        $this->view('pages/articles/create.html.twig', ['error' => $error]); 
    }

    public function update(): void
    {
        $error = null;

        // Get data of current article
        $data = $this->articles->find($this->params['id']);

        // Get all admin
        $admins = $this->users->findAllAdmin();
        $listAdmins = [];
        foreach ($admins as $admin) {
            if ($admin->id != $data[0]->getAuthor_id()) {
                $listAdmin = [
                    'id' => $admin->id,
                    'firstname' => $admin->firstname,
                    'lastname' => $admin->lastname
                ];
                array_push($listAdmins, $listAdmin);
            }  
        } 

        // Checks if user is logged in and if he is author of article or admin
        if ($this->checkAuth()['isLogged'] !== true && (($this->superglobals->get_SESSION()['user_id'] !== $data[0]->getAuthor_id() || $this->checkAuth()['isAdmin'] !== true))) {
            header('Location: /erreur/acces-interdit');  
        }

        // Check if form as sent
        if (empty($this->superglobals->get_POST())) {      
            $this->view('pages/articles/update.html.twig', [
                'error' => $error,
                'article' => $data[0], 
                'user' => $data[1], 
                'error' => $error,
                'admins' => $listAdmins
            ]);
            return;            
        }

        // Checks if title exist and title is not equal to this title
        $checkTitle = $this->articles->checkExists('articles', 'title', $this->superglobals->get_POST()['title']);  
        if ($checkTitle === true && $this->superglobals->get_POST()['title'] !== $data[0]->getTitle()) {
            $error = "Ce titre existe déjà.";
            $this->view('pages/articles/update.html.twig', [
                'error' => $error,
                'article' => $data[0], 
                'user' => $data[1], 
                'error' => $error,
                'admins' => $listAdmins
            ]);
            return;     
        }

        // Check form data
        $error = $this->formValidator->checkArticleForm([
            'title' => $this->superglobals->get_POST()['title'],
            'caption' => $this->superglobals->get_POST()['caption'],
            'content' => $this->superglobals->get_POST()['content'],
            'author_id' => $this->superglobals->get_POST()['author']
        ]);

        // If check form data is ok
        if (null === $error) {
            // Update of article and redirection
            $this->articles->setId($this->params['id'])
                        ->setTitle($this->superglobals->get_POST()['title'])
                        ->setSlug($this->text->slugify($this->superglobals->get_POST()['title']))
                        ->setContent($this->superglobals->get_POST()['content'])
                        ->setCaption($this->superglobals->get_POST()['caption'])
                        ->setAuthor_id($this->superglobals->get_POST()['author'])
                        ->setUpdated_at($this->date->getDateNow())
                        ->update('articles', $this->params['id']);
            header('Location: /article/' . $this->articles->getSlug() . '/' . $this->articles->getId()); 
        }
        
        // Render
        $this->view('pages/articles/update.html.twig', [
            'article' => $data[0], 
            'user' => $data[1], 
            'error' => $error,
            'admins' => $listAdmins
        ]);  
    }

    public function delete(): void
    {
        // Get data of current articles
        $data = $this->articles->find($this->params['id']);

        // Check if user is logged in and if he is author of article or admin
        if ($this->checkAuth()['isLogged'] !== true && ($this->superglobals->get_SESSION()['user_id'] !== $data[0]->getAuthor_id() || $this->checkAuth()['isAdmin'] !== true)) {
            header('Location: /erreur/acces-interdit');  
        }

        // Delete image from article
        $image = $data[0]->getImage();
        if ($image !== '01default.jpg') {
            unlink(ROOT . '/public/assets/img/articles/' . $image);
        }

        // Delete comments associated with article
        $comments = $this->comments->findAllBy('comments', 'article_id', $this->params['id']);
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $this->comments->delete('comments', $comment->id);
            }
        }
        
        // Delete article and redirection
        $this->articles->delete('articles', $this->params['id']);
        header('Location: /articles'); 
    }

}
