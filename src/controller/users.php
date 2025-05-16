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
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["function"] != "ADMIN") {
            header("location: index.php");
            exit();
        } else {
            return $this->model->getUsers();
        }
    }

    public function deleteUser()
    {
        if (isset($_GET["function"]) && $_GET["function"] === "delete") {
            if (isset($_POST["id"]) && !empty($_POST["id"])) {
                $this->model->deleteUser($_POST["id"]);
            }
        }
    }
}
?>