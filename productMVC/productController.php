<?php
require_once 'ProductModel.php';

class ProductController
{
    private $model;

    public function __construct($database)
    {
        $this->model = new ProductModel($database);
    }

    public function getAllProducts()
    {
        return $this->model->getAllProducts();
    }
    public function getAllChemises()
    {
        return $this->model->getAllChemises();
    }
    public function getAllCravates()
    {
        return $this->model->getAllCravates();
    }
}
