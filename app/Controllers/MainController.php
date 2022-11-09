<?php
namespace App\Controllers;

class MainController extends Controller
{

    public function home(): void
    {
        $sentMail = null;

        // Get data of recents articles with limit (3)
        $articles = $this->article->findRecentsArticles(3);

        
        if (!empty($this->superglobal->get_GET()['sentMail']) && true == $this->superglobal->get_GET()['sentMail']) {
            $sentMail = "Votre mail a bien été envoyé.";
            $this->view('pages/global/home.html.twig', [
                'articles' => $articles,
                'sentMail' => $sentMail
            ]);
            return;
        }

        if (!empty($this->superglobal->get_GET()['sentMail']) && false == $this->superglobal->get_GET()['sentMail']) {
            $sentMail = "Votre mail n'a pas pu être envoyé.";
            $this->view('pages/global/home.html.twig', [
                'articles' => $articles,
                'sentMail' => $sentMail
            ]);
            return;
        }

        // Render
        $this->view('pages/global/home.html.twig', [
            'articles' => $articles,
            'sentMail' => $sentMail
        ]);
    }

    public function homeContact(): void 
    {
        // Check if form as sent
        if (empty($this->superglobal->get_POST())) {
            header('Location: /?sentMail=0');
            return;
        }

        // Check token form to prevent CSRF attack
        if (false === $this->formValidator->checkToken($this->superglobal->get_POST()['token'])) {
            header('Location: /?sentMail=0');
            return;
        };

        // Mail configuration
        $to = $this->superglobal->get_ENV()['MAIL_CONTACT'];
        $email = $this->superglobal->get_POST()['email'];
        $lastname = $this->superglobal->get_POST()['lastname'];
        $firstname = $this->superglobal->get_POST()['firstname'];
        $subject = $this->superglobal->get_POST()['subject'];
        $message = $firstname . " " . $lastname . " (" . $email . ")\r\n" . $this->superglobal->get_POST()['message'];
        $headers = "From:" . $to;
        $date = $this->date->getDateNow();

        // Check if mail as sent
        if (mail($to, $subject, $message, $headers)) {
            // Add data of contact in array
            $contact = [
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'subject' => $subject,
                'message' => $message,
                'sent_at' => $date
            ];

            // Creation of contact and redirection
            $this->contact->create('contact_messages', $this->contact->hydrate($contact));
        
            // Redirection
            header('Location: /?sentMail=1');
            return;
        }

        // Redirection
        header('Location: /?sentMail=0');
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
