<?php

namespace app\core;

class Request
{
    public function method() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet() {
        return $this->method() === 'get';
    }

    public function isPost() {
        return $this->method() === 'post';
    }

    public function uri()
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function body()
    {
        $body = [];
        if ($this->isGet())
        {
            foreach ($_GET as $key => $value)
            {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } elseif ($this->isPost())
        {
            foreach ($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}