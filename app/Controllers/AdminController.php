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
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $currentPage = (int) strip_tags($_GET['p']);
            } else {
                $currentPage = 1;
            }
            // Count all invalid comments
            $countComments = $this->comments->countAllInvalid();
            $nbComments = (int) $countComments->nb_comments_invalid;
            // Comments per page
            $perPage = 10;
            // Total page calcul
            $totalPages = intval(ceil($nbComments / $perPage));
            // Check current page
            if ($currentPage > $totalPages || $currentPage < 1) {
                $currentPage = 1;
            }
            if ($currentPage === $totalPages) {
                $lastPage = true;
            } else {
                $lastPage = false;
            }
            // Limit calcul
            $limitFirst = ($currentPage * $perPage) - $perPage;

            // Get data of all invalid comments
            $comments = $this->comments->findAllInvalid($limitFirst, $perPage);

            // Render
            $this->view('pages/admin/comments.html.twig', [
                'lastPage' => $lastPage,
                'currentPage' => $currentPage,
                'comments' => $comments
            ]);
        
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function indexUsers()
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] === true && $this->checkAuth()['isAdmin'] === true) {

            // Pagination
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $currentPage = (int) strip_tags($_GET['p']);
            } else {
                $currentPage = 1;
            }
            // Count all invalid comments
            $countComments = $this->comments->countAllInvalid();
            $nbComments = (int) $countComments->nb_comments_invalid;
            // Comments per page
            $perPage = 10;
            // Total page calcul
            $totalPages = intval(ceil($nbComments / $perPage));
            // Check current page
            if ($currentPage > $totalPages || $currentPage < 1) {
                $currentPage = 1;
            }
            if ($currentPage === $totalPages) {
                $lastPage = true;
            } else {
                $lastPage = false;
            }
            // Limit calcul
            $limitFirst = ($currentPage * $perPage) - $perPage;

            // Get data of all invalid comments
            $users = $this->users->findAll($limitFirst, $perPage);

            // Render
            $this->view('pages/admin/users.html.twig', [
                'lastPage' => $lastPage,
                'currentPage' => $currentPage,
                'users' => $users
            ]);
        
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

}