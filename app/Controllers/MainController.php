<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home(): void
    {
        $data = $this->articles->findAll(3);
        $this->view('pages/home.html.twig', ['articles' => $data]);
    }

    public function termsOfUse(): void
    {
        $this->view('pages/others/termsOfUse.html.twig');
    }

    public function privacyPolicy(): void
    {
        $this->view('pages/others/privacyPolicy.html.twig');
    }

    public function error(): void
    {
        $this->view('pages/errors/404.html.twig');
    }

}
