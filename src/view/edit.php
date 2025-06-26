<?php
class EditView{

    private $controller;

    public function __construct(EditController $controller){
        $this->controller = $controller;
    }
    public function render(){
        $this->controller->applyEditsUser();
        $this->controller->applyEditsProducts();
        $this->controller->applyEditsDescription();
        $this->controller->applyDeleteProduct();
        $this->controller->applyAddProduct();
        $datas = $this->controller->getDatas();
        require(DIR_TEMPLATES . "edit.php");

    }
}
?>