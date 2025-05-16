<?php

class ResetModel{
    public $db;

    public function __construct(Pdo $db){
        $this->db = $db;
    }
    public function verifyEmail($email) {
         $query = $this->db->prepare("SELECT email FROM users where email like :email");
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchColumn();
    }

    public function createToken($token, $email){
            $query = $this->db->prepare("INSERT INTO reset_password(email, token) values (:email, :token)");
            $query->bindParam(":token", $token) ;
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->execute();

           
        
    }

    public function cleanTokens(){
        $this->db->query("DELETE FROM reset_password where TIMESTAMPDIFF(MINUTE, time, NOW()) >= 15");
    }
    public function getToken($token)  {
        $query = $this->db->prepare("SELECT * FROM reset_password WHERE token LIKE :token");
        $query->bindParam(":token", $token, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch();
    }

    public function createNewPassword($email, $crypted_password): bool{
        
            $query = $this->db->prepare("UPDATE users set password = :password where email LIKE :email");
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->bindParam(":password", $crypted_password) ;
            return $query->execute();
            
        }

}

?>