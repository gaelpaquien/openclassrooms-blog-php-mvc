<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home()
    {
        $data = $this->articles->findAllWithLimit(3);
        $this->view('pages/home.html.twig', ['articles' => $data]);
    }

    public function error()
    {
        $this->view('pages/errors/404.html.twig');
    }

}
