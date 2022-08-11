<?php 
namespace App\Models\GlobalQueries;

use App\Core\Database;
use \Exception;
use \PDO;

abstract class GlobalQueries {

    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct()
    {
        if ($this->table === null) {
            throw new Exception("La class " . get_class($this) . " n'a pas de propriété table.");
        }
        if ($this->class === null) {
            throw new Exception("La class " . get_class($this) . " n'a pas de propriété class.");
        }
        $this->pdo = Database::getPDO();
    }

    public function find(int $id) 
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new Exception("Aucun enregistrement ne correspond à $id dans la table '{$this->table}'.");
        }
        return  $result;
    }

    public function all(): array 
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();      
    }

    public function update (array $data, int $id)
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id = :id");
        $result = $query->execute(array_merge($data, ['id' => $id]));
        if ($result === false) {
            throw new Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }

}
