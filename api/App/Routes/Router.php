<?php

namespace App\Routes;

use App\Routes\RouteSwitch;

class Router extends RouteSwitch
{
    private string $requestUri;
    private string $method;

    public function __construct(string $requestUri, string $method)
    {       
        $this->requestUri = substr(str_replace('api/', '', $requestUri), 1);
        if ($method === 'GET') $this->requestUri = explode('?',$this->requestUri)[0];
        $this->method = $method;
    }


    public function run()
    {

        $req = $this->requestUri;

        if ($req === '') {
            echo 'API runs';
        } else {
            try {
                $this->$req($this->method);
            } catch (\Throwable $th) {
                header("HTTP/1.1 404");
                $error = json_encode(array(
                    "error" => true,
                    "message" => "Route not found.",
                    "err"=>$th->getMessage()
                ));
                echo ($error);
                exit;
            }
        }
    }
}
