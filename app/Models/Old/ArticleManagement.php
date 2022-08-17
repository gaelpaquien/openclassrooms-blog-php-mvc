<?php
namespace App\Models\Old;

use App\Core\Database;
use Exception;

class ArticleManagement {

    protected \PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create(array $data) 
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO article SET " . implode(', ', $sqlFields));
        $result = $query->execute($data);
        if ($result === false) {
            throw new Exception("Enregistrement impossible dans la table 'article'.");
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function find(int $id) 
    {
        $sql = 
        "SELECT
            A.id as id,
            A.title as title,
            A.slug as slug,
            A.short_description as shortDescription,
            A.content as content,
            A.created_at as createdAt,
            A.last_update as lastUpdate,
            B.lastname as lastnameAuthor,
            B.firstname as firstnameAuthor
        FROM article as A
        INNER JOIN user as B ON A.user_id = B.id
        WHERE A.id = :id";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id' => $id]);
        $result = $query->fetch();
        if ($result === false) {
            throw new Exception("Aucun enregistrement ne correspond à '$id' dans la table 'article'.");
        }
        return $result;
    }

    public function findAll(?int $limit = null) 
    {
        $sql = "SELECT * FROM article ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT $limit";
        }
        return $this->pdo->query($sql);
    }

    public function update(array $data, int $id) 
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE article SET " . implode(', ', $sqlFields) . " WHERE id = :id");
        $result = $query->execute(array_merge($data, ['id' => $id]));
        if ($result === false) {
            throw new Exception("Impossible de modifier l'enregistrement $id dans la table 'article'.");
        }
    }

    public function delete(int $id) 
    {
        $query = $this->pdo->prepare("DELETE FROM article WHERE id = :id");
        $result = $query->execute([':id' => $id]);
        if ($result === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table 'article'.");
        }
    }

}