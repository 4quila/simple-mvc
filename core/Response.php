<?php

namespace app\core;

class Response
{
    public function statusCode(int $responseCode)
    {
        http_response_code($responseCode);
    }

    public function redirect(string $path)
    {
        header('Location: ' . $path);
    }
}