<?php
namespace App\Models;

use App\Core\Database;

class Model extends Database
{

    protected string $table;

    private Database $db;

    public function create(Model $model)
    {
        $keys = [];
        $inter = [];
        $values = [];

        // Loop to get parameters and values and add inter("?")
        foreach ($model as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $keys[] = $key;
                $inter[] = "?";
                $values[] = $value;
            }
        }

        // Transforms array into a string
        $list_keys = implode(', ', $keys);
        $list_inter = implode(', ', $inter);

        // Execute request
        return $this->request('INSERT INTO ' . $this->table . ' (' . $list_keys . ')VALUES(' . $list_inter . ')', $values);
    } 

    public function findAll(int $limit = 0)
    {
        // Default query
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY updated_at DESC, created_at DESC';
        // Add a limit if it is defined
        if ($limit !== 0) {
            $sql .= ' LIMIT ' . $limit;
        }
 
        // Execute request
        $query = $this->request($sql);
        return $query->fetchAll();
    }

    public function findBy(array $params)
    {
        $keys = [];
        $values = [];

        // Loop to get parameters and values
        foreach ($params as $key => $value) {
            $keys[] = "$key = ?";
            $values[] = $value;
        }

        // Transforms array into a string
        $list_keys = implode(' AND ', $keys);

        // Execute request
        return $this->request('SELECT * FROM ' . $this->table . ' WHERE ' . $list_keys, $values)->fetchAll();
    }

    public function find(int $id)
    {
        return $this->request("SELECT * FROM " . $this->table . " WHERE id = $id")->fetch();
    }

    public function update(int $id, Model $model)
    {
        $keys = [];
        $values = [];

        // Loop to get parameters and values
        foreach ($model as $key => $value) {
            if ($value !== null && $key != 'db' && $key != 'table') {
                $keys[] = "$key = ?";
                $values[] = $value;
            }
        }
        // Retrieves id from the values array
        $values[] = $id;

        // Transforms array into a string
        $list_keys = implode(', ', $keys);

        // Execute request
        return $this->request('UPDATE ' . $this->table . ' SET ' . $list_keys . ' WHERE id = ?', $values);
    }

    public function delete(int $id)
    {
        return $this->request("DELETE FROM " . $this->table . " WHERE id = ?", [$id]);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // Retrieves the setter corresponding to the key
            $setter = 'set' . ucfirst($key);
            // Check if the setter exists
            if (method_exists($this, $setter)) {
                // Call the setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    public function request(string $sql, array $params = null)
    {
        // Get instance of Database
        $this->db = Database::getInstance();

        // Check if there are any parameters
        if ($params !== null) {
            // Prepared request
            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $query;
        } else {
            // Simple request
            return $this->db->query($sql);
        }
    }

    /*
        JOINTURE
    {
        $sql = 
        "SELECT
            A.id as id,
            A.title as title,
            A.slug as slug,
            A.caption as caption,
            A.content as content,
            A.created_at as createdAt,
            A.updated_at as lastUpdate,
            B.lastname as lastnameAuthor,
            B.firstname as firstnameAuthor
        FROM article as A
        INNER JOIN user as B ON A.author_id = B.id
        WHERE A.id = :id";
        $query = $this->pdo->prepare($sql);
        $query->execute([':id' => $id]);
        $result = $query->fetch();
        if ($result === false) {
            throw new Exception("Aucun enregistrement ne correspond à '$id' dans la table 'article'.");
        }
        return $result;
    }
    */
    
}
