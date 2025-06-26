<?php
class ResetView
{
    private $controller;

    public function __construct(ResetController $controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        
        $this->controller->createToken();
        $this->controller->getToken();
        require(DIR_TEMPLATES . "reset.php");
    }
}
?>