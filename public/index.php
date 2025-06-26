<?php
session_start();

$_SESSION["page"] = "login";

if (isset($_GET["page"])) {
    $_SESSION["page"] = $_GET["page"];
}

if ($_SESSION["page"] == "disconnect") {
    session_destroy();
    header("location: index.php");
    exit();
}

$pages = [
    "login" => [
        "model" => "LoginModel",
        "controller" => "LoginController",
        "view" => "LoginView"
    ],
    "users" => [
        "model" => "UsersModel",
        "controller" => "UsersController",
        "view" => "UsersView"
    ],
    "home" => [
        "model" => "HomeModel",
        "controller" => "HomeController",
        "view" => "HomeView"
    ],
    "edit"=> [
        "model"=> "EditModel",
        "controller"=> "EditController",
        "view"=> "EditView"
    ],
    "reset"=> [
        "model"=> "ResetModel",
        "controller"=> "ResetController",
        "view"=> "ResetView"
    ],
    "new"=> [
        "model"=> "NewModel",
        "controller"=> "NewController",
        "view"=> "NewView"
    ],
    "changes"=> [
        "model"=> "ChangesModel",
        "controller"=> "ChangesController",
        "view"=> "ChangesView"
    ],
];

$find = false;
foreach ($pages as $key => $value) {
    if ($key === $_SESSION["page"]) {
        $find = true;
        $model = $value["model"];
        $controller = $value["controller"];
        $view = $value["view"];
    }
}
if ($find) {
    require "../config/config.php";
    require DIR_MODEL . $_SESSION["page"] . ".php";
    require DIR_CONTROLLER . $_SESSION["page"] . ".php";
    require DIR_VIEW . $_SESSION["page"] . ".php";
    
    $newModel = new $model($db);
    $newController = new $controller($newModel);
    $newView = new $view($newController);

    if ($_SESSION["page"] === "create_account" && !empty($_POST)) {
        $newController->createAccount($_POST["email"], $_POST["password"], $_POST["confirmEmail"], $_POST["confirmPassword"], $_POST["firstname"], $_POST["lastname"]);
    }

    $newView->render();

    if (isset($_SESSION["create"])) {
        unset($_SESSION["create"]);
    }

    if (isset($_SESSION["exists"])) {
        unset($_SESSION["exists"]);
    }
    if (isset($_SESSION["send"])) {
        unset($_SESSION["send"]);
    }
    if (isset($_SESSION["resetPage"])) {
        unset($_SESSION["resetPage"]);
    }
    if (isset($_SESSION["invalid"])) {
        unset($_SESSION["invalid"]);
    }
}
?>