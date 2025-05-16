<?php

class HomeModel{
    public $db;

    public function __construct(Pdo $db){
        $this->db = $db;
        
    }

}

?>