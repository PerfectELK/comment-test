<?php

namespace App\Core;

class Request {

    private static ?Request $instance = null;
    public static function getInstance(): Request
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }



    public function post(): array
    {
        $jsonParams = file_get_contents("php://input");
        if (strlen($jsonParams) > 0 && Helper::isValidJSON($jsonParams)) {
            return json_decode($jsonParams, true);
        }
        return $_POST;
    }

}