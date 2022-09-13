<?php
namespace App\Controllers;

class UsersController extends Controller
{

    public function signup(): void
    {
        $errors = null;

        // Check if form as sent
        if (isset($_POST) && !empty($_POST)) {
            $errors = [];

            // Check if email already exists
            $checkEmail = $this->users->checkExists('email', $_POST['email']);
            if ($checkEmail === false) {
                // Check if password and password-confirm match
                if ($_POST['password'] === $_POST['password-confirm']) {

                    // Add data of user in array
                    $data = [
                        'email' => $_POST['email'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname']
                    ];

                    // Creation of user and redirection
                    $hydratedData = $this->users->hydrate($data);
                    $this->users->create($hydratedData); 
                    header('Location: ' . '/'); 

                } else {
                    // Password-confirm error
                    $errors += ['password-confirm' => 'Le mot de passet la confirmation du mot de passe doivent être identiques'];
                }
            } else {
                // Email error
                $errors += ['email' => 'Cet email est déjà utilisé'];
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
            $errors = [];

            // Check user email and password
            $user = $this->users->findBy('email', $_POST['email']);
            if ($user !== null) {
                if (password_verify($_POST['password'], $user->getPassword())) {
                    $_SESSION['auth'] = [
                        'user_id' => $user->getId(),
                        'user_admin' => $user->getAdmin()
                    ];
                    header('Location: /');
                } else {
                    // Password error
                    $errors += ['auth' => 'Email ou mot de passe incorrect'];
                }
            } else {
                // Email error
                $errors += ['auth' => 'Email ou mot de passe incorrect'];
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

    public function indexAdmin(): void
    {
        // Checks if user is logged in and if he is admin
        if (isset($_SESSION['auth']['user_admin']) && $_SESSION['auth']['user_admin'] === 1) {
            // Render
            $this->view('pages/admin/index.html.twig');
        } else {
            // Render Forbidden
            $this->view('pages/errors/forbidden.html.twig');
        }
        
    }
    
}
