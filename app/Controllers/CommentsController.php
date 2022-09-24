<?php
namespace App\Controllers;

class CommentsController extends Controller
{

    public function create() 
    {
        $commentSent = false; 

        // Checks if user is logged in
        if ($this->checkAuth()['isLogged'] === true) {
            
            // Check if form as sent
            if (isset($_POST) && !empty($_POST)) {

                // Add data of article in array
                $data = [
                    'author_id' => $_SESSION['auth']['user_id'],
                    'content' => $_POST['content'],
                    'article_id' => $this->params['id'],
                ];

                // Creation of article and redirection
                $hydratedData = $this->comments->hydrate($data);
                $this->comments->create($hydratedData); 
                $commentSent = true;
                header('Location: /article/' . $this->params['slug'] . '/' . $this->params['id'] . '?commentSent=' . $commentSent);
                
            }
        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function validation()
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] === true && $this->checkAuth()['isAdmin'] === true) {

            // Valid comment
            $this->comments->validComment($this->params['id'], $_SESSION['auth']['user_id']);
            header('Location: /administration/commentaires');

        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function delete()
    {
        // Check if user is logged in and if he is admin
        if ($this->checkAuth()['isLogged'] === true && $this->checkAuth()['isAdmin'] === true) {

            // Delete comment and redirection
            $this->comments->delete($this->params['id']);
            header('Location: /administration/commentaires');
            
        }   else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }

    }

}