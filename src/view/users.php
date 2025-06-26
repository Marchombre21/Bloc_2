<?php
class UsersView
{

    private $controller;

    public function __construct(UsersController $controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        $this->controller->deleteUser();   
        $users = $this->controller->getUsers();
        require(DIR_TEMPLATES . "users.php");
    }


}
?>