<?php
class ChangesView{

    private $controller;

    public function __construct(ChangesController $controller){
        $this->controller = $controller;
    }
    public function render(){
        $datas = $this->controller->getDatas();
        require(DIR_TEMPLATES . "changes.php");

    }
}
?>