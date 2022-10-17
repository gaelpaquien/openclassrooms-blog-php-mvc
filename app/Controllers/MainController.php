<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home(): void
    {
        // Get data of all articles with limit
        $data = $this->articles->findAll(3, 3);

        // Render
        $this->view('pages/global/home.html.twig', ['articles' => $data]);
    }

    public function homeContact(): void 
    {
        // Check if form as sent
        if (!empty($this->superglobals->get_POST())) {
            
            $to = "gael.paquien.contact@gmail.com"; 
            $subject = $this->superglobals->get_POST()['subject'];
            $message = $this->superglobals->get_POST()['message'];
            $from = $this->superglobals->get_POST()['email'];
            $headers = "From:" . $from;

            mail(
                $to,
                $subject,
                $message,
                $headers
            );
        }

        // Redirection
        header('Location: /#contact');
    }

    public function termsOfUse(): void
    {
        // Render
        $this->view('pages/global/termsOfUse.html.twig');
    }

    public function privacyPolicy(): void
    {
        // Render
        $this->view('pages/global/privacyPolicy.html.twig');
    }

    public function errorNotFound(): void
    {
        // Render
        $this->view('pages/errors/404.html.twig');
    }

    public function errorForbidden(): void
    {
        // Render
        $this->view('pages/errors/forbidden.html.twig');
    }

}
