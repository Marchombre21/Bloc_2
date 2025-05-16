<?php

class UsersModel{
    public $db;

    public function __construct(Pdo $db){
        $this->db = $db;
    }

    public function getUsers(): array{
        $query = $this->db->prepare("select * from users where id != :id");
        $query->bindParam(":id", $_SESSION["user"]["id"]);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function deleteUser($id){
        $query = $this->db->prepare("delete from users where id like :id");
        $query->bindValue(":id", $id);
        $query->execute();
    }

}

?>