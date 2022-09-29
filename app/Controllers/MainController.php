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
        if (isset($_POST) && !empty($_POST)) {
            /*
            $to = $_POST['email']; 
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $from = "gael.paquien.contact@gmail.com";
            $headers = "From:" . $from;
        
            
            if (mail($to, $subject, $message, $headers)) {
                echo "Mail Sent.";
            }
            else {
                echo "failed";
            }
            */
            dump('WIP');exit();
            
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
