<?php
class EditController
{

    private $model;

    public function __construct(EditModel $model)
    {
        $this->model = $model;
    }

    public function getDatas()
    {
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["function"] != "ADMIN") {
            header("location: index.php");
            exit();
        } else {
            //Ici pas besoin de faire des trim strip tags vu que ce n'est pas l'utilisateur qui écrit ce qu'il veut.
            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                return $this->model->getDatasUser($_GET["id"]);
            } else if (isset($_GET["name"]) && !empty($_GET["name"]) && isset($_SESSION["changes"])) {
                if ($_GET["name"] === "description") {
                    return $this->model->getDescription($_SESSION["changes"]["category"]);
                } else {
                    // echo 'coucou';
                    $_SESSION['changes']["name"] = trim(strip_tags($_GET["name"]));
                    return $this->model->getDatasProduct($_GET["name"]);
                }
            } else {
                return [];
            }
        }
    }

    public function applyEdits()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN") {
            if (isset($_GET["target"]) && $_GET["target"] === "user") {
                $_SESSION["edit"]["firstname"] = trim(strip_tags($_POST["firstname"]));
                $_SESSION["edit"]["lastname"] = trim(strip_tags($_POST["lastname"]));
                $_SESSION["edit"]["email"] = trim(strip_tags($_POST["email"]));
                $_SESSION["edit"]["function"] = trim(strip_tags($_POST["function"]));

                if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["email"]) && !empty($_POST["function"])) {
                    $edited = $this->model->applyEditsUser($_SESSION["edit"]["firstname"], $_SESSION["edit"]["lastname"], $_SESSION["edit"]["email"], $_SESSION["edit"]["function"], $_SESSION["edit"]["id"]);
                    if ($edited) {
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
            } else if (isset($_GET["target"]) && $_GET["target"] === "product") {
                if (isset($_GET["id"]) && !empty($_GET['id'])) {
                    //Les fichiers envoyés via un formulaire ne se récupèrent pas avec get ou post mais bien files. Un fichier envoyé comme ça aura une structure [
                    //   'name' => 'photo.jpg',
                    //   'type' => 'image/jpeg',
                    //   'tmp_name' => '/tmp/phpXyz.tmp',
                    //   'error' => 0,
                    //   'size' => 125000
                    // ] comme ça.
                    if (!empty($_POST["name"]) && !empty($_POST["price"]) && isset($_GET["id"]) && !empty($_GET["id"])) {
                        if (!empty($_FILES['image']['name'])) {
                            $id = $_GET["id"];
                            $category = $_SESSION["changes"]["categoryName"];
                            $oldImage = $this->model->getOldImage($_SESSION["changes"]["name"]);
                            $oldPath = 'img' . $oldImage['image'];
                            if (file_exists($oldPath)) {
                                unlink($oldPath);
                            }
                            $targetDir = '../public/img';
                            $fileName = "/" . $category . "/" . uniqid() . '-' . basename($_FILES['image']['name']);
                            $targetFilePath = $targetDir . $fileName;
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                                $this->model->updatePath($fileName, $id);

                            }
                        }

                        $id = trim(strip_tags($_GET["id"]));
                        $newName = trim(strip_tags($_POST["name"]));
                        $newPrice = trim(strip_tags($_POST["price"]));
                        $edited = $this->model->applyEditsProducts($newName, $newPrice, $id, $_POST["available"]);
                        if ($edited) {
                            unset($_SESSION["changes"]);
                            header("location: index.php?page=home");
                            exit();
                        } else {
                            $name = $_SESSION["changes"]["name"];
                            header("location:index.php?page=edit&name=$name");
                            exit();
                        }

                    } else {
                        $_SESSION["changes"]["errors"] = "Le nom et le prix ne peuvent être vides.";
                        $name = $_SESSION["changes"]["name"];
                        header("location:index.php?page=edit&name=$name");
                        exit();
                    }
                }
            } else if (isset($_GET["target"]) && $_GET["target"] === "description") {
                if (isset($_POST["description"]) && !empty($_POST["description"])) {
                    $description = trim(strip_tags($_POST["description"]));
                    $edited = $this->model->updateDescription($description, $_SESSION["changes"]["category"]);
                    if($edited){
                        unset($_SESSION["changes"]);
                        header("location: index.php?page=home");
                        exit();
                    }
                }
            }
        }else{
            header("location: index.php?page=login");
            exit();
        }
    }


}
?>