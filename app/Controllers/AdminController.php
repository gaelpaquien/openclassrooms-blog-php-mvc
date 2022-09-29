<?php
namespace App\Controllers;

class AdminController extends Controller
{

    public function index(): void
    {
        // Checks if user is logged in and if he is admin
        if ($this->checkAuth()['isAdmin'] === true) {
            // Render
            $this->view('pages/admin/index.html.twig');
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function indexComments()
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] === true && $this->checkAuth()['isAdmin'] === true) {

            // Pagination
            $countComments = $this->comments->countAllInvalid();
            $nbComments = (int) $countComments->nb_comments_invalid;
            $pages = $this->pagination->pagination($nbComments, 10);

            // Get data of all invalid comments
            $comments = $this->comments->findAllInvalid($pages[0]['limitFirst'], $pages[0]['perPage']);

            // Render
            $this->view('pages/admin/comments.html.twig', [
                'lastPage' => $pages[0]['lastPage'],
                'currentPage' => $pages[0]['currentPage'],
                'comments' => $comments
            ]);
        
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function indexUsers()
    {
        // Check if user is logged and if he is admin
        if ($this->checkAuth()['isLogged'] === true && $this->checkAuth()['isAdmin'] === true) {

            // Pagination
            $countComments = $this->users->countAllUsers();
            $nbComments = (int) $countComments->nb_users;
            $pages = $this->pagination->pagination($nbComments, 10);

            // Get data of all invalid comments
            $users = $this->users->findAll($pages[0]['limitFirst'], $pages[0]['perPage']);

            // Render
            $this->view('pages/admin/users.html.twig', [
                'lastPage' => $pages[0]['lastPage'],
                'currentPage' => $pages[0]['currentPage'],
                'users' => $users
            ]);
        
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

}