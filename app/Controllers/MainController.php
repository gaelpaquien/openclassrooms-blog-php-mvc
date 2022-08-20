<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home()
    {
        $data = $this->articles->findAll(3);
        $this->view('pages/home.html.twig', ['articles' => $data]);
    }

    public function termsOfUse()
    {
        $this->view('pages/others/termsOfUse.html.twig');
    }

    public function privacyPolicy()
    {
        $this->view('pages/others/privacyPolicy.html.twig');
    }

    public function error()
    {
        $this->view('pages/errors/404.html.twig');
    }

}
