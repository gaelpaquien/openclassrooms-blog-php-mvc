<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home(): void
    {
        $data = $this->articles->findAll(3);
        $this->view('pages/home.html.twig', ['articles' => $data]);
    }

    public function homeContact(): void 
    {
        if (isset($_POST) && !empty($_POST)) {
            $to = $_POST['email']; 
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $from = "gael.paquien.contact@gmail.com";
            $headers = "From:" . $from;
        
            /* Il faut paramétrer un service mail, à voir avec hébergement Infomaniak
            if (mail($to, $subject, $message, $headers)) {
                echo "Mail Sent.";
            }
            else {
                echo "failed";
            }
            */
        }
        header('Location: ' . '/#contact');
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
