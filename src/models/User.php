<?php 

use App\Database;

function getUsers() {
    $db = Database::getPDO();
    $sql = "SELECT * FROM user";
    $query = $db->prepare($sql);
    $query->execute();

    $users = [];
    while ($row = $query->fetch()) {
        $user = [
            'prenom' => $row['prenom']
        ];
        $users[] = $user;
    }
    return $users;
}

?>