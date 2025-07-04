<?php

use Composer\Autoload\ClassLoader;
class EditController
{

    private $model;

    public function __construct(EditModel $model)
    {
        $this->model = $model;
    }

    public function getDatas()
    {
        if (!isset($_SESSION["user"]) || $_SESSION["user"]["function"] != "ADMIN" || $_SESSION["user"]["ip"] != $_SERVER["REMOTE_ADDR"]) {
            header("location: index.php");
            exit();
        } else {
            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                $id = trim(strip_tags($_GET["id"]));
                return $this->model->getDatasUser($id);
            } else if (isset($_GET["name"]) && !empty($_GET["name"]) && isset($_SESSION["changes"])) {
                if ($_GET["name"] === "description") {
                    return $this->model->getDescription($_SESSION["changes"]["category"]);
                } else {
                    $_SESSION['changes']["name"] = trim(strip_tags($_GET["name"]));
                    return $this->model->getDatasProduct($_GET["name"]);
                }
            } else {
                return [];
            }
        }
    }

    public function applyEditsUser()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_GET["target"]) && $_GET["target"] === "user") {

                if (!empty($_POST["lastname"]) && !empty($_POST["firstname"]) && !empty($_POST["email"]) && !empty($_POST["function"])) {
                    $_SESSION["edit"]["firstname"] = trim(strip_tags($_POST["firstname"]));
                    $_SESSION["edit"]["lastname"] = trim(strip_tags($_POST["lastname"]));
                    $_SESSION["edit"]["email"] = trim(strip_tags($_POST["email"]));
                    $_SESSION["edit"]["function"] = trim(strip_tags($_POST["function"]));
                    $edited = $this->model->applyEditsUser($_SESSION["edit"]["firstname"], $_SESSION["edit"]["lastname"], $_SESSION["edit"]["email"], $_SESSION["edit"]["function"], $_SESSION["edit"]["id"]);
                    if ($edited) {
                        unset($_SESSION["edit"]);
                        header("location:/home");
                        exit();
                    }
                } else {
                    $_SESSION["edit"]["errors"] = "Tous les champs doivent être remplis";
                    $id = $_SESSION["edit"]["id"];
                    header("location:/edit/id/$id");
                    exit();
                }
            }
        } else {
            header("location:/login");
            exit();
        }
    }

    public function applyEditsProducts()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_GET["target"]) && $_GET["target"] === "product") {
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
                            $tmpFilePath = $_FILES['image']['tmp_name'];
                            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
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
                                if (move_uploaded_file($tmpFilePath, $targetFilePath)) {
                                    $updated = $this->model->updatePath($fileName, $id);
                                    if (!$updated) {
                                        $_SESSION["changes"]["errors"] = "Une erreur a eu lieu lors de l'enregistrement des données.";
                                        $name = $_SESSION["changes"]["name"];
                                        header("location:/edit/name/$name");
                                        exit();
                                    }

                                }
                            } else {
                                $_SESSION["changes"]["errors"] = "Une erreur est survenue lors de la modification.";
                                $name = $_SESSION["changes"]["name"];
                                header("location:/edit/name/$name");
                                exit();
                            }

                        }

                        $id = trim(strip_tags($_GET["id"]));
                        $newName = trim(strip_tags($_POST["name"]));
                        $newPrice = trim(strip_tags($_POST["price"]));
                        $edited = $this->model->applyEditsProducts($newName, $newPrice, $id, $_POST["available"]);
                        if ($edited) {
                            unset($_SESSION["changes"]);
                            header("location:/home");
                            exit();
                        } else {
                            $_SESSION["changes"]["errors"] = "Une erreur a eu lieu lors de l'enregistrement des données.";
                            $name = $_SESSION["changes"]["name"];
                            header("location:/edit/name/$name");
                            exit();
                        }

                    } else {
                        $_SESSION["changes"]["errors"] = "Le nom et le prix ne peuvent être vides.";
                        $name = $_SESSION["changes"]["name"];
                        header("location:/edit/name/$name");
                        exit();
                    }
                }
            }
        } else {
            header("location:/login");
            exit();
        }
    }

    public function applyEditsDescription()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_POST["description"]) && !empty($_POST["description"])) {
                $description = trim(strip_tags($_POST["description"]));
                $edited = $this->model->updateDescription($description, $_SESSION["changes"]["category"]);
                if ($edited) {
                    unset($_SESSION["changes"]);
                    header("location:/home");
                    exit();
                }
            }
        } else {
            header("location:/login");
            exit();
        }
    }

    public function applyDeleteProduct()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_GET["target"]) && $_GET["target"] === "delete") {
                $id = trim(strip_tags($_GET["id"]));
                $oldImage = $this->model->getOldImage($_SESSION["changes"]["name"]);
                $oldPath = 'img' . $oldImage['image'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                if ($this->model->deleteProduct($id)) {
                    unset($_SESSION["changes"]);
                    header("location:/home");
                    exit();
                }
            }
        } else {
            header("location:/login");
            exit();
        }
    }

    public function applyAddProduct()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_GET["target"]) && $_GET["target"] === "addProduct") {
                if (!empty($_POST["name"]) && !empty($_POST["price"]) && !empty($_POST["available"]) && !empty($_FILES['image']['name'])) {
                    $tmpFilePath = $_FILES['image']['tmp_name'];
                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $category = $_SESSION["changes"]["category"];
                        $categoryName = $_SESSION["changes"]["categoryName"];
                        $name = trim(strip_tags($_POST["name"]));
                        $price = trim(strip_tags($_POST["price"]));
                        $available = trim(strip_tags($_POST["available"]));
                        $targetDir = '../public/img';
                        $fileName = "/" . $categoryName . "/" . uniqid() . '-' . basename($_FILES['image']['name']);
                        $targetFilePath = $targetDir . $fileName;
                        if (move_uploaded_file($tmpFilePath, $targetFilePath)) {
                            $edited = $this->model->addProduct($fileName, $name, $price, $category, $available);
                            if ($edited) {
                                unset($_SESSION["changes"]);
                                header("location:/home");
                                exit();
                            } else {
                                $_SESSION["changes"]["errors"] = "Une erreur a eu lieu lors de l'enregistrement des données.";
                                header("location:/edit/add/product");
                                exit();
                            }

                        }
                    } else {
                        $_SESSION["changes"]["errors"] = "Une erreur est survenue lors de l'enregistrement (ce type de fichier n'est pas accepté).";
                        $name = $_SESSION["changes"]["name"];
                        header("location:/edit/name/$name");
                        exit();
                    }


                } else {
                    $_SESSION["changes"]["name"] = trim(strip_tags($_POST["name"])) ?? "";
                    $_SESSION["changes"]["price"] = trim(strip_tags($_POST["price"])) ?? "";
                    $_SESSION["changes"]["errors"] = "Tous les champs doivent être remplis!";
                    header("location:/edit/add/product");
                    exit();
                }
            }
        } else {
            header("location:/login");
            exit();
        }
    }
}
?>