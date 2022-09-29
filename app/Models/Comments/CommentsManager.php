<?php
namespace App\Models\Comments;

use App\Models\Articles\ArticlesModel;
use App\Models\GlobalManager;
use App\Models\Users\UsersModel;

class CommentsManager extends GlobalManager
{

    public function countAllInvalid()
    {
        return $this->request("SELECT COUNT(*) as nb_comments_invalid FROM comments WHERE validate = 0")->fetch();
    }

    public function findAllInvalid(int $limit, int $perPage)
    {
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.author_id as author_id,
                    A.content as content,
                    A.validate as validate,
                    A.article_id as article_id,
                    A.created_at as created_at,
                    B.firstname as authorFirstname,
                    B.lastname as authorLastname,
                    C.slug as articleSlug
                FROM comments as A
                INNER JOIN users as B on A.author_id = B.id
                INNER JOIN articles as C on A.article_id = C.id
                WHERE validate = 0
                ORDER BY created_at ASC
                LIMIT $limit, $perPage";

        // Execute request
        $results = $this->request($sql)->fetchAll();

        // Transforms data
        $data = array();
        foreach ($results as $result) {
            $item = array();
            $commentsModel = new CommentsModel;
            $commentsModel->setId($result->id)
                            ->setAuthor_id($result->author_id)
                            ->setContent($result->content)
                            ->setValidate($result->validate)
                            ->setArticle_id($result->article_id)
                            ->setCreated_at($result->created_at);
            $usersModel = new UsersModel;
            $usersModel->setId($result->author_id)
                       ->setLastname($result->authorLastname)
                       ->setFirstname($result->authorFirstname);

            $articlesModel = new ArticlesModel;
            $articlesModel->setSlug($result->articleSlug);

            array_push($item, $commentsModel, $usersModel, $articlesModel);
            array_push($data, $item);
        }

        // Return data
        return $data;
    }

    public function countAllValidFromArticle(int $id)
    {
        return $this->request("SELECT COUNT(*) as nb_comments FROM comments WHERE article_id = :id AND validate = 1", ['id' => $id])->fetch();
    }

    public function findAllValidFromArticle($id, int $limit, int $perPage)
    {
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.author_id as author_id,
                    A.content as content,
                    A.created_at as created_at,
                    B.id as author_id,
                    B.lastname as author_lastname,
                    B.firstname as author_firstname,
                    C.id as admin_id,
                    C.lastname as admin_lastname,
                    C.firstname as admin_firstname
                FROM comments as A
                INNER JOIN users as B on A.author_id = B.id
                INNER JOIN users as C on A.validate_by = C.id
                WHERE article_id = :id AND A.validate = 1 
                ORDER BY created_at DESC
                LIMIT $limit, $perPage";

        // Execute Request
        $results = $this->request($sql, ['id' => $id])->fetchAll();
        
        if (empty($results)) {
            return false;
        }

        // Transforms data
        $data = array();
        foreach ($results as $result) {
            $item = array();
            $articlesModel = new CommentsModel;
            $articlesModel->setId($result->id)
                          ->setAuthor_id($result->author_id)
                          ->setContent($result->content)
                          ->setCreated_at($result->created_at);
            $usersModel = new UsersModel;
            $usersModel->setId($result->author_id)
                       ->setLastname($result->author_lastname)
                       ->setFirstname($result->author_firstname);

            array_push($item, $articlesModel, $usersModel);
            array_push($data, $item);
        }

        // Return data
        return $data;
    }

    public function validComment($comment_id, $admin_id) 
    {
        $sql = "UPDATE comments SET validate = 1, validate_by = :admin_id WHERE id = :comment_id";

        return $this->request($sql, ['admin_id' => $admin_id, 'comment_id' => $comment_id]);
    }

}