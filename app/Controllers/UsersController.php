<?php
namespace App\Controllers;

use App\Models\UsersModel;

class UsersController extends Controller
{

    public function signup(): void
    {
        $errors = [];

        if (isset($_POST) && !empty($_POST)) {
            // Check if email exist
            $checkEmailExist = $this->users->checkExist('email', $_POST['email']);
            if ($checkEmailExist === false) {
                // Check if the password and password confirmation match
                if ($_POST['password'] === $_POST['password-confirm']) {
                    // Retrieve data from an array
                    $data = [
                        'email' => $_POST['email'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname']
                    ];
                    $hydratedData = $this->users->hydrate($data);
                    $this->users->create($hydratedData); 
                    header('Location: ' . '/'); 
                } else {
                    $errors += ['confirmPassword' => 'Les champs mot de passe et confirmation du mot de passe ne correspondent pas'];
                }
            } else {
                $errors += ['email' => 'Cet email est déjà utilisé'];
            }
        }

        $this->view('pages/auth/signup.html.twig', ['errors' => $errors]);
    }

    public function login(): void
    {
        //echo password_hash('admin', PASSWORD_DEFAULT);exit();
        if (isset($_POST) && !empty($_POST)) {
            $user = $this->users->findBy('email', $_POST['email']);
            if (password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['auth'] = [
                    'user_id' => $user->getId(),
                    'user_admin' => $user->getAdmin()
                ];
                header('Location: /');
            } else {
                header('Location: /connexion');
            }
        }
        
        $this->view('pages/auth/login.html.twig');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
    }

    public function indexAdmin(): void
    {
        if (isset($_SESSION['auth']['user_admin']) && $_SESSION['auth']['user_admin'] === 1) {
            $this->view('pages/admin/index.html.twig');
        } else {
            $this->view('pages/errors/forbidden.html.twig');
        }
        
    }
    
}
