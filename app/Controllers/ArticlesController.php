<?php
namespace App\Controllers;

use App\Controllers\Helpers\Text;

class ArticlesController extends Controller
{

    public function create()
    {
        $this->view('pages/articles/create.html.twig');
    }

    public function createConfirmation()
    {
        $slug = new Text;

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug->slugify($_POST['title']),
            'caption' => $_POST['caption'],
            'content' => $_POST['content'],
            'author_id' => 1
        ];
        $hydratedData = $this->articles->hydrate($data);
        $this->articles->create($hydratedData); 
        header('Location: ' . "/articles");
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

}
