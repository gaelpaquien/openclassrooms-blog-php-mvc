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

        // Get data of current article
        $data = $this->articles->find($this->params['id']);

        // Checks if user is logged in and if he is author of article
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_id'] === $data[0]->getAuthor_id()) {
            $checkAuth = true;
        } else {
            $checkAuth = false;
        }

        // Render
        $this->view('pages/articles/show.html.twig', ['article' => $data[0], 'user' => $data[1], 'checkAuth' => $checkAuth]);
    }

    public function create(): void
    {
        $errors = null;

        // Checks if user is logged in and if he is admin
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_admin'] === 1) {

            // Check if form as sent
            if (isset($_POST) && !empty($_POST)) {
                $errors = [];

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
            
                    // Creation of article and redirection
                    $hydratedData = $this->articles->hydrate($data);
                    $this->articles->create($hydratedData); 
                    header('Location: ' . '/articles'); 

                } else {
                    // Title error
                    $errors += ['title' => 'Ce titre est déjà utilisé'];
                }  
            }
            // Render
            $this->view('pages/articles/create.html.twig', ['errors' => $errors]);  
        } else {
            // Render Forbidden
            $this->view('pages/errors/forbidden.html.twig');
        }
    }

    public function update(): void
    {
        $errors = null;

        // Get data of current article
        $data = $this->articles->find($this->params['id']);

        // Checks if user is logged in and if he is author of article
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_id'] === $data[0]->getAuthor_id()) {

            // Check if form as sent
            if (isset($_POST) && !empty($_POST)) {
                $errors = [];

                // Checks if title exist and title is not equal to this title
                $checkTitle = $this->articles->checkExists('title', $_POST['title']);
                if ($checkTitle === false || $_POST['title'] === $data[0]->getTitle()) {

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

                } else {
                    // Title error
                    $errors += ['title' => 'Ce titre est déjà utilisé'];
                }
            } 
            // Render
            $this->view('pages/articles/update.html.twig', ['article' => $data[0], 'user' => $data[1], 'errors' => $errors]);  
        } else {
            // Render Forbidden
            $this->view('pages/errors/forbidden.html.twig');
        }
    }

    public function delete(): void
    {
        // Get data of current articles
        $data = $this->articles->find($this->params['id']);

        // Checks if user is logged in and if he is author of article
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_id'] === $data[0]->getAuthor_id()) {
            // Delete image from article
            $image = $data[0]->getImage();
            if ($image !== '01default.jpg') {
                unlink(ROOT . '/public/assets/img/articles/' . $image);
            }

            // Delete article and redirection
            $this->articles->delete($this->params['id']);
            header('Location: /articles');

        } else {
            // Render Forbidden
            $this->view('pages/errors/forbidden.html.twig');
        }
    }

}
