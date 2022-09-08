<?php
namespace App\Controllers;

use App\Models\UsersModel;

class UsersController extends Controller
{

    public function signup(): void
    {
        $this->view('pages/auth/signup.html.twig');
    }

    public function login(): void
    {
        //echo password_hash('admin', PASSWORD_DEFAULT);exit();
        if (isset($_POST) && !empty($_POST)) {
            $user = $this->users->findBy('email', $_POST['email']);
            if (password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['auth'] = [
                    'user_id' => $user->getId(),
                    'user_admin' =>$user->getAdmin()
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
        $this->view('pages/admin/index.html.twig');
    }
    
}
