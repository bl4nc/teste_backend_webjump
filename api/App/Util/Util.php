<?php

namespace App\Util;

use Ramsey\Uuid\Uuid;


abstract class Util
{
    public static function moveFile(array $file, string $folder): array
    {

        $file_format = explode('/', $file['type'])[1];
        $new_name = Uuid::uuid4() . "." . $file_format;
        try {
            (move_uploaded_file($file['tmp_name'],  $folder . $new_name));
            return array(
                "success" => true,
                "file_name" => $new_name
            );
        } catch (\Throwable $th) {
            return array(
                "success" => false,
                "message" => 'Upload failed.',
                "err_cod" => $file['error'],
                "err_message" => $th->getMessage()
            );
        }
    }

}
