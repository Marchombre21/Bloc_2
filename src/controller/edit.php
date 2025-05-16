<?php
class EditController
{

    private $model;

    public function __construct(EditModel $model)
    {
        $this->model = $model;
    }

    public function getDatas(): array
    {
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["function"] != "ADMIN") {
            header("location: index.php");
            exit();
        } else {
            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                return $this->model->getDatasUser($_GET["id"]);
            }
            if (isset($_GET["name"]) && !empty($_GET["name"])) {
                return $this->model->getDatasProduct($_GET["categorie"], $_GET["name"]);
            }
            return [];
        }
    }

    public function applyEdits()
    {
        if (isset($_GET["target"]) && $_GET["target"] === "user") {
            $_SESSION["edit"]["firstname"] = $_POST["firstname"];
            $_SESSION["edit"]["lastname"] = $_POST["lastname"];
            $_SESSION["edit"]["email"] = $_POST["email"];
            $_SESSION["edit"]["function"] = $_POST["function"];
            
            if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["email"]) && !empty($_POST["function"])) {
                $edited = $this->model->applyEditsUser($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["function"], $_SESSION["edit"]["id"]);
                if($edited){
                    unset($_SESSION["edit"]);
                    header("location: index.php?page=home");
                    exit();
                }
            } else {
                $_SESSION["edit"]["errors"] = "Tous les champs doivent être remplis";
                $id = $_SESSION["edit"]["id"];
                header("location:index.php?page=edit&id=$id");
                exit();
            }
        }
    }

}
?>