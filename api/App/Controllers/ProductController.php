<?php

namespace App\Controllers;

use App\DAO\CategoryDAO;
use App\DAO\ProductDAO;
use App\Model\CategoryModel;
use App\Model\ProductModel;
use App\Util\Util;

final class ProductController extends Controller
{

    public function insertProduct()
    {
        $picture = $this->getFiles()['picture'] ?? '';
        #Image Upload
        if ($picture != '') {
            if (explode('/', $picture['type'])[0] != 'image') {
                $this->responseJson(500, array(
                    "error" => true,
                    "message" => 'Invalid image format.'
                ));
            }
            $folder = __DIR__ . "/../../uploads/";
            $file = Util::moveFile($picture, $folder);
            if (!$file['success']) {
                $this->responseJson(500, array(
                    "error" => true,
                    "message" => $file['err']
                ));
            }
            $picture = $file['file_name'];
        }
        #
        $req_body = $this->getBody();
        $require_fields = ['name', 'sku', 'description', 'quantity', 'price', 'category'];
        $this->checkRequestFields($require_fields, $req_body);
        #Check categories
        foreach ($req_body['category'] as $code) {
            if (!intval($code)) $this->responseJson(500,  array(
                "error" => true,
                "message" => "Invalid code: " . $code
            ));
        }
        $categoryDAO = new CategoryDAO;
        $categories = implode(',', $req_body['category']);
        try {
            $select_data = $categoryDAO->SelectCategories($categories);
            if (count($select_data) != count($req_body['category'])) {
                foreach ($req_body['category'] as $code) {
                    $find = false;
                    foreach ($select_data as $data) {
                        if ($data['code'] === $code) $find = true;
                    }
                    if (!$find) {
                        $this->responseJson(500, array(
                            "error" => true,
                            "message" => "Category code: " . $code . " not found."
                        ));
                    }
                }
            }
        } catch (\Throwable $th) {
            if (!intval($code)) $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
        #
        $dao = new ProductDAO;
        try {
            $product = new ProductModel($req_body['name'], $req_body['sku'], $req_body['price'], $req_body['description'], $req_body['quantity'], $categories, $picture);
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
        $insert = $dao->InsertProduct($product);
        if ($insert['success']) {
            $this->responseJson(200, array(
                "success" => true,
                "message" => "Inserted."
            ));
        } else {
            if ($picture != '') unlink($folder . $picture);
            switch ($insert['err_code']) {
                case 23000:
                    $this->responseJson(500, array(
                        "error" => true,
                        "message" => 'SKU already entered.'
                    ));
                    break;
                default:
                    break;
            }
        }
    }

    public function deleteProduct()
    {
        $req_body = $this->getBody();
        $require_fields = ['sku'];
        $this->checkRequestFields($require_fields, $req_body);
        $dao = new ProductDAO;
        #Check if product exist.
        $product = $dao->SelectUniqueProduct($req_body['sku']);
        if (count($product) == 0) $this->responseJson(500, array(
            "error" => true,
            "message" => "Product not exist."
        ));
        if (!empty($product[0]['picture'])) {
            $folder = __DIR__ . "/../../uploads/";
            @unlink($folder . $product[0]['picture']);
        }
        try {
            $dao->DeleteProduct($req_body['sku']);
            $this->responseJson(200, array(
                "success" => true,
                "message" => "Deleted"
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function updateProduct()
    {
        $req_body = $this->getBody();
        $require_fields = ['sku', 'name'];
        $this->checkRequestFields($require_fields, $req_body);
        if (isset($req_body['picture'])) {
        }
        try {
            $dao = new ProductDAO;
            $old_product_data = $dao->SelectUniqueProduct($req_body['sku']);
            if (count($old_product_data)  === 0) $this->responseJson(500, array(
                "error" => true,
                "message" => "Invalid SKU."
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }

        if (isset($req_body['category'])) {
            #Check categories
            foreach ($req_body['category'] as $code) {
                if (!intval($code)) $this->responseJson(500,  array(
                    "error" => true,
                    "message" => "Invalid code: " . $code
                ));
            }
            #Validate categories
            $categoryDAO = new CategoryDAO;
            $categories = implode(',', $req_body['category']);
            try {
                $select_data = $categoryDAO->SelectCategories($categories);
                if (count($select_data) != count($req_body['category'])) {
                    foreach ($req_body['category'] as $code) {
                        $find = false;
                        foreach ($select_data as $data) {
                            if ($data['code'] === $code) $find = true;
                        }
                        if (!$find) {
                            $this->responseJson(500, array(
                                "error" => true,
                                "message" => "Category code: " . $code . " not found."
                            ));
                        }
                    }
                }
            } catch (\Throwable $th) {
                if (!intval($code)) $this->responseJson(500, array(
                    "error" => true,
                    "message" => $th->getMessage()
                ));
            }
        }

        $picture = $this->getFiles()['picture'] ?? '';
        #Image Upload
        if ($picture != '') {
            #Verify if exist a old picture 
            if (explode('/', $picture['type'])[0] != 'image') {
                $this->responseJson(500, array(
                    "error" => true,
                    "message" => 'Invalid image format.'
                ));
            }
            ###
            $folder = __DIR__ . "/../../uploads/";
            $file = Util::moveFile($picture, $folder);
            if (!$file['success']) {
                $this->responseJson(500, array(
                    "error" => true,
                    "message" => $file['err']
                ));
            }
            $picture = $file['file_name'];
        }
        $dao = new ProductDAO;
        $product = new ProductModel(
            $req_body['name'],
            $req_body['sku'],
            $req_body['price'] ?? $old_product_data[0]['price'],
            $req_body['description'] ?? $old_product_data[0]['description'],
            $req_body['quantity'] ?? $old_product_data[0]['quantity'],
            $categories ?? $old_product_data[0]['category'],
            $picture ?? $old_product_data[0]['picture']
        );
        try {
            $dao->updateProduct($product);
            $this->responseJson(200, array(
                "success" => true,
                "message" => "Updated product"
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
        #Remove old picture if insert a new picture.
        if ($picture != '' && !empty($old_product_data[0]['picture'])) {
            $folder = __DIR__ . "/../../uploads/";
            @unlink($folder . $old_product_data[0]['picture']);
        }
    }

    public function removePicture()
    {
        $req_body = $this->getBody();
        $require_fields = ['sku'];
        $this->checkRequestFields($require_fields, $req_body);
        try {
            $dao = new ProductDAO;
            $old_product_data = $dao->SelectUniqueProduct($req_body['sku']);
            if (count($old_product_data)  === 0) $this->responseJson(500, array(
                "error" => true,
                "message" => "Invalid SKU."
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
        if (empty($old_product_data[0]['picture'])) $this->responseJson(500, array(
            "error" => true,
            "message" => "Product has no image."
        ));
        $dao = new ProductDAO;
        try {
            $dao->removePicture($req_body['sku']);
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
        $folder = __DIR__ . "/../../uploads/";
        @unlink($folder . $old_product_data[0]['picture']);
        $this->responseJson(200, array(
            "success" => true,
            "message" => "Picture removed."
        ));
    }

    public function selectUniqueProduct()
    {
        $req_query = $this->getQuery();
        $require_fields = ['sku'];
        $this->checkRequestFields($require_fields, $req_query);
        $dao = new ProductDAO;
        try {
            $select_data = $dao->selectUniqueProduct($req_query['sku']);
            if (count($select_data) != 0) {
                $this->responseJson(200, array(
                    "success" => true,
                    "product" => $select_data[0]
                ));
            } else {
                $this->responseJson(200, array(
                    "success" => true,
                    "product" => []
                ));
            }
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th
            ));
        }
    }

    public function selectAllProducts()
    {
        $dao = new ProductDAO;
        try {
            $select_data = $dao->selectAllProducts();
            $products = [];
            foreach ($select_data as $data) {
                array_push($products, $data);
            }
            $this->responseJson(200, array(
                "success" => true,
                "products" => $products
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function selectProducts()
    {
        $req_query = $this->getQuery();
        $require_fields = ['sku'];

        $this->checkRequestFields($require_fields, $req_query);
        $skus = '';
        foreach ($req_query['sku'] as $sku) $skus .= "'" . $sku . "',";
        $skus = rtrim($skus, ",");

        $dao = new ProductDAO;
        try {
            $select_data = $dao->SelectProducts($skus);
            $products = [];
            foreach ($select_data as $data) {
                array_push($products, $data);
            }
            $this->responseJson(200, array(
                "success" => true,
                "products" => $products
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }
}
