<?php

class NewModel
{
    public $db;


    public function __construct(Pdo $db)
    {
        $this->db = $db;
        if (!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirmEmail"]) && !empty($_POST["confirmPassword"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["function"])) {

            $_SESSION["create"]["email"] = trim(strip_tags($_POST["email"]));
            $_SESSION["create"]["password"] = trim(strip_tags($_POST["password"]));
            $_SESSION["create"]["confirmEmail"] = trim(strip_tags($_POST["confirmEmail"]));
            $_SESSION["create"]["confirmPassword"] = trim(strip_tags($_POST["confirmPassword"]));
            $_SESSION["create"]["firstname"] = trim(strip_tags($_POST["firstname"]));
            $_SESSION["create"]["lastname"] = trim(strip_tags($_POST["lastname"]));
            $_SESSION["create"]["function"] = trim(strip_tags($_POST["function"]));
        }
    }

    public function verifyExistingMail()
    {
        $query = $this->db->prepare("SELECT email FROM users where email LIKE :email");
        $query->bindParam(":email", $_SESSION["create"]["email"], PDO::PARAM_STR);
        $query->execute();
        return $query->fetch();
    }

    public function createAccount($crypted_password)
    {
        $query = $this->db->prepare("INSERT INTO users(firstname, lastname, email, password, function, isConnected) values(:firstname, :lastname, :email, :password, :function, false)");
        $query->bindParam(":firstname", $_SESSION["create"]["firstname"], PDO::PARAM_STR);
        $query->bindParam(":lastname", $_SESSION["create"]["lastname"], PDO::PARAM_STR);
        $query->bindParam(":email", $_SESSION["create"]["email"], PDO::PARAM_STR);
        $query->bindParam(":password", $crypted_password, PDO::PARAM_STR);
        $query->bindParam(":function", $_SESSION["create"]["function"], PDO::PARAM_STR);
        return $query->execute();
    }

}

?>