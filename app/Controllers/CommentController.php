<?php
namespace App\Controllers;

class CommentController extends Controller
{

    public function create(): void
    {
        $commentSent = false; 

        // Check if user is logged in
        if ($this->checkAuth()['isLogged'] !== true) {
            header('Location: /erreur/acces-interdit');
        } 
        

        // Check if form as sent
        if (!empty($this->superglobal->get_POST())) {
            // Check token form to prevent CSRF attack
            if (false === $this->formValidator->checkToken($this->superglobal->get_POST()['token'])) {
                header('Location: /article/' . $this->params['slug'] . '/' . $this->params['id']);
            };

            // Add data of comment in array
            $comment = [
                'author_id' => $this->superglobal->get_SESSION()['user_id'],
                'content' => $this->superglobal->get_POST()['content'],
                'article_id' => $this->params['id'],
            ];

            // Creation of comment and redirection
            $this->comment->create('comments', $this->comment->hydrate($comment)); 
            $commentSent = true;
            header('Location: /article/' . $this->params['slug'] . '/' . $this->params['id'] . '?commentSent=' . $commentSent);
        }
    }

    public function validation(): void
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit');
        } 

        // Valid comment and redirection
        $this->comment->validComment($this->params['id'], $this->superglobal->get_SESSION()['user_id']);
        header('Location: /administration/commentaires');
    }

    public function delete(): void
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] !== true && $this->checkAuth()['isAdmin'] !== true) {
            header('Location: /erreur/acces-interdit');
        }

        // Delete comment and redirection
        $this->comment->delete('comments', $this->params['id']);
        header('Location: /administration/commentaires');
    }

}