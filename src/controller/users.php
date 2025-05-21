<?php
class UsersController
{

    private $model;

    public function __construct(UsersModel $model)
    {
        $this->model = $model;
    }

    public function getUsers(): array
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            return $this->model->getUsers();
        } else {
            header("location: index.php?page=home");
            exit();
        }
    }

    public function deleteUser()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {

            if (isset($_GET["function"]) && $_GET["function"] === "delete") {
                if (isset($_POST["id"]) && !empty($_POST["id"])) {
                    $this->model->deleteUser($_POST["id"]);
                }
            } 
        }else {
                header("location: index.php?page=home");
                exit();
            }
    }
}
?>