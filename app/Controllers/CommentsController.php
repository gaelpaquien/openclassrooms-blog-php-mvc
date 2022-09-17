<?php
namespace App\Controllers;

class CommentsController extends Controller
{

    public function adminComments()
    {
        // Check if user is logged in and if he is admin
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_admin'] === 1) {

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

    public function validComment()
    {
        // Check if user is logged in and if he is admin
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_admin'] === 1) {

            // Valid comment
            $this->comments->validComment($this->params['id'], $_SESSION['auth']['user_id']);
            header('Location: /administration/commentaires');

        } else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }
    }

    public function create() 
    {
        $commentSent = false; 

        // Checks if user is logged in
        if (isset($_SESSION['auth'])) {
            
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

    public function delete()
    {
        // Check if user is logged in and if he is admin
        if (isset($_SESSION['auth']) && $_SESSION['auth']['user_admin'] === 1) {

            // Delete comment and redirection
            $this->comments->delete($this->params['id']);
            header('Location: /administration/commentaires');
            
        }   else {
            // Error : Forbidden
            header('Location: /erreur/acces-interdit');
        }

    }

}