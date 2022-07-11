<?php

namespace App\Controllers;

use App\DAO\CategoryDAO;
use App\Model\CategoryModel;

final class CategoryController extends Controller
{
    public function insertCategory()
    {
        $req_body = $this->getBody();
        $require_fields = ['name'];
        $this->checkRequestFields($require_fields, $req_body);
        $dao = new CategoryDAO;
        $category = new CategoryModel($req_body['name']);
        try {
            $category = $dao->InsertCategory($category);
            $this->responseJson(200, array(
                "success" => true,
                "message" => "Inserted."
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function deleteCategory()
    {
        $req_body = $this->getBody();
        $require_fields = ['code'];
        $this->checkRequestFields($require_fields, $req_body);
        $dao = new CategoryDAO;
        try {
            $dao->DeleteCategory($req_body['code']);
            $this->responseJson(200, array(
                "success" => true,
                "message" => 'Deleted.'
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function updateCategory()
    {
        $req_body = $this->getBody();
        $require_fields = ['code', 'name'];
        $this->checkRequestFields($require_fields, $req_body);
        $dao = new CategoryDAO;
        $category = new CategoryModel($req_body['name']);
        $category->setCode($req_body['code']);
        try {
            $dao->updateCategory($category);
            $this->responseJson(200, array(
                "success" => true,
                "message" => 'Updated.'
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function selectUniqueCategory()
    {
        $req_query = $this->getQuery();
        $require_fields = ['code'];
        $this->checkRequestFields($require_fields, $req_query);
        $dao = new CategoryDAO;
        try {
            $select_data = $dao->SelectUniqueCategory($req_query['code']);
            if (count($select_data) != 0) {
                $category = new CategoryModel($select_data[0]['name']);
                $category->setCode($req_query['code']);
                $category->setCreatedAt($select_data[0]['created_at']);
                $category->setUpdatedAt($select_data[0]['updated_at']);
                $this->responseJson(200, array(
                    "success" => true,
                    "category" => $category->getAllCategoryData()
                ));
            } else {
                $this->responseJson(200, array(
                    "success" => true,
                    "category" => []
                ));
            }
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function selectAllCategory()
    {
        $dao = new CategoryDAO;
        try {
            $select_data = $dao->SelectAllCategory();
            $categories = [];
            foreach ($select_data as $data) {
                array_push($categories, array(
                    "code" => $data['code'],
                    "name" => $data['name'],
                    "created_at" => $data['created_at'],
                    "updated_at" => $data['updated_at'],
                ));
            }
            $this->responseJson(200, array(
                "success" => true,
                "categories" => $categories
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }

    public function selectCategories()
    {
        $req_query = $this->getQuery();
        $require_fields = ['codes'];
        foreach ($req_query['codes'] as $code) {
            if (!intval($code)) $this->responseJson(500, array(
                "error" => true,
                "Invalid code: " . $code
            ));
        }
        $codes = implode(',', $req_query['codes']);
        $this->checkRequestFields($require_fields, $req_query);
        $dao = new CategoryDAO;
        try {
            $select_data = $dao->SelectCategories($codes);
            $categories = [];
            foreach ($select_data as $data) {
                array_push($categories, array(
                    "code" => $data['code'],
                    "name" => $data['name'],
                    "created_at" => $data['created_at'],
                    "updated_at" => $data['updated_at'],
                ));
            }
            $this->responseJson(200, array(
                "success" => true,
                "categories" => $categories
            ));
        } catch (\Throwable $th) {
            $this->responseJson(500, array(
                "error" => true,
                "message" => $th->getMessage()
            ));
        }
    }
}
