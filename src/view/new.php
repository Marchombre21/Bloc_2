<?php
class NewView
{

    private $controller;

    public function __construct(NewController $controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        if (!empty($_POST)) {
            $this->controller->createAccount();
        }
        require(DIR_TEMPLATES . "new.php");
    }
}
?>