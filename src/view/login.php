<?php
class LoginView{

    private $controller;

    public function __construct(LoginController $controller){
        $this->controller = $controller;
    }
    public function render(){
        if(isset($_POST) && !empty($_POST)){
            $this->controller->login();
        }
        require(DIR_TEMPLATES . "login.php");
    }
}
?>