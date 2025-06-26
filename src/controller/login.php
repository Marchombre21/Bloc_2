<?php

use Composer\Autoload\ClassLoader;
class LoginController
{

    private $model;

    public function __construct(LoginModel $model)
    {
        $this->model = $model;
    }

    public function login()
    {
        $user = $this->model->verifyUser();
        if (!$user) {
            $_SESSION["wrong"] = "Aucun utilisateur connu sous ces identifiants!";
        } else {
            if (password_verify($this->model->password, $user["password"])) {
                $_SESSION["user"] = [
                    "id" => $user["id"],
                    "function" => $user["function"],
                    "ip" => $_SERVER["REMOTE_ADDR"]
                ];
                unset($_SESSION["loginPage"]);
                unset($_SESSION["wrong"]);
                if ($user["function"] === "ADMIN") {
                    header("location: home");
                    exit();
                }
                if ($user["function"] === "ACC") {
                    header("location: /commande/accueil/index.html");
                    exit();
                }
                if ($user["function"] === "PREP") {
                    header("location: /commande/preparation/html/index.html");
                    exit();
                }

            } else {
                $_SESSION["wrong"] = "Aucun utilisateur connu sous ces identifiants!";
            }
        }
    }
}
?>