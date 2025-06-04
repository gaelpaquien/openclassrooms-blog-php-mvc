<?php
namespace App\Models\Article;

use App\Models\GlobalManager;
use App\Models\User\UserModel;

class ArticleManager extends GlobalManager
{

    public function findAll(int $limit, int $perPage): array
    {
        // Query
        $sql = "SELECT * FROM articles ORDER BY updated_at DESC, created_at DESC LIMIT $limit, $perPage";

        // Execute query
        $items = $this->request($sql)->fetchAll();

        // Transform result data
        $data = array();
        foreach ($items as $item) {
            $model = new ArticleModel;
            $model->setId($item->id)
                  ->setTitle($item->title)
                  ->setSlug($item->slug)
                  ->setContent($item->content)
                  ->setCaption($item->caption)
                  ->setAuthor_id($item->author_id)
                  ->setCreated_at($item->created_at)
                  ->setUpdated_at($item->updated_at)
                  ->setImage($item->image);

            array_push($data, $model);
        }

        // Return array containing ArticleModel 
        return $data;
    }

    public function findRecentsArticles(int $limit): array
    {
        // Query
        $sql = "SELECT * FROM articles ORDER BY updated_at DESC, created_at DESC LIMIT $limit";

        // Execute query
        $items = $this->request($sql)->fetchAll();

        // Transform result data
        $data = array();
        foreach ($items as $item) {
            $model = new ArticleModel;
            $model->setId($item->id)
                  ->setTitle($item->title)
                  ->setSlug($item->slug)
                  ->setContent($item->content)
                  ->setCaption($item->caption)
                  ->setAuthor_id($item->author_id)
                  ->setCreated_at($item->created_at)
                  ->setUpdated_at($item->updated_at)
                  ->setImage($item->image);

            array_push($data, $model);
        }

        // Return array containing ArticleModel 
        return $data;
    }

    public function find(int $id): array
    { 
        // Query
        $sql = "SELECT 
                    A.id as id,
                    A.title as title,
                    A.slug as slug,
                    A.content as content,
                    A.caption as caption,
                    A.created_at as created_at,
                    A.updated_at as updated_at,
                    A.author_id as author_id,
                    A.image as image,
                    B.lastname as author_lastname,
                    B.firstname as author_firstname
                FROM articles as A 
                INNER JOIN users as B ON A.author_id = B.id
                WHERE A.id = :id";

        // Execute query
        $result = $this->request($sql, ['id' => $id])->fetch();
        
        // Check id of article
        if ($result === false) {
            header('Location: /erreur/page-introuvable');
        }

        // Transform result data
        $data = array();
        $articlesModel = new ArticleModel;
        $articlesModel->setId($result->id)
                      ->setTitle($result->title)
                      ->setSlug($result->slug)
                      ->setContent($result->content)
                      ->setCaption($result->caption)
                      ->setAuthor_id($result->author_id)
                      ->setCreated_at($result->created_at)
                      ->setUpdated_at($result->updated_at)
                      ->setImage($result->image);
        $usersModel = new UserModel;
        $usersModel->setId($result->author_id)
                   ->setLastname($result->author_lastname)
                   ->setFirstname($result->author_firstname);
        array_push($data, $articlesModel, $usersModel);

        // Return array containing ArticleModel, UserModel
        return $data;
    }

}