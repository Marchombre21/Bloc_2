<?php
class ChangesController
{

    private $model;

    public function __construct(ChangesModel $model)
    {
        $this->model = $model;
    }

    public function getDatas()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_GET["category"]) && !empty($_GET["category"])) {
                $_SESSION["changes"]["category"] = $_GET["category"];
                $_SESSION["changes"]["categoryName"]= $_GET["categoryName"];
                return $this->model->getDatasCategory($_GET["category"]);
            }else{
                return $this->model->getCategories();
            }
        } else {
            header("location: index.php?page=login");
            exit();
        }
    }


}
?>