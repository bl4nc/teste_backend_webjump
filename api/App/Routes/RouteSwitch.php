<?php

namespace App\Routes;

use App\Controllers\CategoryController;
use App\Controllers\ProductController;

abstract class RouteSwitch
{
    //Product Controllers
    protected function insert_product(string $req_method)
    {
        $controller = new ProductController('POST', $req_method);
        $controller->insertProduct();
    }
    protected function delete_product(string $req_method)
    {
        $controller = new ProductController('DELETE', $req_method);
        $controller->deleteProduct();
    }
     protected function update_product(string $req_method)
    {
        $controller = new ProductController('POST', $req_method);
        $controller->updateProduct();
    }
    protected function select_unique_product(string $req_method)
    {
        $controller = new ProductController('GET', $req_method);
        $controller->selectUniqueProduct();
    }
    protected function select_all_products(string $req_method)
    {
        $controller = new ProductController('GET', $req_method);
        $controller->selectAllProducts();
    }
    protected function select_products(string $req_method)
    {
        $controller = new ProductController('GET', $req_method);
        $controller->selectProducts();
    }
    protected function remove_picture(string $req_method)
    {
        $controller = new ProductController('PUT', $req_method);
        $controller->removePicture();
    }

    //Category Controllers
    protected function insert_category(string $req_method)
    {
        $controller = new CategoryController('POST', $req_method);
        $controller->insertCategory();
    }

    protected function delete_category(string $req_method)
    {
        $controller = new CategoryController('DELETE', $req_method);
        $controller->deleteCategory();
    }

    protected function update_category(string $req_method)
    {
        $controller = new CategoryController('PUT', $req_method);
        $controller->updateCategory();
    }

    protected function select_unique_category(string $req_method)
    {
        $controller = new CategoryController('GET', $req_method);
        $controller->selectUniqueCategory();
    }

    protected function select_all_category(string $req_method)
    {
        $controller = new CategoryController('GET', $req_method);
        $controller->selectAllCategory();
    }

    protected function select_categories(string $req_method)
    {
        $controller = new CategoryController('GET', $req_method);
        $controller->selectCategories();
    }
    
}
