<?php
namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;

class MainController extends Controller
{

    public function home(): void
    {
        // Get data of recents articles with limit (3)
        $articles = $this->article->findRecentsArticles(3);

        // Render
        $this->view('pages/global/home.html.twig', [
            'articles' => $articles
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
        }

        // Get data for mail
        $firstname = $this->superglobal->get_POST()['firstname'];
        $lastname = $this->superglobal->get_POST()['lastname'];
        $email = $this->superglobal->get_POST()['email'];
        $subject = $this->superglobal->get_POST()['subject'];
        $message = $this->superglobal->get_POST()['message'];
        $date = $this->date->getDateNow();

        // Mail configuration
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->setFrom($_ENV['SMTP_USERNAME'], 'Contact - Blog Gaël Paquien');
        $mail->addReplyTo($email, $firstname . ' ' . $lastname);
        $mail->addAddress($_ENV['SMTP_MAIL_TO']);
        $mail->Subject = $subject;
        $mail->Body =
            "Message envoyé depuis le formulaire de contact par " . $firstname . " " . $lastname . " (" . $email . ")\r\n"
            . "Email de réponse: " . $email . "\r\n"
            . str_repeat('-', 130) . "\r\n"
            . $message;

        // If mail as not sent
        if (!$mail->send()) {
            error_log("PHPMailer Error: " . $mail->ErrorInfo);
            $sentMail = "Votre mail n'a pas pu être envoyé.";
            $this->view('pages/global/home.html.twig', [
                'articles' => $this->article->findRecentsArticles(3),
                'sentMail' => $sentMail
            ]);

            return;
        }

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

        // Render if mail as sent
        $sentMail = "Votre mail a bien été envoyé.";
        $this->view('pages/global/home.html.twig', [
            'articles' => $this->article->findRecentsArticles(3),
            'sentMail' => $sentMail
        ]);

        return;
    }

    public function legalNotice(): void
    {
        // Render
        $this->view('pages/global/legalNotice.html.twig');
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
