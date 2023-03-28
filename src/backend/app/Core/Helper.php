<?php

namespace App\Core;

class Helper {
    public static function env(string $name): ?string
    {
        return $_ENV[$name] ?? null;
    }

    public static function isValidJSON(string $str): bool
    {
        json_decode($str);
        return json_last_error() == JSON_ERROR_NONE;
    }
}
