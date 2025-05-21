<?php

class ChangesModel{
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

    public function getDatasCategory(string $category): array {
        $query = $this->db->prepare("SELECT * FROM products WHERE category = :category");
        $query->bindValue(":category", $category);
        $query->execute();
        if($query === false){
            return [];
        }
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


}
