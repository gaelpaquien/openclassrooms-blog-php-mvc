<?php
namespace App\Controllers;

class ArticlesController extends Controller
{

    public function index(): void
    {
        $data = $this->articles->findAll();
        $this->view('pages/articles/index.html.twig', ['articles' => $data]);
    }

    public function show(): void
    {
        $data = $this->articles->find($this->params['id']);
        $this->view('pages/articles/show.html.twig', ['article' => $data[0], 'user' => $data[1]]);
    }

    public function create(): void
    {
        if (isset($_POST) && !empty($_POST)) {
            // Variable containing the slug of the article
            $slug = $this->text->slugify($_POST['title']);

            // Default image of the article
            $file = 'default.jpg';

            if (isset($_FILES)) {
                // Get the file extension
                $fileExtension = explode('.', $_FILES['image']['name']);
                $extension = strtolower(end($fileExtension));

                // Checks the file extension
                $permittedExtension = ['jpg', 'png', 'jpeg'];
                if (in_array($extension, $permittedExtension)) {
                    // Saves file
                    $file = $slug . '.' . $extension;
                    move_uploaded_file($_FILES['image']['tmp_name'], ROOT . '/public/assets/img/articles/' . $file);
                } else {
                    echo 'Enregistrement impossible';
                }
            }

            // Retrieve data from an array
            $data = [
                'title' => $_POST['title'],
                'slug' => $slug,
                'caption' => $_POST['caption'],
                'content' => $_POST['content'],
                'author_id' => 1,
                'image' => $file
            ];
    
            // Hydrate data, create article and redirection
            $hydratedData = $this->articles->hydrate($data);
            $this->articles->create($hydratedData); 
            header('Location: ' . '/articles');   
        } else {
            $this->view('pages/articles/create.html.twig');
        }
    }

    public function update(): void
    {
        if (isset($_POST) && !empty($_POST)) {
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
            $data = $this->articles->find($this->params['id']);
            $this->view('pages/articles/update.html.twig', ['article' => $data[0], 'user' => $data[1]]);  
        }
    }

    public function delete(): void
    {
        $this->articles->delete($this->params['id']);
        header('Location: ' . '/articles');
    }

}
