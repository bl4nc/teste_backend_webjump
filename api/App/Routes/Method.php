<?php

namespace App\Routes;

abstract class Method
{
    public function __construct(string $route_method, string $req_method)
    {
        if ($route_method !== $req_method) {
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
