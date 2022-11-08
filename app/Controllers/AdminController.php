<?php
namespace App\Controllers;

class AdminController extends Controller
{

    public function index(): void
    {
        // Checks if user is logged in and if he is admin
        if ($this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit');
        }

        // Data counting (users, articles, comments)
        $countComments = $this->comment->countAll("comments");
        $countCommentsValid = $this->comment->countAllValid();
        $countUsers = $this->user->countAll("users");
        $countArticles = $this->article->countAll("articles");

        // Render
        $this->view('pages/admin/index.html.twig', [
            'comments' => $countComments->nb_comments,
            'commentsValid' => $countCommentsValid->nb_comments_valid,
            'users' => $countUsers->nb_users,
            'articles' => $countArticles->nb_articles
        ]);
    }

    public function indexComments(): void
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit'); 
        }

        // Pagination (10 comments per page)
        $countComments = $this->comment->countAllInvalid();
        $nbComments = (int) $countComments->nb_comments_invalid;
        $pages = $this->pagination->pagination($nbComments, 10);

        // Get data of all invalid comments
        $comments = $this->comment->findAllInvalid($pages[0]['limitFirst'], $pages[0]['perPage']);

        // Render
        $this->view('pages/admin/comments.html.twig', [
            'lastPage' => $pages[0]['lastPage'],
            'currentPage' => $pages[0]['currentPage'],
            'comments' => $comments
        ]);
    }

    public function indexUsers(): void
    {
        // Check if user is logged and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit');
        }

        // Pagination (10 users per page)
        $countUsers = $this->user->countAllUsers();
        $nbUsers = (int) $countUsers->nb_users;
        $pages = $this->pagination->pagination($nbUsers, 10);

        // Get data of all users (except for the admins)
        $users = $this->user->findAll($pages[0]['limitFirst'], $pages[0]['perPage']);

        // Render
        $this->view('pages/admin/users.html.twig', [
            'lastPage' => $pages[0]['lastPage'],
            'currentPage' => $pages[0]['currentPage'],
            'users' => $users
        ]);
    }

}