<?php
namespace App\Controllers;

class UsersController extends Controller
{

    public function signup()
    {
        $this->view('pages/auth/signup.html.twig');
    }

    public function login()
    {
        $this->view('pages/auth/login.html.twig');
    }

    public function indexAdmin()
    {
        $this->view('pages/admin/index.html.twig');
    }
    
}
