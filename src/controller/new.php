<?php
class NewController
{

    private $model;

    public function __construct(NewModel $model)
    {
        $this->model = $model;
    }

    public function createAccount()
    {
        
        $preExisting = $this->model->verifyExistingMail();
        if ($preExisting) {
            $_SESSION["exists"] = "Il y a déjà un compte qui utilise cet email.";
        } else {
            $errors = [];
            $uppercase = preg_match("/[A-Z]/", $_SESSION["create"]["password"]);
            $numbers = preg_match("/[0-9]/", $_SESSION["create"]["password"]);
            $special = preg_match("/[\W_]/", $_SESSION["create"]["password"]);
            if (!$uppercase || !$numbers || !$special || strlen($_SESSION["create"]["password"]) < 12) {
                $errors["password"] = "Le mot de passe doit contenir au moins 12 caractères dont une majuscule, un chiffre et un caractère spécial!";
            }
            if ($_SESSION["create"]["email"] != $_SESSION["create"]["confirmEmail"]) {
                $errors["confirmEmail"] = "La confirmation de l'email a échoué";
            }

            if ($_SESSION["create"]["password"] != $_SESSION["create"]["confirmPassword"]) {
                $errors["confirmPassword"] = "La confirmation du mot de passe à échoué.";
            }

            if (!filter_var($_SESSION["create"]["email"], FILTER_VALIDATE_EMAIL)) {
                $errors["email"] = "Cet email n'est pas valide!";
            }
            if (empty($_SESSION["create"]["firstname"]) || empty($_SESSION["create"]["lastname"]) || empty($_SESSION["create"]["password"]) || empty($_SESSION["create"]["email"])) {
                $errors["empty"] = "Tous les champs doivent être remplis!";
            }
            $_SESSION["errors"] = $errors;
            if (empty($errors)) {
                $crypted_password = password_hash($_SESSION["create"]["password"], PASSWORD_DEFAULT);
                if ($this->model->createAccount($crypted_password)) {
                    header("location: index.php?page=home");
                    exit();
                } else
                    $errors["creation"] = "Il y a eu un soucis avec l'enregistrement du compte.";
            }
        }
    }
}
?>