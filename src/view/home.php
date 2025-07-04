<?php
class HomeView{

    private $controller;

    public function __construct(HomeController $controller){
        $this->controller = $controller;
    }
    public function render(){
        if(!isset($_SESSION["user"]) || $_SESSION["user"]["function"] != "ADMIN"){
            header("location: index.php");
        }
        
        require(DIR_TEMPLATES . "home.php");
    }
}
?>