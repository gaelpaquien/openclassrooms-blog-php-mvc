<?php
namespace App\Controllers;

class CommentsController extends Controller
{
    public function create() 
    {

    }

    public function delete()
    {
        // Check if user is logged in and if he is admin
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_admin'] === 1) {

            // Delete comment and redirection
            $this->comments->delete($this->params['id']);
            header('Location: /articles');
            
        }   else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }

    }

    public function adminComments()
    {
        $this->view('pages/admin/comments.html.twig');
    }

}