<?php
namespace App\Controllers;

class ArticlesController extends Controller
{

    public function create()
    {
        $this->view('pages/articles/create.html.twig');
    }

    public function createConfirmation()
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

    public function index() 
    {
        $data = $this->articles->findAll();
        $this->view('pages/articles/index.html.twig', ['articles' => $data]);
    }

    public function show()
    {
        
        $data = $this->articles->find(PARAMS['id']);
        $this->view('pages/articles/show.html.twig', ['article' => $data]);
    }

    public function update()
    {
        $data = $this->articles->find(PARAMS['id']);
        $this->view('pages/articles/update.html.twig', ['article' => $data]);     
    }

    public function updateConfirmation()
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $this->text->slugify($_POST['title']),
            'content' => $_POST['content'],
            'caption' => $_POST['caption'],
            'author_id' => 1,
            'updated_at' => $this->date->getDateNow()
        ];
        $hydratedData = $this->articles->hydrate($data);
        $this->articles->update(PARAMS['id'], $hydratedData);
        header('Location: ' . '/articles');
    }

    public function delete()
    {
        $this->articles->delete(PARAMS['id']);
        header('Location: ' . '/articles');
    }

}
