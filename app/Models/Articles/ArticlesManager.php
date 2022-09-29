<?php
namespace App\Models\Articles;

use App\Models\GlobalManager;
use App\Models\Users\UsersModel;

class ArticlesManager extends GlobalManager
{

    public function findAll(int $limit, int $perPage): array
    {
        // Query
        $sql = "SELECT * FROM articles ORDER BY updated_at DESC, created_at DESC LIMIT $limit, $perPage";

        // Execute request
        $items = $this->request($sql)->fetchAll();

        // Transforms and return data
        $data = array();
        foreach ($items as $item) {
            $model = new ArticlesModel;
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

        // Execute request
        $result = $this->request($sql, ['id' => $id])->fetch();
        
        // Checks id of article
        if ($result === false) {
            header('Location: /erreur/page-introuvable');
        }

        // Transforms data
        $data = array();
        $articlesModel = new ArticlesModel;
        $articlesModel->setId($result->id)
                      ->setTitle($result->title)
                      ->setSlug($result->slug)
                      ->setContent($result->content)
                      ->setCaption($result->caption)
                      ->setAuthor_id($result->author_id)
                      ->setCreated_at($result->created_at)
                      ->setUpdated_at($result->updated_at)
                      ->setImage($result->image);
        $usersModel = new UsersModel;
        $usersModel->setId($result->author_id)
                   ->setLastname($result->author_lastname)
                   ->setFirstname($result->author_firstname);
        array_push($data, $articlesModel, $usersModel);

        // Return data
        return $data;
    }

}