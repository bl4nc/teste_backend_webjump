<?php

namespace App\Controllers;

use App\Routes\Method;
use Exception;

class Controller extends Method
{

    function clearBody(array $body_data): array
    {   
        $body = [];
        foreach ($body_data ?? [] as $key => $data) {
            if (is_array($data)) {
                $clean_array = [];
                foreach ($data as $_key => $dt) {
                    $clean_array[$_key] = htmlentities($dt, ENT_COMPAT, 'utf-8');
                }
                $body[$key] = $clean_array;
            } else {
                $body[$key] = htmlentities($data, ENT_COMPAT, 'utf-8');
            }
        }
        return $body;
    }

    public function getBody(): array
    {
        if (count($_POST) == 0) {
            $body = json_decode(file_get_contents('php://input'), true);
        } else {
            $body = $_POST;
        }
        return $this->clearBody($body);
    }

    public function getQuery(): array
    {
        return $this->clearBody($_GET);
    }

    public function getFiles(): array
    {
        return $_FILES ?? [];
    }

    public function responseJson(int $status, array $response)
    {
        header("HTTP/1.1 " . $status);
        $error = json_encode($response);
        echo ($error);
        exit;
    }

    public function checkRequestFields(array $request_fields, array $passed_fields)
    {
        foreach ($request_fields as $request_field) {
            if (!array_key_exists($request_field, $passed_fields)) {
                header("HTTP/1.1 401");
                $error = json_encode(array(
                    "error" => true,
                    "message" => "Pass all fields."
                ));
                echo ($error);
                exit;
            }
        }
        foreach ($passed_fields as $value) {
            if (str_replace(" ", "", $value) == '' || empty(str_replace(" ", "", $value))) {
                header("HTTP/1.1 401");
                $error = json_encode(array(
                    "error" => true,
                    "message" => "Pass all fields."
                ));
                echo ($error);
                exit;
            }
        }
    }
}
