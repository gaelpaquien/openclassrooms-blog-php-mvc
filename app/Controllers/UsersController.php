<?php
namespace App\Controllers;

class UsersController extends Controller
{

    public function signup(): void
    {
        $this->view('pages/auth/signup.html.twig');
    }

    public function login(): void
    {
        $this->view('pages/auth/login.html.twig');
    }

    public function indexAdmin(): void
    {
        $this->view('pages/admin/index.html.twig');
    }
    
}
