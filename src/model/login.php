<?php

class LoginModel
{
    public $db;
    public $lastname;
    public $firstname;
    public $password;


    public function __construct(Pdo $db)
    {
        $this->db = $db;
        if (!empty($_POST)) {
            $this->lastname = trim(strip_tags($_POST['lastname']));
            $this->firstname = trim(strip_tags($_POST['firstname']));
            $this->password = trim(strip_tags($_POST['password']));
            $_SESSION["loginPage"]["loginLastname"] = $_POST['lastname'];
            $_SESSION["loginPage"]["loginFirstname"] = $_POST['firstname'];
            $_SESSION["loginPage"]["loginPassword"] = $_POST['password'];
        }
    }

    public function verifyUser()
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE firstname LIKE :firstname AND lastname LIKE :lastname");
        $query->bindParam(":firstname", $this->firstname, PDO::PARAM_STR);
        $query->bindParam(":lastname", $this->lastname, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch();
    }
}

?>