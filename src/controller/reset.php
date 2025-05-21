<?php
require_once("../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

class ResetController
{

    private $model;

    public function __construct(ResetModel $model)
    {
        $this->model = $model;
    }

    public function createToken()
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ADMIN" && $_SESSION["user"]["ip"] === $_SERVER["REMOTE_ADDR"]) {
            if (isset($_POST["email"]) && !empty($_POST["email"])) {

                $_SESSION["resetPage"]["resetEmail"] = $_POST["email"];
                $email = trim(strip_tags($_POST["email"]));
                $verifiedEmail = $this->model->verifyEmail($email);
                if (!$verifiedEmail) {
                    $_SESSION["wrongEmail"] = "Aucun utilisateur connu sous cette adresse mail!";
                } else {
                    $_SESSION["validEmail"] = $verifiedEmail;

                    unset($_SESSION["wrongEmail"]);
                    $token = bin2hex(random_bytes(50));
                    $this->model->createToken($token, $verifiedEmail);

                    $newEmail = new PHPMailer();
                    $newEmail->isSMTP();
                    $newEmail->SMTPAuth = true;
                    $newEmail->Host = "sandbox.smtp.mailtrap.io";
                    $newEmail->Port = "2525";
                    $newEmail->Username = "4a2366424acf9e";
                    $newEmail->Password = "9758e324a193bc";
                    $newEmail->From = "bruno.fitte@sfr.fr";
                    $newEmail->FromName = "Bruno";
                    $newEmail->addAddress("bruno.fitte@sfr.fr");//Mettre adresse mail de l'admin
                    $newEmail->isHTML(true);
                    $newEmail->Subject = "Réinitialisation du mot de passe";
                    $newEmail->CharSet = "UTF_8";
                    $newEmail->Body = "<a href=\"http://localhost:8000/index.php?page=reset&token={$token}\">Réinitialiser votre mot de passe</a>";
                    if ($newEmail->send()) {
                        $_SESSION["send"] = "Un lien de réinitialisation vous a été envoyé par email. Il sera désactivé dans 15 minutes pour des raisons de sécurité.";
                        header("location: index.php?page=reset");
                        exit();
                    } else {
                        $_SESSION["wrongEmail"] = "Un problème est survenu lors de l'envoi de l'email, veuillez réessayer.";
                    }
                }

            } else if (isset($_POST["email"]) && empty($_POST["email"])) {
                $_SESSION["wrongEmail"] = "Aucun email renseigné.";
            }
        } else {
            header("location: index.php?page=login");
            exit();
        }

    }

    public function getToken()
    {
        if (isset($_GET["token"]) && !empty($_GET["token"])) {
            $this->model->cleanTokens();
            $token = trim(strip_tags($_GET["token"]));
            $realToken = $this->model->getToken($token);

            if ($realToken) {
                $this->createNewPassword();
            } else {
                $_SESSION["invalid"] = "Lien invalide ou expiré.";
                header("location: index.php");
                exit();
            }
        }
    }

    public function createNewPassword()
    {
        if (isset($_POST["password"]) && !empty($_POST["password"])) {
            $newPassword = trim(strip_tags($_POST["password"]));
            $newConfirmPassword = trim(strip_tags($_POST["confirmPassword"]));
            $errors = [];
            $uppercase = preg_match("/[A-Z]/", $newPassword);
            $numbers = preg_match("/[0-9]/", $newPassword);
            $special = preg_match("/[\W_]/", $newPassword);
            if (!$uppercase || !$numbers || !$special || strlen($newPassword) < 12) {
                $errors["password"] = "Le mot de passe doit contenir au moins 12 caractères dont une majuscule, un chiffre et un caractère spécial!";
            }

            if ($newPassword != $newConfirmPassword) {
                $errors["confirmPassword"] = "La confirmation du mot de passe à échoué.";
            }
            if (empty($newPassword) || empty($newConfirmPassword)) {
                $errors["empty"] = "Tous les champs doivent être remplis!";
            }
            $_SESSION["newErrors"] = $errors;
            if (empty($errors)) {
                $crypted_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $email = $_SESSION["validEmail"];
                if ($this->model->CreateNewPassword($email, $crypted_password)) {
                    unset($_SESSION["newErrors"]);
                    unset($_SESSION["validEmail"]);
                    unset($_SESSION["send"]);
                    unset($_SESSION["newPage"]);
                    header("location: index.php");
                    exit();
                } else {
                    $errors["creation"] = "Il y a eu un soucis avec l'enregistrement du compte.";
                }

            }
        }
    }

}
?>