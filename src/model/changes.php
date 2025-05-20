<?php

class CHangesModel{
    public $db;

    public function __construct(Pdo $db){
        $this->db = $db;
        
    }

    public function getCategories() {
        $query = $this->db->query('select * from categories');
        if($query === false){
            return [];
        }
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getDatasCategory($categorie){
        $query = $this->db->prepare("select * from products where category like :id");
        $query->bindValue(":id", $categorie);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>