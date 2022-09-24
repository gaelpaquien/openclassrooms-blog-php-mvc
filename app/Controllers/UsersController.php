<?php
namespace App\Controllers;

class UsersController extends Controller
{

    public function signup(): void
    {
        $errors = null;

        // Check if form as sent
        if (isset($_POST) && !empty($_POST)) {

            // Check if email already exists
            $checkEmail = $this->users->checkExists('email', $_POST['email']);
            if ($checkEmail === false) {
                
                // Check if password and password-confirm match
                if ($_POST['password'] === $_POST['password-confirm']) {

                    // Add data of user in array
                    $data = [
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname']
                    ];

                    // Check form data
                    $errors = $this->formValidator->checkSignupForm($data);

                    // If check form data is ok
                    if ($errors === null) {
                        // Hash password
                        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        // Creation of user and redirection
                        $hydratedData = $this->users->hydrate($data);
                        $this->users->create($hydratedData); 
                        header('Location: ' . '/'); 
                    }

                } else {
                    // Error : Password and password-confirm don't match
                    $errors = $this->errorsHandling->newError('Le mot de passe et la confirmation du mot de passe doivent corespondres.');
                }
            } else {
                // Error : Email already exist
               $errors = $this->errorsHandling->newError('Cette adresse email existe déjà.');
            }
        }
        // Render
        $this->view('pages/auth/signup.html.twig', ['errors' => $errors]);
    }

    public function login(): void
    {
        $errors = null;

        // Check if form as sent
        if (isset($_POST) && !empty($_POST)) {

            // Check if email exist
            $user = $this->users->findBy('email', $_POST['email']);
            if ($user !== null) {

                // Check if password match
                if (password_verify($_POST['password'], $user->getPassword())) {

                    // Save user data in session and redirection
                    $_SESSION['auth'] = [
                        'user_id' => $user->getId(),
                        'user_admin' => $user->getAdmin()
                    ];
                    header('Location: /');

                } else {
                    // Error : invalid password
                    $errors = $this->errorsHandling->newError('Email et/ou mot de passe incorrect.');
                }
            } else {
                // Error : invalid email
                $errors = $this->errorsHandling->newError('Email et/ou mot de passe incorrect.');
            }
        }
        // Render
        $this->view('pages/auth/login.html.twig', ['errors' => $errors]);
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
        if ($this->checkAuth()['isLogged'] === true && $this->checkAuth()['isAdmin'] === true) {

            // Delete comment and redirection
            $this->users->delete($this->params['id']);
            header('Location: /administration/utilisateurs');
            
        }   else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }

    }

}
