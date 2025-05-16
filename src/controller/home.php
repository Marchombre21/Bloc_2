<?php
class HomeController
{

    private $model;

    public function __construct(HomeModel $model)
    {
        $this->model = $model;
    }
    
}
?>