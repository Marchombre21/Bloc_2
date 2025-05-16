<?php

class EditModel{
    public $db;

    public function __construct(Pdo $db){
        $this->db = $db;
        
    }

    public function getDatasUser($id): array{
        $query = $this->db->prepare("select * from users where id like :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getDatasProduct($categorie, $name): array{
        $query = $this->db->prepare("select * from :categorie where name like :name");
        $query->bindValue(":categorie", $categorie);
        $query->bindValue(":name", $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function applyEditsUser($firstname, $lastname, $email, $function, $id):bool{
        $query = $this->db->prepare("update users set firstname = :firstname, lastname = :lastname, email = :email, function = :function where id like :id");
        $query->bindValue(":firstname", $firstname);
        $query->bindValue(":lastname", $lastname);
        $query->bindValue(":email", $email);
        $query->bindValue(":function", $function);
        $query->bindValue(":id", $id);
         return $query->execute();
    }


}
?>