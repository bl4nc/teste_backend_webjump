<?php
namespace App\DAO;

abstract class Connection
{
    protected $pdo;

    public function __construct()
    {
        $db_dir = __DIR__.'/bd.db';
        try {
        $this->pdo = new \PDO("sqlite:" . $db_dir);
        } catch (\Throwable $th) {
          header("HTTP/1.1 500");
            $error = json_encode(array(
                "error" => true,
                "message" => $th
            ));
            echo ($error);
            exit;
        }
    }
}
