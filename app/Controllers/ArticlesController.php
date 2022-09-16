<?php
namespace App\Controllers;

class ArticlesController extends Controller
{

    public function index(): void
    {
        // Get data of all articles
        $data = $this->articles->findAll();

        // Render
        $this->view('pages/articles/index.html.twig', ['articles' => $data]);
    }

    public function show(): void
    {
        $checkAuth = false;
        $checkCommentSent = false;

        if (isset($_GET['commentSent'])) {
            $checkCommentSent = $_GET['commentSent'];
        }

        // Get data of current article
        $data = $this->articles->find($this->params['id']);

        // Get validate comments of current article
        $comments = $this->comments->findValid($this->params['id']);

        // Check if user is logged in
        $checkAuth = false;
        $checkAdmin = false;
        $articlePermission = false;
        if (isset($_SESSION['auth'])) {
            $checkAuth = true; 
            // Check if user is author of article
            if ($_SESSION['auth']['user_id'] === $data[0]->getAuthor_id()) {
                $articlePermission = true;
            }
            // Check if user is admin
            if ($_SESSION['auth']['user_admin'] === 1) {
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
            'checkCommentSent' => $checkCommentSent
        ]);
    }

    public function create(): void
    {
        $errors = null;

        // Checks if user is logged in and if he is admin
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_admin'] === 1) {

            // Check if form as sent
            if (isset($_POST) && !empty($_POST)) {

                // Slug of article
                $slug = $this->text->slugify($_POST['title']);
    
                // Default image of article
                $file = '01default.jpg';
    
                // File management (image of article)
                if (isset($_FILES)) {
                    // Get file extension
                    $fileExtension = explode('.', $_FILES['image']['name']);
                    $extension = strtolower(end($fileExtension));
    
                    // Checks file extension
                    $permittedExtension = ['jpg', 'png', 'jpeg'];
                    if (in_array($extension, $permittedExtension)) {
                        // Saves file
                        $file = $slug . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'], ROOT . '/public/assets/img/articles/' . $file);
                    }
                }

                // Check if title already exists
                $checkTitle = $this->articles->checkExists('title', $_POST['title']);
                if ($checkTitle === false) {

                    // Add data of article in array
                    $data = [
                        'title' => $_POST['title'],
                        'slug' => $slug,
                        'caption' => $_POST['caption'],
                        'content' => $_POST['content'],
                        'author_id' => $_SESSION['auth']['user_id'],
                        'image' => $file
                    ];

                    // Check form data 
                    $errors = $this->formValidator->checkArticleForm($data);
            
                    // If check form data is ok
                    if ($errors === null) {
                        // Creation of article and redirection
                        $hydratedData = $this->articles->hydrate($data);
                        $this->articles->create($hydratedData); 
                        header('Location: ' . '/articles'); 
                    }

                } else {
                    // Error : Title already exist
                    $errors = $this->errorsHandling->newError('Ce titre existe déjà.');
                }  
            }
            // Render
            $this->view('pages/articles/create.html.twig', ['errors' => $errors]);  
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function update(): void
    {
        $errors = null;

        // Get data of current article
        $data = $this->articles->find($this->params['id']);

        $admin = $this->users->findAllAdmin();

        // Checks if user is logged in and if he is author of article or admin
        if (isset($_SESSION['auth']) && (($_SESSION['auth']['user_id'] === $data[0]->getAuthor_id() || $_SESSION['auth']['user_admin'] === 1))) {
           
            // Check if form as sent
            if (isset($_POST) && !empty($_POST)) {

                // Checks if title exist and title is not equal to this title
                $checkTitle = $this->articles->checkExists('title', $_POST['title']);
                if ($checkTitle === false || $_POST['title'] === $data[0]->getTitle()) {

                    // Check form data
                    $errors = $this->formValidator->checkArticleForm([
                        'title' => $_POST['title'],
                        'caption' => $_POST['caption'],
                        'content' => $_POST['content']
                    ]);

                    dump($_POST);exit();

                    // If check form data is ok
                    if ($errors === null) {
                        // Update of article and redirection
                        $this->articles->setId($this->params['id'])
                                    ->setTitle($_POST['title'])
                                    ->setSlug($this->text->slugify($_POST['title']))
                                    ->setContent($_POST['content'])
                                    ->setCaption($_POST['caption'])
                                    ->setAuthor_id(1)
                                    ->setUpdated_at($this->date->getDateNow())
                                    ->update($this->params['id']);
                        header('Location: /article/' . $this->articles->getSlug() . '/' . $this->articles->getId()); 
                    }

                } else {
                    // Error : Title already exist
                    $errors = $this->errorsHandling->newError('Ce titre existe déjà.');
                }
            }
            // Render
            $this->view('pages/articles/update.html.twig', [
                'article' => $data[0], 
                'user' => $data[1], 
                'errors' => $errors,
                'admins' => $admin
            ]);  
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function delete(): void
    {
        // Get data of current articles
        $data = $this->articles->find($this->params['id']);

        // Check if user is logged in and if he is author of article or admin
        if (isset($_SESSION['auth']) && ($_SESSION['auth']['user_id'] === $data[0]->getAuthor_id() || $_SESSION['auth']['user_admin'] === 1)) {

            // Delete image from article
            $image = $data[0]->getImage();
            if ($image !== '01default.jpg') {
                unlink(ROOT . '/public/assets/img/articles/' . $image);
            }

            // Delete article and redirection
            $this->articles->delete($this->params['id']);
            header('Location: /articles');
                  
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

}
