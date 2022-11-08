<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home(): void
    {
        // Get data of all articles with limit (3)
        $articles = $this->article->findAll(3, 3);

        // Render
        $this->view('pages/global/home.html.twig', ['articles' => $articles]);
    }

    public function homeContact(): void 
    {
        // Check if form as sent
        if (!empty($this->superglobal->get_POST())) {
            // Check token form to prevent CSRF attack
            if (false === $this->formValidator->checkToken($this->superglobal->get_POST()['token'])) {
                header('Location: /#contact');
            };

            // Mail system configuration
            $to = $this->superglobal->get_ENV()['MAIL_CONTACT'];
            $subject = $this->superglobal->get_POST()['subject'];
            $message = $this->superglobal->get_POST()['message'];
            $from = $this->superglobal->get_POST()['email'];
            $headers = "From:" . $from;

            // Send mail
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
    
    public function errorNotFound(): void
    {
        // Render
        $this->view('pages/error/404.html.twig');
    }

    public function errorForbidden(): void
    {
        // Render
        $this->view('pages/error/forbidden.html.twig');
    }

}
