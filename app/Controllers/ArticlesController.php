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
        $this->view('pages/articles/create.html.twig');

        if (isset($_POST) && !empty($_POST)) {
            echo '$_POST contient des données' . '<br>';
            var_dump($_POST);
        } else {
            echo '$_POST est vide';
        }
    }

    /* public function createConfirmation(): void
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $this->text->slugify($_POST['title']),
            'caption' => $_POST['caption'],
            'content' => $_POST['content'],
            'author_id' => 1
        ];

        $hydratedData = $this->articles->hydrate($data);
        $this->articles->create($hydratedData); 
        header('Location: ' . '/articles');
    }

    public function update(): void
    {
        $data = $this->articles->find($this->params['id']);
        $this->view('pages/articles/update.html.twig', ['article' => $data[0], 'user' => $data[1]]);     
    }

    public function updateConfirmation(): void
    {
        $this->articles->setId($this->params['id'])
                       ->setTitle($_POST['title'])
                       ->setSlug($this->text->slugify($_POST['title']))
                       ->setContent($_POST['content'])
                       ->setCaption($_POST['caption'])
                       ->setAuthor_id(1)
                       ->setUpdated_at($this->date->getDateNow())
                       ->update($this->params['id']);
        
        header('Location: /article/' . $this->articles->getSlug() . '/' . $this->articles->getId());
    } */

    public function delete(): void
    {
        $this->articles->delete($this->params['id']);
        header('Location: ' . '/articles');
    }

}
