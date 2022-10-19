<?php
namespace App\Controllers;

class UsersController extends Controller
{

    public function signup(): void
    {
        $error = null;

        // Check if form as sent
        if (empty($this->superglobals->get_POST())) {
            $this->view('pages/auth/login.html.twig', ['error' => $error]);
            return;
        }

        // Check if email already exists
        $checkEmail = $this->users->checkExists('users', 'email', $this->superglobals->get_POST()['email']);
        if (false === $checkEmail) {
            $error = "Cette adresse email existe déjà.";
            $this->view('pages/auth/login.html.twig', ['error' => $error]);
            return;
        }
                
        // Check if password and password-confirm match
        if ($this->superglobals->get_POST()['password'] !== $this->superglobals->get_POST()['password-confirm']) {
            $error = "Le mot de passe et la confirmation du mot de passe doivent corespondres.";
            $this->view('pages/auth/login.html.twig', ['error' => $error]);
            return;
        }

        // Add data of user in array
        $data = [
            'email' => $this->superglobals->get_POST()['email'],
            'password' => $this->superglobals->get_POST()['password'],
            'firstname' => $this->superglobals->get_POST()['firstname'],
            'lastname' => $this->superglobals->get_POST()['lastname']
        ];

        // Check form data
        $errors = $this->formValidator->checkSignupForm($data);

        // Check if form data is ok
        if (null === $errors) {
            // Hash password
            $data['password'] = password_hash($this->superglobals->get_POST()['password'], PASSWORD_DEFAULT);
            // Creation of user and redirection
            $hydratedData = $this->users->hydrate($data);
            $this->users->create('users', $hydratedData); 
            header('Location: ' . '/'); 
        }
    }

    public function login(): void
    {
        $error = null;

        // Check if form as sent
        if (empty($this->superglobals->get_POST())) {
            $this->view('pages/auth/login.html.twig', ['error' => $error]);
            return;
        }

        // Check if the email exists and if the password and the confirmation password are identical
        $user = $this->users->findBy('email', $this->superglobals->get_POST()['email']);
        if (null === $user || !password_verify($this->superglobals->get_POST()['password'], $user->getPassword())) {
            $error = "Email et/ou mot de passe incorrect.";
            $this->view('pages/auth/login.html.twig', ['error' => $error]);
            return;
        }

        // Save user data in session and redirection
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_admin'] = $user->getAdmin();
        header('Location: /');
    }

    public function logout(): void
    {
        // Destroy session and redirection
        session_destroy();
        header('Location: /');
    }

    public function delete()
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }  

        // Delete comment if user is author
        $comments = $this->comments->findAllBy('comments', 'author_id', $this->params['id']);
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $this->comments->delete('comments', $comment->id);
            }
        }

        // Delete article if user is author
        $articles = $this->articles->findAllBy('articles', 'author_id', $this->params['id']);
        if (!empty($articles)) {
            foreach ($articles as $article) {
                $articleComments = $this->comments->findAllBy('comments', 'article_id', $article->id);
                if (!empty($articleComments)) {
                    foreach ($articleComments as $comment) {
                        $this->comments->delete('comments', $comment->id);
                    }
                }
                $this->articles->delete('articles', $article->id);
            }
        }
        
        // Delete user and redirection
        $this->users->delete('users', $this->params['id']);
        header('Location: /administration/utilisateurs');
    }

}
