<?php
namespace App\Models\User;

use App\Models\GlobalManager;
use PDOStatement;

class UserManager extends GlobalManager
{

    public function countAllUsers()
    {
        return $this->request("SELECT COUNT(*) as nb_users FROM users WHERE admin = 0")->fetch();
    }

    public function findAll(int $limit, int $perPage)
    {
        // Query
        $sql = "SELECT *
                FROM users as A
                WHERE admin = 0
                ORDER BY created_at ASC
                LIMIT $limit, $perPage";

        // Execute request
        $results = $this->request($sql)->fetchAll();

        // Transforms data
        $data = array();
        foreach ($results as $result) {
            $usersModel = new UserModel();
            $usersModel->setId($result->id)
                       ->setEmail($result->email)
                       ->setFirstname($result->firstname)
                       ->setLastname($result->lastname)
                       ->setCreated_at($result->created_at);
            array_push($data, $usersModel);
        }

        // Return data
        return $data;
    }

    public function findBy(string $params, string $value) : UserModel | null
    {
        $user = null;

        // Query 
        $sql = "SELECT * FROM users WHERE $params = :value";

        // Execute request
        $result = $this->request($sql, ['value' => $value])->fetch();

        // Check result and create UsersModel
        if ($result) {
            $user = new UserModel;
            $user->setId($result->id)
                 ->setEmail($result->email)
                 ->setPassword($result->password)
                 ->setFirstname($result->firstname)
                 ->setLastname($result->lastname)
                 ->setAdmin($result->admin)
                 ->setCreated_at($result->created_at);
        }

        // Return $user
        return $user;
    }

    public function find(int $id): PDOStatement | false
    {
        // Query 
        $sql = "SELECT * FROM users WHERE id = :id";

        // Execute request
        return $this->request($sql, ['id' => $id])->fetch();
    }

    public function findAllAdmin()
    {
        return $this->request("SELECT * FROM users WHERE admin = 1")->fetchAll();
    }

}