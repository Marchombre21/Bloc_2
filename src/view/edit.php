<?php
class EditView{

    private $controller;

    public function __construct(EditController $controller){
        $this->controller = $controller;
    }
    public function render(){
        $this->controller->applyEdits();
        $datas = $this->controller->getDatas();
        require(DIR_TEMPLATES . "edit.php");

    }
}
?>